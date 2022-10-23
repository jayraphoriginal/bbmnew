<?php

namespace App\Http\Livewire\Pembelian;

use App\Models\Alat;
use App\Models\Barang;
use App\Models\Coa;
use App\Models\DBarang;
use App\Models\DPurchaseorder;
use App\Models\Journal;
use App\Models\Kartustok;
use App\Models\Kategori;
use App\Models\Kendaraan;
use App\Models\Mpajak;
use App\Models\MPurchaseorder;
use App\Models\Supplier;
use App\Models\TmpPembelian;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class PurchaseorderModal extends ModalComponent
{
    use LivewireAlert;
    public MPurchaseorder $Mpo;
    public $editmode, $po_id;
    public $supplier, $kendaraan, $alat;
    public $kode_biaya;

    protected $listeners = [
        'selectsupplier' => 'selectsupplier',
        'selectkendaraan' => 'selectkendaraan',
        'selectalat' => 'selectalat'
    ];

    protected $rules=[
        'Mpo.nofaktur'=> 'required',
        'Mpo.tgl_masuk'=> 'required',
        'Mpo.tipe' => 'required',
        'Mpo.jatuh_tempo'=> 'required',
        'Mpo.supplier_id'=> 'required',
        'Mpo.pembebanan'=> 'required',
        'kode_biaya' => 'nullable',
        'Mpo.jenis_pembebanan'=> 'nullable',
        'Mpo.beban_id' => 'nullable'
    ];

    public function mount(){

        if ($this->editmode=='edit') {
            $this->Mpo = MPurchaseorder::find($this->po_id);
            $this->supplier = Supplier::find($this->Mpo->supplier_id)->nama_supplier;
        }else{
            $this->Mpo = new MPurchaseorder();
        }

    }

    public function selectsupplier($id){
        $this->Mpo->supplier_id=$id;
    }
    public function selectkendaraan($id){
        $this->Mpo->beban_id=$id;
    }
    public function selectalat($id){
        $this->Mpo->beban_id=$id;
    }

    public function save(){

        $this->validate();

        if(!is_null($this->kode_biaya)){
            $this->Mpo->jenis_pembebanan = Coa::where('kode_akun',$this->kode_biaya)->first()->id;
        }

        if ($this->editmode!='edit') {
            $nomorterakhir = DB::table('m_purchaseorders')
                ->orderBy('id', 'DESC')->get();

            if (count($nomorterakhir) == 0){
                $nopo = '0001/PO/'.date('m').'/'.date('Y');               
            }else{
                if (
                    substr($nomorterakhir[0]->nopo, 8, 2) == date('m')
                    &&
                    substr($nomorterakhir[0]->nopo, 11, 4) == date('Y')
                ) {
                    $noakhir = intval(substr($nomorterakhir[0]->nopo, 0, 4)) + 1;
                    $nopo = substr('0000' . $noakhir, -4) . '/PO/' . date('m') . '/' . date('Y');
                } else {
                    $nopo = '0001/PO/' . date('m') . '/' . date('Y');
                }
            }
            $this->Mpo->nopo = $nopo;
            $this->Mpo->status= 'Open';
        }

        $tmpdata = TmpPembelian::where('user_id', Auth::user()->id)->get();

        if (count($tmpdata)<1){
            DB::rollBack();
            $this->alert('error', 'Isi Barang', [
                'position' => 'center'
            ]);
        }
        else{
            DB::beginTransaction();
            try{
            
                $tmps = TmpPembelian::where('user_id', Auth::user()->id)->get();

                $total = DB::table('tmp_pembelians')
                ->where('user_id',Auth::user()->id)
                ->sum(DB::raw('harga * jumlah'));

                $datapajak = Mpajak::where('jenis_pajak','PPN')->first();

                if ($this->Mpo->tipe == 'PPN'){
                    $dpp = $total / (1 + ($datapajak->persen / 100));
                    $pajak = $dpp * $datapajak->persen / 100;
                }else{
                    $dpp = $total;
                    $pajak = 0;
                }

                $this->Mpo->dpp = $dpp;
                $this->Mpo->ppn = $pajak;
                $this->Mpo->total = $total;
                $this->Mpo->sisa = $total;
                $this->Mpo->save();

                foreach($tmps as $tmp){

                    $dpurchaseorder = new DPurchaseorder();
                    $dpurchaseorder['m_purchaseorder_id']=$this->Mpo->id;
                    $dpurchaseorder['barang_id']=$tmp->barang_id;
                    $dpurchaseorder['jumlah']=$tmp->jumlah;
                    $dpurchaseorder['satuan_id']=$tmp->satuan_id;
                    $dpurchaseorder['harga']=$tmp->harga;
                    $dpurchaseorder['status_detail']=$tmp->status_detail;
                    $dpurchaseorder['user_id']=Auth::user()->id;
                    $dpurchaseorder->save();

                    if($this->Mpo->pembebanan=='Stok'){
                        if ($this->Mpo->tipe == 'PPN'){
                            $dppdetail = $tmp->harga / (1 + ($datapajak->persen / 100));
                        }else{
                            $dppdetail = $tmp->harga;
                        }

                        $newdbarang = new DBarang();
                        $newdbarang['barang_id'] = $tmp->barang_id;
                        $newdbarang['d_purchaseorder_id'] = $dpurchaseorder->id;
                        $newdbarang['tgl_masuk'] = $this->Mpo->tgl_masuk;
                        $newdbarang['jumlah_masuk'] = $tmp->jumlah;
                        $newdbarang['jumlah'] = $tmp->jumlah;
                        $newdbarang['hpp'] = $dppdetail;
                        $newdbarang->save();

                        $jumlahstok = DBarang::where('barang_id',$dpurchaseorder->barang_id)
                                            ->sum('jumlah');

                        $kartustok = new Kartustok();
                        $kartustok['tanggal'] = date_create($this->Mpo->tgl_masuk)->format('Y-m-d');
                        $kartustok['barang_id']=$tmp->barang_id;
                        $kartustok['tipe']='Pembelian';
                        $kartustok['trans_id']=$dpurchaseorder->id;
                        $kartustok['increase']=$tmp->jumlah;
                        $kartustok['decrease']=0;
                        $kartustok['harga_debet']=$dppdetail;
                        $kartustok['harga_kredit']=0;
                        $kartustok['qty']=$jumlahstok;
                        $kartustok['modal']=$dppdetail;
                        $kartustok->save();

                        $barang = Barang::find($tmp->barang_id);
                        $kategori = Kategori::find($barang->kategori_id);

                        //Jurnal Persediaan
                        $journal = new Journal();
                        $journal['tipe']='Purchase Order';
                        $journal['trans_id']=$this->Mpo->id;
                        $journal['tanggal_transaksi']=$this->Mpo->tgl_masuk;
                        $journal['coa_id']=$kategori->coa_asset_id;
                        $journal['debet']=$dppdetail*$tmp->jumlah;
                        $journal['kredit']=0;
                        $journal->save();

                        if ($this->Mpo->tipe == 'PPN'){

                            //Jurnal Pajak
                            $journal = new Journal();
                            $journal['tipe']='Purchase Order';
                            $journal['trans_id']=$this->Mpo->id;
                            $journal['tanggal_transaksi']=$this->Mpo->tgl_masuk;
                            $journal['coa_id']=$datapajak->coa_id_debet;
                            $journal['debet']=($tmp->harga-$dppdetail)*$tmp->jumlah;
                            $journal['kredit']=0;
                            $journal->save();
                        }
                    }
                }

                if($this->Mpo->pembebanan=='Langsung'){

                    $journal = new Journal();
                    $journal['tipe']='Purchase Order';
                    $journal['trans_id']=$this->Mpo->id;
                    $journal['tanggal_transaksi']=$this->Mpo->tgl_masuk;
                    $journal['coa_id']=$this->Mpo->jenis_pembebanan;
                    $journal['debet']=$dpp;
                    $journal['kredit']=0;
                    $journal->save();

                    if ($this->Mpo->tipe == 'PPN'){

                        $journal = new Journal();
                        $journal['tipe']='Purchase Order';
                        $journal['trans_id']=$this->Mpo->id;
                        $journal['tanggal_transaksi']=$this->Mpo->tgl_masuk;
                        $journal['coa_id']=$datapajak->coa_id_debet;
                        $journal['debet']=$total-$dpp;
                        $journal['kredit']=0;
                        $journal->save();
                    }
                }

                $supplier = Supplier::find($this->Mpo->supplier_id);

                $journal = new Journal();
                $journal['tipe']='Purchase Order';
                $journal['trans_id']=$this->Mpo->id;
                $journal['tanggal_transaksi']=$this->Mpo->tgl_masuk;
                $journal['coa_id']=$supplier->coa_id;
                $journal['debet']=0;
                $journal['kredit']=$total;
                $journal->save();

                $tmps = TmpPembelian::where('user_id', Auth::user()->id)->delete();

                DB::Commit();

                $this->po_id = $this->Mpo->id;
            
                $this->closeModal();

                $this->alert('success', 'Save Success', [
                    'position' => 'center'
                ]);

                $this->emitTo('pembelian.purchaseorder-table', 'pg:eventRefresh-default');
            }
            catch(Throwable $e){
                DB::rollBack();
                $this->alert('error', $e->getMessage(), [
                    'position' => 'center'
                ]);
            }
        }
    }

    public function render()
    {
        return view('livewire.pembelian.purchaseorder-modal',[
            'coa' => Coa::where('header_akun','601000')->get()
        ]);
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }
}
