<?php

namespace App\Http\Livewire\Pembelian;

use App\Models\Barang;
use App\Models\DBarang;
use App\Models\DPurchaseorder;
use App\Models\Kartustok;
use App\Models\Mpajak;
use App\Models\MPurchaseorder;
use App\Models\Satuan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class PurchaseorderDetailModal extends ModalComponent
{

    use LivewireAlert;
    public DPurchaseorder $DPurchaseorder;
    public $editmode, $d_purchaseorder_id;
    public $barang, $satuan;
    public $po_id;

    protected $listeners = [
        'selectbarang' => 'selectbarang',
    ];

    protected $rules=[
        'DPurchaseorder.barang_id'=> 'required',
        'DPurchaseorder.jumlah'=> 'required',
        'DPurchaseorder.satuan_id'=> 'required',
        'DPurchaseorder.harga'=> 'required',
    ];

    public function mount($po_id){
        $this->po_id = $po_id;
        if ($this->editmode=='edit') {
            $this->DPurchaseorder = DPurchaseorder::find($this->d_purchaseorder_id);
            $barang = Barang::find($this->DPurchaseorder->barang_id);
            $this->barang = $barang->nama_barang;
            $this->satuan = Satuan::find($barang->satuan_id)->satuan;
        }else{
            $this->DPurchaseorder = new DPurchaseorder();
        }
    }

    public function selectbarang($id){
        $this->DPurchaseorder->barang_id=$id;
        $this->DPurchaseorder->satuan_id=Barang::find($id)->satuan_id;
        $this->satuan = Satuan::find($this->DPurchaseorder->satuan_id)->satuan;
    }

    public function selectrate($id){
        $this->DPurchaseorder->satuan_id=$id;
    }

    public function save(){

        
        $this->DPurchaseorder->harga = str_replace('.', '', $this->DPurchaseorder->harga);
        $this->DPurchaseorder->harga = str_replace(',', '.', $this->DPurchaseorder->harga);

        $this->DPurchaseorder->jumlah = str_replace('.', '', $this->DPurchaseorder->jumlah);
        $this->DPurchaseorder->jumlah = str_replace(',', '.', $this->DPurchaseorder->jumlah);

        $this->DPurchaseorder->m_purchaseorder_id = $this->po_id;
        $this->DPurchaseorder->status_detail = 'Open';
        $this->DPurchaseorder->user_id = Auth::user()->id;

        $this->validate();

        try{
            $this->DPurchaseorder->save();

            $MPurchaseorder = MPurchaseorder::find($this->DPurchaseorder->m_purchaseorder_id);

            $total = DB::table('d_purchaseorders')
            ->where('m_purchaseorder_id',$this->DPurchaseorder->m_purchaseorder_id)
            ->sum(DB::raw('harga * jumlah'));

            $datapajak = Mpajak::where('jenis_pajak','PPN')->first();

            if ($MPurchaseorder->tipe == 'PPN'){
                $dpp = $total / (1 + ($datapajak->persen / 100));
                $pajak = $dpp * $datapajak->persen / 100;
            }else{
                $dpp = $total;
                $pajak = 0;
            }

            $purchaseorder = MPurchaseorder::find($this->DPurchaseorder->m_purchaseorder_id);
            $purchaseorder['dpp'] = $dpp;
            $purchaseorder['ppn'] = $pajak;
            $purchaseorder['total'] = $total;
            $purchaseorder->save();

            $dbarang = DBarang::where('d_purchaseorder_id',$this->DPurchaseorder->id)
            ->where('barang_id', $this->DPurchaseorder->barang_id)->get();

            if ($MPurchaseorder->tipe == 'PPN'){
                $dppdetail = $this->DPurchaseorder->harga / (1 + ($datapajak->persen / 100));
            }else{
                $dppdetail = $this->DPurchaseorder->harga;
            }

            if (count($dbarang)>0){

                $editdbarang = DBarang::where('d_purchaseorder_id',$this->DPurchaseorder->id)
                ->where('barang_id', $this->DPurchaseorder->barang_id)->first();

                $newdbarang = DBarang::find($editdbarang->id);
                $newdbarang['barang_id'] = $this->DPurchaseorder->barang_id;
                $newdbarang['d_purchaseorder_id'] = $this->DPurchaseorder->id;
                $newdbarang['tgl_masuk'] = $MPurchaseorder->tgl_masuk;
                $newdbarang['jumlah_masuk'] = $this->DPurchaseorder->jumlah;
                $newdbarang['jumlah'] = $this->DPurchaseorder->jumlah;
                $newdbarang['hpp'] = $dppdetail;
                $newdbarang->save();

                $kartustok = Kartustok::where('trans_id',$this->DPurchaseorder->id)
                                ->where('barang_id', $this->DPurchaseorder->barang_id)->get();

                if (count($kartustok) >0){
                    $editkartustok = Kartustok::where('trans_id',$this->DPurchaseorder->id)
                    ->where('barang_id', $this->DPurchaseorder->barang_id)->first();

                    $newkartustok = Kartustok::find($editkartustok->id);
                    $newkartustok['increase']=$this->DPurchaseorder->jumlah;
                    $newkartustok['harga_debet']=$dppdetail;
                    $newkartustok->save();
                }

            }else{

                $newdbarang = new DBarang();
                $newdbarang['barang_id'] = $this->DPurchaseorder->barang_id;
                $newdbarang['d_purchaseorder_id'] = $this->DPurchaseorder->id;
                $newdbarang['tgl_masuk'] = $MPurchaseorder->tgl_masuk;
                $newdbarang['jumlah_masuk'] = $this->DPurchaseorder->jumlah;
                $newdbarang['jumlah'] = $this->DPurchaseorder->jumlah;
                $newdbarang['hpp'] = $dppdetail;
                $newdbarang->save();

                $jumlahstok = DBarang::where('barang_id',$this->DPurchaseorder->barang_id)
                                    ->sum('jumlah');

                $kartustok = new Kartustok();
                $kartustok['barang_id']=$this->DPurchaseorder->barang_id;
                $kartustok['tipe']='Pembelian';
                $kartustok['trans_id']=$this->DPurchaseorder->id;
                $kartustok['increase']=$this->DPurchaseorder->jumlah;
                $kartustok['decrease']=0;
                $kartustok['harga_debet']=$dppdetail;
                $kartustok['harga_kredit']=0;
                $kartustok['qty']=$jumlahstok;
                $kartustok['modal']=$dppdetail;
                $kartustok->save();
            }

        }
        catch(Throwable $e){
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
            return;
        }
       
        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('pembelian.purchaseorder-detail-table', 'pg:eventRefresh-default');
        $this->emitTo('pembelian.purchaseorder-table', 'pg:eventRefresh-default');

    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }

    public function render()
    {
        return view('livewire.pembelian.purchaseorder-detail-modal');
    }
}
