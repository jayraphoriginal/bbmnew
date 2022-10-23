<?php

namespace App\Http\Livewire\Penjualan;

use App\Models\Barang;
use App\Models\DBarang;
use App\Models\Kartustok;
use App\Models\PenjualanRetail;
use App\Models\Satuan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class PenjualanRetailModal extends ModalComponent
{
    use LivewireAlert;
    public PenjualanRetail $penjualanretail;
    public $editmode, $penjualanretail_id;
    public $barang, $satuan;
    public $m_salesorder_id;

    protected $listeners = [
        'selectbarang' => 'selectbarang',
    ];

    protected $rules=[
        'penjualanretail.barang_id'=> 'required',
        'penjualanretail.jumlah'=> 'required',
        'penjualanretail.satuan_id'=> 'required',
        'penjualanretail.harga'=> 'required',
    ];

    public function mount($m_salesorder_id){
        $this->m_salesorder_id = $m_salesorder_id;
        $this->penjualanretail = new PenjualanRetail();
    }

    public function selectbarang($id){
        $this->penjualanretail->barang_id=$id;
        $this->penjualanretail->satuan_id=Barang::find($id)->satuan_id;
        $this->satuan = Satuan::find($this->penjualanretail->satuan_id)->satuan;
    }

    public function save(){

        
        $this->penjualanretail->harga = str_replace(',', '', $this->penjualanretail->harga);

        $this->penjualanretail->jumlah = str_replace(',', '', $this->penjualanretail->jumlah);

        $this->penjualanretail->m_salesorder_id = $this->m_salesorder_id;
        $this->penjualanretail->status_detail = 'Open';
        $this->penjualanretail->user_id = Auth::user()->id;

        $this->validate();

        DB::beginTransaction();

        try{
            
            $this->penjualanretail->save();

            // $jumlahstok = DBarang::where('barang_id',$this->penjualanretail->barang_id)
            //                     ->sum('jumlah');

            // $pemakaianstok = $this->penjualanretail->jumlah;
                
            // if ($jumlahstok < $pemakaianstok){
            //     $barang = Barang::find($this->penjualanretail->barang_id);
            //     DB::Rollback();
            //     $this->alert('error', 'Stok '.$barang->nama_barang.' tidak mencukupi', [
            //         'position' => 'center'
            //     ]);
            //     return;
            // }else{
            //     $detailbarang = DBarang::where('barang_id',$this->penjualanretail->barang_id)
            //                     ->where('jumlah', '>',0)
            //                     ->orderBy('tgl_masuk','asc')
            //                     ->get();

            //     foreach($detailbarang as $barang){

            //         if ($pemakaianstok > 0){
            //             if($pemakaianstok > $barang->jumlah){
                            
            //                 $stok = DBarang::find($barang->id);
            //                 $pemakaianstok = $pemakaianstok - $stok->jumlah;
            //                 $pengurangan = $stok->jumlah;
            //                 $stok['jumlah']=0;
            //                 $stok->save();

            //                 $jumlahstok = DBarang::where('barang_id',$this->penjualanretail->barang_id)
            //                     ->sum('jumlah');

            //                 $kartustok = new Kartustok();
            //                 $kartustok['barang_id']=$this->penjualanretail->barang_id;
            //                 $kartustok['tipe']='Penjualan Retail';
            //                 $kartustok['trans_id']=$this->penjualanretail->id;
            //                 $kartustok['increase']=0;
            //                 $kartustok['decrease']=$pengurangan;
            //                 $kartustok['harga_debet']=0;
            //                 $kartustok['harga_kredit']=$stok->hpp;
            //                 $kartustok['qty']=$jumlahstok;
            //                 $kartustok['modal']=$stok->hpp;
            //                 $kartustok->save();

            //             }else{

            //                 $stok = DBarang::find($barang->id);
            //                 $stok['jumlah']=$stok['jumlah']-$pemakaianstok;
            //                 $stok->save();

            //                 $jumlahstok = DBarang::where('barang_id',$this->penjualanretail->barang_id)
            //                     ->sum('jumlah');

            //                 $kartustok = new Kartustok();
            //                 $kartustok['barang_id']=$this->penjualanretail->barang_id;
            //                 $kartustok['tipe']='Penjualan Retail';
            //                 $kartustok['trans_id']=$this->penjualanretail->id;
            //                 $kartustok['increase']=0;
            //                 $kartustok['decrease']=$pemakaianstok;
            //                 $kartustok['harga_debet']=0;
            //                 $kartustok['harga_kredit']=$stok->hpp;
            //                 $kartustok['qty']=$jumlahstok;
            //                 $kartustok['modal']=$stok->hpp;
            //                 $kartustok->save();

            //                 $pemakaianstok = 0;
            //             }
            //         }
            //     }
            // }        
            DB::commit();
        }
        catch(Throwable $e){
            DB::rollBack();
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

    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }

    public function render()
    {
        return view('livewire.penjualan.penjualan-retail-modal');
    }
}
