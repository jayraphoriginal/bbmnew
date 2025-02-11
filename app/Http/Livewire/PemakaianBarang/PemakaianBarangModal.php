<?php

namespace App\Http\Livewire\PemakaianBarang;

use App\Models\Barang;
use App\Models\DBarang;
use App\Models\Journal;
use App\Models\Kartustok;
use App\Models\Kategori;
use App\Models\MBiaya;
use App\Models\PemakaianBarang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;


class PemakaianBarangModal extends ModalComponent
{
    use LivewireAlert;

    public PemakaianBarang $pemakaian;
    public $editmode, $pemakaian_id;
    public $barang,$alat,$kendaraan;

    protected $rules=[
        'pemakaian.tgl_pemakaian' => 'required',
        'pemakaian.m_biaya_id' => 'required',
        'pemakaian.jenis_pembebanan' => 'required',
        'pemakaian.beban_id' => 'nullable',
        'pemakaian.barang_id' => 'required',
        'pemakaian.jumlah' => 'required',
        'pemakaian.total' => 'nullable',
        'pemakaian.keterangan' => 'required',
    ];

    protected $listeners = [
        'selectbarang' => 'selectbarang',
        'selectkendaraan' => 'selectkendaraan',
        'selectalat' => 'selectalat'
    ];

    public function selectkendaraan($id){
        $this->pemakaian->beban_id=$id;
    }
    public function selectalat($id){
        $this->pemakaian->beban_id=$id;
    }

    public function selectbarang($id){
        $this->pemakaian->barang_id = $id;
    }

    public function mount(){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Pemakaian Barang')){
            return abort(401);
        }

        if ($this->editmode=='edit') {
            $this->pemakaian = PemakaianBarang::find($this->pemakaian_id);
            $this->barang_id = PemakaianBarang::find($this->pemakaian->barang_id)->nama_barang;
        }else{
            $this->pemakaian = new PemakaianBarang();
        }

    }

    public function save(){

        $this->pemakaian->jumlah = str_replace(',', '', $this->pemakaian->jumlah);

        $this->validate();

        if ($this->pemakaian->jenis_pembebanan <> '-'){
            $this->validate([
                'pemakaian.beban_id' => 'required'
            ]);
        }

        $total = 0;
        $this->pemakaian->total = $total;
      

        DB::beginTransaction();
        try{

            $this->pemakaian->save();

            $jumlahstok = DBarang::where('barang_id',$this->pemakaian->barang_id)
                                ->sum('jumlah');

            $pemakaianstok = $this->pemakaian->jumlah;
            
                
            if ($jumlahstok < $pemakaianstok){
                $mbarang = Barang::find($this->pemakaian->barang_id);
                DB::Rollback();
                $this->alert('error', 'Stok '.$mbarang->nama_barang.' tidak mencukupi', [
                    'position' => 'center'
                ]);
                return;
            }else{
                $detailbarang = DBarang::where('barang_id',$this->pemakaian->barang_id)
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
                            

                            $jumlahstok = DBarang::where('barang_id',$this->pemakaian->barang_id)
                                ->sum('jumlah');

                            $kartustok = new Kartustok();
                            $kartustok['tanggal']=$this->pemakaian->tgl_pemakaian;
                            $kartustok['barang_id']=$this->pemakaian->barang_id;
                            $kartustok['tipe']='Pemakaian Barang';
                            $kartustok['trans_id']=$this->pemakaian->id;
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

                            $jumlahstok = DBarang::where('barang_id',$this->pemakaian->barang_id)
                                ->sum('jumlah');

                            $kartustok = new Kartustok();
                            $kartustok['tanggal']=$this->pemakaian->tgl_pemakaian;
                            $kartustok['barang_id']=$this->pemakaian->barang_id;
                            $kartustok['tipe']='Pemakaian Barang';
                            $kartustok['trans_id']=$this->pemakaian->id;
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

            $this->pemakaian->total = $total;
            $this->pemakaian->save();
            $coabiaya = MBiaya::find($this->pemakaian->m_biaya_id);
            $mbarang = Barang::find($this->pemakaian->barang_id); 
            $kategori = Kategori::find($mbarang->kategori_id);

            $journal = new Journal();
            $journal['tipe']='Pemakaian Barang';
            $journal['trans_id']=$this->pemakaian->id;
            $journal['tanggal_transaksi']=$this->pemakaian->tgl_pemakaian;
            $journal['coa_id']=$coabiaya->coa_id;
            $journal['debet']=$total;
            $journal['kredit']=0;
            $journal->save();

            $journal = new Journal();
            $journal['tipe']='Pemakaian Barang';
            $journal['trans_id']=$this->pemakaian->id;
            $journal['tanggal_transaksi']=$this->pemakaian->tgl_pemakaian;
            $journal['coa_id']=$kategori->coa_asset_id;
            $journal['debet']=0 ;
            $journal['kredit']=$total;
            $journal->save();

            DB::Commit();

            $this->closeModal();

            $this->alert('success', 'Save Success', [
                'position' => 'center'
            ]);

            $this->emitTo('pemakaian-barang.pemakaian-barang-table', 'pg:eventRefresh-default');

        }catch(Throwable $e){
            DB::rollBack();
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
        }
    }
    public function render()
    {
        return view('livewire.pemakaian-barang.pemakaian-barang-modal',[
            'biaya' => MBiaya::all()
        ]);
    }
}
