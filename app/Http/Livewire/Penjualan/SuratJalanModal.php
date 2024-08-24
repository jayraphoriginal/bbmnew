<?php

namespace App\Http\Livewire\Penjualan;

use App\Models\Barang;
use App\Models\Customer;
use App\Models\DBarang;
use App\Models\DPenjualan;
use App\Models\Journal;
use App\Models\Kartustok;
use App\Models\Kategori;
use App\Models\MPenjualan;
use App\Models\SuratJalan;
use App\Models\SuratJalanDetail;
use App\Models\TmpPenjualan;
use App\Models\TmpSuratJalan;
use App\Models\VTmpSuratjalan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class SuratJalanModal extends ModalComponent
{
    use LivewireAlert;
    public $m_penjualan_id;
    public SuratJalan $suratjalan;

    public function mount($m_penjualan_id){
        $this->suratjalan = new SuratJalan();
        $this->m_penjualan_id = $m_penjualan_id;
        DB::table('tmp_surat_jalans')->where('user_id',Auth::user()->id)->delete();

        $dpenjualan = DPenjualan::where('m_penjualan_id', $this->m_penjualan_id)->get();

        foreach($dpenjualan as $item){
            $tmp = new TmpSuratJalan();
            $tmp['d_penjualan_id'] = $item->id;
            $tmp['jumlah'] = 0;
            $tmp['user_id'] = Auth::user()->id;
            $tmp->save();
        }

    }

    protected $rules=[
        'suratjalan.tgl_pengiriman'=> 'required',
        'suratjalan.tujuan'=> 'required',
        'suratjalan.nopol'=> 'required',
        'suratjalan.driver'=> 'required',
    ];

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }

    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo(' Surat Jalan')){
            return abort(401);
        }
       
        return view('livewire.penjualan.surat-jalan-modal');
    }

    public function save(){

        $this->validate();

        $mpenjualan = MPenjualan::find($this->m_penjualan_id);

        $this->suratjalan->customer_id = $mpenjualan->customer_id;
        $this->suratjalan->m_penjualan_id=$this->m_penjualan_id;

        $nomorterakhir = DB::table('surat_jalans')
                ->orderBy('id', 'DESC')->get();

            if (count($nomorterakhir) == 0){
                $nosuratjalan = '0001/SJ/'.date('m').'/'.date('Y');               
            }else{
                if (
                    substr($nomorterakhir[0]->nosuratjalan, 8, 2) == date('m')
                    &&
                    substr($nomorterakhir[0]->nosuratjalan, 11, 4) == date('Y')
                ) {
                    $noakhir = intval(substr($nomorterakhir[0]->nosuratjalan, 0, 4)) + 1;
                    $nosuratjalan = substr('0000' . $noakhir, -4) . '/SJ/' . date('m') . '/' . date('Y');
                } else {
                    $nosuratjalan = '0001/SJ/' . date('m') . '/' . date('Y');
                }
            }
        $this->suratjalan->nosuratjalan = $nosuratjalan;

        DB::beginTransaction();

        try{

            $this->suratjalan->save();

            $tmp = VTmpSuratjalan::where('m_penjualan_id', $this->m_penjualan_id)->where('user_id',Auth::user()->id)->get();


            foreach($tmp as $tmpbarang){

                if($tmpbarang->sisa < $tmpbarang->jumlah){
                    DB::Rollback();
                    $this->alert('error', 'Jumlah Diisi Melebihi Sisa Order', [
                        'position' => 'center'
                    ]);
                    return;
                }

                $pemakaianmaterial = $tmpbarang->jumlah;

                $jumlahstok = DBarang::where('barang_id',$tmpbarang->barang_id)
                                ->sum('jumlah');
                
                if ($jumlahstok < $pemakaianmaterial){
                    $barang = Barang::find($tmpbarang->barang_id);
                    DB::Rollback();
                    $this->alert('error', 'Stok '.$barang->nama_barang.' tidak mencukupi', [
                        'position' => 'center'
                    ]);
                    return;
                }else{
                    $detailbarang = DBarang::where('barang_id',$tmpbarang->barang_id)
                                    ->where('jumlah', '>',0)
                                    ->orderBy('tgl_masuk','asc')
                                    ->get();

                    foreach($detailbarang as $barang){

                        if ($pemakaianmaterial > 0){
                            if($pemakaianmaterial > $barang->jumlah){
                                
                                $stok = DBarang::find($barang->id);
                                $pemakaianmaterial = $pemakaianmaterial - $stok->jumlah;
                                $pengurangan = $stok->jumlah;
                                $stok['jumlah']=0;
                                $stok->save();

                                $jumlahstok = DBarang::where('barang_id',$tmpbarang->barang_id)
                                    ->sum('jumlah');

                                $suratjalandetail = New SuratJalanDetail();
                                $suratjalandetail['surat_jalan_id'] = $this->suratjalan->id;
                                $suratjalandetail['d_penjualan_id'] = $tmpbarang->d_penjualan_id;
                                $suratjalandetail['jumlah'] = $pengurangan;
                                $suratjalandetail->save();
                                // $dpenjualan = New DPenjualan();
                                // $dpenjualan['m_penjualan_id']=$this->MPenjualan->id;
                                // $dpenjualan['barang_id']=$tmpbarang->barang_id;
                                // $dpenjualan['jumlah']=$pengurangan;
                                // $dpenjualan['sisa']=$pengurangan;
                                // $dpenjualan['satuan_id']=$tmpbarang->satuan_id;
                                // $dpenjualan['harga_intax']=$tmpbarang->harga_intax;
                                // $dpenjualan['status_detail']='Open';
                                // $dpenjualan->save();

                                $dpenjualan = DPenjualan::find($tmpbarang->d_penjualan_id);
                                $dpenjualan['sisa'] = $dpenjualan['sisa'] - $pengurangan;
                                $dpenjualan->save();

                                $kartustok = new Kartustok();
                                $kartustok['tanggal'] = date_create($this->suratjalan->tgl_pengiriman)->format('Y-m-d');
                                $kartustok['barang_id']=$tmpbarang->barang_id;
                                $kartustok['tipe']='Surat Jalan';
                                $kartustok['trans_id']=$this->suratjalan->id;
                                $kartustok['increase']=0;
                                $kartustok['decrease']=$pengurangan;
                                $kartustok['harga_debet']=0;
                                $kartustok['harga_kredit']=$tmpbarang->harga_intax;
                                $kartustok['qty']=$jumlahstok;
                                $kartustok['modal']=$stok->hpp;
                                $kartustok->save();

                                $databarang = Barang::find($tmpbarang->barang_id);
                                $kategori = Kategori::find($databarang->kategori_id);

                                $journal = new Journal();
                                $journal['tipe']='Surat Jalan';
                                $journal['trans_id']=$this->suratjalan->id;
                                $journal['tanggal_transaksi']=date_create($this->suratjalan->tgl_pengiriman)->format('Y-m-d');
                                $journal['coa_id']=$kategori->coa_hpp_id;
                                $journal['debet']=round($stok->hpp*$pengurangan,4);
                                $journal['kredit']=0;
                                $journal->save();

                                $journal = new Journal();
                                $journal['tipe']='Surat Jalan';
                                $journal['trans_id']=$this->suratjalan->id;
                                $journal['tanggal_transaksi']=date_create($this->suratjalan->tgl_pengiriman)->format('Y-m-d');
                                $journal['coa_id']=$kategori->coa_asset_id;
                                $journal['debet']=0;
                                $journal['kredit']=round($stok->hpp*$pengurangan,4);
                                $journal->save();

                            }else{

                                $stok = DBarang::find($barang->id);
                                $stok['jumlah']=$stok['jumlah']-$pemakaianmaterial;
                                $stok->save();

                                $jumlahstok = DBarang::where('barang_id',$tmpbarang->barang_id)
                                    ->sum('jumlah');

                                // $dpenjualan = New DPenjualan();
                                // $dpenjualan['m_penjualan_id']=$this->MPenjualan->id;
                                // $dpenjualan['barang_id']=$tmpbarang->barang_id;
                                // $dpenjualan['jumlah']=$pemakaianmaterial;
                                // $dpenjualan['sisa']=$pemakaianmaterial;
                                // $dpenjualan['satuan_id']=$tmpbarang->satuan_id;
                                // $dpenjualan['harga_intax']=$tmpbarang->harga_intax;
                                // $dpenjualan['status_detail']='Open';
                                // $dpenjualan->save();

                                $dpenjualan = DPenjualan::find($tmpbarang->d_penjualan_id);
                                $dpenjualan['sisa'] = $dpenjualan['sisa'] - $pemakaianmaterial;
                                $dpenjualan->save();

                                $suratjalandetail = New SuratJalanDetail();
                                $suratjalandetail['surat_jalan_id'] = $this->suratjalan->id;
                                $suratjalandetail['d_penjualan_id'] = $tmpbarang->d_penjualan_id;
                                $suratjalandetail['jumlah'] = $pemakaianmaterial;
                                $suratjalandetail->save();

                                $kartustok = new Kartustok();
                                $kartustok['tanggal'] = date_create($this->suratjalan->tgl_pengiriman)->format('Y-m-d');
                                $kartustok['barang_id']=$tmpbarang->barang_id;
                                $kartustok['tipe']='Surat Jalan';
                                $kartustok['trans_id']=$this->suratjalan->id;
                                $kartustok['increase']=0;
                                $kartustok['decrease']=$pemakaianmaterial;
                                $kartustok['harga_debet']=0;
                                $kartustok['harga_kredit']=$tmpbarang->harga_intax;
                                $kartustok['qty']=$jumlahstok;
                                $kartustok['modal']=$stok->hpp;
                                $kartustok->save();

                                $databarang = Barang::find($tmpbarang->barang_id);
                                $kategori = Kategori::find($databarang->kategori_id);

                                $journal = new Journal();
                                $journal['tipe']='Surat Jalan';
                                $journal['trans_id']=$this->suratjalan->id;
                                $journal['tanggal_transaksi']=date_create($this->suratjalan->tgl_pengiriman)->format('Y-m-d');
                                $journal['coa_id']=$kategori->coa_hpp_id;
                                $journal['debet']=round($stok->hpp*$pemakaianmaterial,4);
                                $journal['kredit']=0;
                                $journal->save();

                                $journal = new Journal();
                                $journal['tipe']='Surat Jalan';
                                $journal['trans_id']=$this->suratjalan->id;
                                $journal['tanggal_transaksi']=date_create($this->suratjalan->tgl_pengiriman)->format('Y-m-d');
                                $journal['coa_id']=$kategori->coa_asset_id;
                                $journal['debet']=0;
                                $journal['kredit']=round($stok->hpp*$pemakaianmaterial,4);
                                $journal->save();

                                $pemakaianmaterial = 0;

                            }
                        }
                    }
                }  
            }              
            $tmp = TmpSuratJalan::where('user_id',Auth::user()->id)->delete();
            DB::commit();
        }
        catch(Throwable $e){
            DB::rollback();
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
            return;
        }
        $this->emitTo('penjualan.surat-jalan-table', 'pg:eventRefresh-default');
        $this->closemodal();
    }
}