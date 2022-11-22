<?php

namespace App\Http\Livewire\Bbm;

use App\Models\Journal;
use App\Models\MBiaya;
use App\Models\PengisianBbm;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;

class PengisianBbmModal extends ModalComponent
{
    use LivewireAlert;

    public PengisianBbm $pengisian;
    public $editmode, $pengisian_id;
    public $supplier, $kendaraan, $driver, $bahanbakar;

    protected $listeners = [
        'selectsupplier' => 'selectsupplier',
        'selectkendaraan' => 'selectkendaraan',
        'selectdriver' => 'selectdriver',
        'selectbahanbakar' => 'selectbahanbakar',
    ];

    protected $rules=[
        'pengisian.tanggal_pengisian' => 'required',
        'pengisian.supplier_id' => 'required',
        'pengisian.kendaraan_id' => 'required',
        'pengisian.driver_id' => 'required',
        'pengisian.bahan_bakar_id' => 'required',
        'pengisian.jumlah' => 'required',
        'pengisian.harga' => 'required',
        'pengisian.total' => 'nullable',
        'pengisian.sisa' => 'nullable'
    ];

    public function mount(){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Pengisian BBM')){
            return abort(401);
        }

        if ($this->editmode=='edit') {
            $this->pengisian = PengisianBbm::find($this->pengisian_id);
        }else{
            $this->pengisian = new PengisianBbm();
        }

    }

    public function selectsupplier($id){
        $this->pengisian->supplier_id=$id;
    }

    public function selectkendaraan($id){
        $this->pengisian->kendaraan_id=$id;
    }

    public function selectdriver($id){
        $this->pengisian->driver_id=$id;
    }

    public function selectbahanbakar($id){
        $this->pengisian->bahan_bakar_id=$id;
    }

    public function save(){

        $this->pengisian->harga = str_replace(',', '', $this->pengisian->harga);

        $this->pengisian->jumlah = str_replace(',', '', $this->pengisian->jumlah);
        $total = $this->pengisian->harga * $this->pengisian->jumlah;
        $this->pengisian->total = $total;
        $this->pengisian->sisa = $total;
        
        $this->validate();

        $this->pengisian->save();

        $biaya = MBiaya::where('nama_biaya','Biaya Kendaraan')->first();

        $journal = new Journal();
        $journal['tipe']='Pengisian BBM';
        $journal['trans_id']=$this->pengisian->id;
        $journal['tanggal_transaksi']=$this->pengisian->tanggal_pengisian;
        $journal['coa_id']=$biaya->coa_id;
        $journal['debet']=$total;
        $journal['kredit']=0;
        $journal->save();

        $supplier = Supplier::find($this->pengisian->supplier_id);

        $journal = new Journal();
        $journal['tipe']='Pengisian BBM';
        $journal['trans_id']=$this->pengisian->id;
        $journal['tanggal_transaksi']=$this->pengisian->tanggal_pengisian;
        $journal['coa_id']=$supplier->coa_id;
        $journal['debet']=0;
        $journal['kredit']=$total;
        $journal->save();

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('bbm.pengisian-bbm-table', 'pg:eventRefresh-default');

    }

    public function render()
    {
        return view('livewire.bbm.pengisian-bbm-modal');
    }
}
