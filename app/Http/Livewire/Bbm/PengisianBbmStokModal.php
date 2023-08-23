<?php

namespace App\Http\Livewire\Bbm;

use App\Models\Barang;
use App\Models\DBarang;
use App\Models\Journal;
use App\Models\Kartustok;
use App\Models\Kategori;
use App\Models\MBiaya;
use App\Models\PengisianBbmStok;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class PengisianBbmStokModal extends ModalComponent
{
    use LivewireAlert;

    public PengisianBbmStok $pengisian;
    public $editmode, $pengisian_id;
    public $barang,$alat,$kendaraan;

    protected $rules=[
        'pengisian.tgl_pengisian' => 'required',
        'pengisian.beban_id' => 'required',
        'pengisian.barang_id' => 'required',
        'pengisian.jumlah' => 'required',
        'pengisian.total' => 'nullable',
        'pengisian.keterangan' => 'required',
    ];

    protected $listeners = [
        'selectbarang' => 'selectbarang',
        'selectkendaraan' => 'selectkendaraan',
        'selectalat' => 'selectalat'
    ];

    public function selectkendaraan($id){
        $this->pengisian->beban_id=$id;
    }
    public function selectalat($id){
        $this->pengisian->beban_id=$id;
    }

    public function selectbarang($id){
        $this->pengisian->barang_id = $id;
    }

    public function mount(){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Pengisian Bbm Stok')){
            return abort(401);
        }

        if ($this->editmode=='edit') {
            $this->pengisian = PengisianBbmStok::find($this->pengisian_id);
            $this->barang_id = PengisianBbmStok::find($this->pengisian->barang_id)->nama_barang;
        }else{
            $this->pengisian = new PengisianBbmStok();
        }

    }

    public function save(){

        $this->pengisian->jumlah = str_replace(',', '', $this->pengisian->jumlah);


        $this->validate();
        $this->pengisian->jenis_pembebanan = 'Beban Kendaraan';

        $biaya = MBiaya::where('nama_biaya','Biaya Bahan Bakar Minyak')->first();
        $this->pengisian->m_biaya_id = $biaya->id;

        $total = 0;
        $this->pengisian->total = $total;
        

        DB::beginTransaction();
        try{

            $this->pengisian->save();

            $jumlahstok = DBarang::where('barang_id',$this->pengisian->barang_id)
                                ->sum('jumlah');

            $pemakaianstok = $this->pengisian->jumlah;
            
                
            if ($jumlahstok < $pemakaianstok){
                $mbarang = Barang::find($this->pengisian->barang_id);
                DB::Rollback();
                $this->alert('error', 'Stok '.$mbarang->nama_barang.' tidak mencukupi', [
                    'position' => 'center'
                ]);
                return;
            }else{
                $detailbarang = DBarang::where('barang_id',$this->pengisian->barang_id)
                                ->where('jumlah', '>',0)
                                ->orderBy('tgl_masuk','asc')
                                ->get();

                foreach($detailbarang as $barang){

                    if ($pemakaianstok > 0){
                        if($pemakaianstok > $barang->jumlah){
                            
                            $stok = DBarang::find($barang->id);
                            $pemakaianstok = $pemakaianstok - $stok->jumlah;
                            $pengurangan = $stok->jumlah;
                            $stok['jumlah']=0;
                            $stok->save();
                            

                            $jumlahstok = DBarang::where('barang_id',$this->pengisian->barang_id)
                                ->sum('jumlah');

                            $kartustok = new Kartustok();
                            $kartustok['tanggal']=$this->pengisian->tgl_pengisian;
                            $kartustok['barang_id']=$this->pengisian->barang_id;
                            $kartustok['tipe']='Pengisian Bbm Stok';
                            $kartustok['trans_id']=$this->pengisian->id;
                            $kartustok['increase']=0;
                            $kartustok['decrease']=$pengurangan;
                            $kartustok['harga_debet']=0;
                            $kartustok['harga_kredit']=$stok->hpp;
                            $kartustok['qty']=$jumlahstok;
                            $kartustok['modal']=$stok->hpp;
                            $kartustok->save();

                            $total = $total + ($pengurangan * $stok->hpp);

                        }else{

                            $stok = DBarang::find($barang->id);
                            $stok['jumlah']=$stok['jumlah']-$pemakaianstok;
                            $stok->save();

                            $jumlahstok = DBarang::where('barang_id',$this->pengisian->barang_id)
                                ->sum('jumlah');

                            $kartustok = new Kartustok();
                            $kartustok['tanggal']=$this->pengisian->tgl_pengisian;
                            $kartustok['barang_id']=$this->pengisian->barang_id;
                            $kartustok['tipe']='Pengisian Bbm Stok';
                            $kartustok['trans_id']=$this->pengisian->id;
                            $kartustok['increase']=0;
                            $kartustok['decrease']=$pemakaianstok;
                            $kartustok['harga_debet']=0;
                            $kartustok['harga_kredit']=$stok->hpp;
                            $kartustok['qty']=$jumlahstok;
                            $kartustok['modal']=$stok->hpp;
                            $kartustok->save();

                            $total = $total + ($pemakaianstok * $stok->hpp);


                            $pemakaianstok = 0;
                        }
                    }
                }
            }     

            $this->pengisian->total = $total;
            $this->pengisian->save();
           
            $mbarang = Barang::find($this->pengisian->barang_id); 
            $kategori = Kategori::find($mbarang->kategori_id);

            $journal = new Journal();
            $journal['tipe']='Pengisian Bbm Stok';
            $journal['trans_id']=$this->pengisian->id;
            $journal['tanggal_transaksi']=$this->pengisian->tgl_pengisian;
            $journal['coa_id']=$biaya->coa_id;
            $journal['debet']=$total;
            $journal['kredit']=0;
            $journal->save();

            $journal = new Journal();
            $journal['tipe']='Pengisian Bbm Stok';
            $journal['trans_id']=$this->pengisian->id;
            $journal['tanggal_transaksi']=$this->pengisian->tgl_pengisian;
            $journal['coa_id']=$kategori->coa_asset_id;
            $journal['debet']=0 ;
            $journal['kredit']=$total;
            $journal->save();

            DB::Commit();

            $this->closeModal();

            $this->alert('success', 'Save Success', [
                'position' => 'center'
            ]);

            $this->emitTo('bbm.pengisian-bbm-stok-table', 'pg:eventRefresh-default');

        }catch(Throwable $e){
            DB::rollBack();
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.bbm.pengisian-bbm-stok-modal');
    }
}
