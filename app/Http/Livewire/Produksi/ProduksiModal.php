<?php

namespace App\Http\Livewire\Produksi;

use App\Models\Barang;
use App\Models\DBarang;
use App\Models\DProduksi;
use App\Models\Kartustok;
use App\Models\MProduksi;
use App\Models\Satuan;
use App\Models\TmpProduksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class ProduksiModal extends ModalComponent
{
    use LivewireAlert;
    public MProduksi $produksi;
    public $driver, $barang, $satuan;
    public $view_mode, $produksi_id;

    protected $listeners = [
        'selectbarang' => 'selectbarang',
        'selectdriver' => 'selectdriver',
    ];

    protected $rules=[
        'produksi.barang_id'=> 'required',
        'produksi.jumlah'=> 'required',
        'produksi.satuan_id' => 'required',
        'produksi.keterangan'=> 'required',
        'produksi.biaya'=> 'required',
        'produksi.driver_id' => 'nullable'
    ];

    public function mount(){
        $this->produksi = new MProduksi();
    }

    public function selectbarang($id){
        $this->produksi->barang_id=$id;
        $barang = Barang::find($id);
        $this->produksi->satuan_id=$barang->satuan_id;
        $this->satuan = Satuan::find($this->produksi->satuan_id)->satuan;
    }
  
    public function selectdriver($id){
        $this->produksi->driver_id=$id;
    }

    public function save(){

        $this->validate();

        $this->produksi->biaya = str_replace(',', '', $this->produksi->biaya);

        $this->produksi->jumlah = str_replace(',', '', $this->produksi->jumlah);

        $tmp = TmpProduksi::where('user_id',Auth::user()->id)->get();

        if(count($tmp)<=0){
            $this->alert('warning','Isi detail produksi');
            return;
        }

        DB::beginTransaction();

        try{

            $this->produksi->hpp=0;
            $this->produksi->save();

            foreach($tmp as $komposisi){

                $pemakaianmaterial = $komposisi->jumlah;

                $jumlahstok = DBarang::where('barang_id',$komposisi->barang_id)
                                ->sum('jumlah');
                
                if ($jumlahstok < $pemakaianmaterial){
                    $barang = Barang::find($komposisi->barang_id);
                    DB::Rollback();
                    $this->alert('error', 'Stok '.$barang->nama_barang.' tidak mencukupi', [
                        'position' => 'center'
                    ]);
                    return;
                }else{
                    $detailbarang = DBarang::where('barang_id',$komposisi->barang_id)
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

                                $jumlahstok = DBarang::where('barang_id',$komposisi->barang_id)
                                    ->sum('jumlah');

                                $dproduksi = New DProduksi();
                                $dproduksi['produksi_id']=$this->produksi->id;
                                $dproduksi['barang_id']=$komposisi->barang_id;
                                $dproduksi['jumlah']=$pengurangan;
                                $dproduksi['satuan_id']=$komposisi->satuan_id;
                                $dproduksi['hpp']=$stok->hpp;
                                $dproduksi->save();

                                $kartustok = new Kartustok();
                                $kartustok['barang_id']=$komposisi->barang_id;
                                $kartustok['tipe']='Produksi';
                                $kartustok['trans_id']=$this->produksi->id;
                                $kartustok['increase']=0;
                                $kartustok['decrease']=$pengurangan;
                                $kartustok['harga_debet']=0;
                                $kartustok['harga_kredit']=$stok->hpp;
                                $kartustok['qty']=$jumlahstok;
                                $kartustok['modal']=$stok->hpp;
                                $kartustok->save();

                            }else{

                                $stok = DBarang::find($barang->id);
                                $stok['jumlah']=$stok['jumlah']-$pemakaianmaterial;
                                $stok->save();

                                $jumlahstok = DBarang::where('barang_id',$komposisi->barang_id)
                                    ->sum('jumlah');

                                $dproduksi = New DProduksi();
                                $dproduksi['produksi_id']=$this->produksi->id;
                                $dproduksi['barang_id']=$komposisi->barang_id;
                                $dproduksi['jumlah']=$pemakaianmaterial;
                                $dproduksi['satuan_id']=$komposisi->satuan_id;
                                $dproduksi['hpp']=$stok->hpp;
                                $dproduksi->save();

                                $kartustok = new Kartustok();
                                $kartustok['barang_id']=$komposisi->barang_id;
                                $kartustok['tipe']='Produksi';
                                $kartustok['trans_id']=$this->produksi->id;
                                $kartustok['increase']=0;
                                $kartustok['decrease']=$pemakaianmaterial;
                                $kartustok['harga_debet']=0;
                                $kartustok['harga_kredit']=$stok->hpp;
                                $kartustok['qty']=$jumlahstok;
                                $kartustok['modal']=$stok->hpp;
                                $kartustok->save();

                                $pemakaianmaterial = 0;

                            }
                        }
                    }
                }  
            }              
            $tmp = TmpProduksi::where('user_id',Auth::user()->id)->delete();

            $total = DProduksi::where('produksi_id',$this->produksi->id)
                    ->sum(DB::raw('jumlah*hpp'));
            $this->produksi->hpp = ($total + $this->produksi->biaya) / $this->produksi->jumlah;
            $this->produksi->save();

            $penambahanbarang = new DBarang();
            $penambahanbarang['barang_id']=$this->produksi->barang_id;
            $penambahanbarang['tgl_masuk'] = $this->produksi->created_at;
            $penambahanbarang['jumlah_masuk'] = $this->produksi->jumlah;
            $penambahanbarang['jumlah'] = $this->produksi->jumlah;
            $penambahanbarang['hpp'] =  $this->produksi->hpp;
            $penambahanbarang->save();

            $jumlahstok = DBarang::where('barang_id',$this->produksi->barang_id)
                                ->sum('jumlah');

            $kartustok = new Kartustok();
            $kartustok['barang_id']=$this->produksi->barang_id;
            $kartustok['tipe']='Produksi';
            $kartustok['trans_id']=$this->produksi->id;
            $kartustok['increase']=$this->produksi->jumlah;
            $kartustok['decrease']=0;
            $kartustok['harga_debet']=$this->produksi->hpp;
            $kartustok['harga_kredit']=0;
            $kartustok['qty']=$jumlahstok;
            $kartustok['modal']=$this->produksi->hpp;
            $kartustok->save();

            DB::commit();

        }catch(Throwable $e){
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
            return;
        }

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('produksi.produksi-table', 'pg:eventRefresh-default');

    }
    
    public static function modalMaxWidth(): string
    {
        return '7xl';
    }

    public function render()
    {
        return view('livewire.produksi.produksi-modal',
        ['produksi' => $this->produksi]);
    }

}
