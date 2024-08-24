<?php

namespace App\Http\Livewire\Batal;

use App\Models\VSuratJalanHeader;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class BatalSuratjalan extends ModalComponent
{
    public $suratjalan_id, $nopol, $driver, $detailsj;
    use LivewireAlert;

    protected $listeners = [
        'selectsj' => 'selectsj',
    ];

    public function mount(){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Pembatalan Surat Jalan')){
            return abort(401);
        }
    }

    public function selectsj($id){
        $this->suratjalan_id=$id;
        $suratjalan = VSuratJalanHeader::find($id);
        $this->driver = $suratjalan->driver;
        $this->nopol = $suratjalan->nopol;
        $this->detailsj = $suratjalan->nosuratjalan.' - '.$suratjalan->nama_customer;
    }

    public function save(){

        $this->validate([
            'suratjalan_id' => 'required'
        ]);

        DB::beginTransaction();

        try{

            DB::statement('SET NOCOUNT ON; Exec SP_BatalSuratJalan '.$this->suratjalan_id);

            DB::commit();
            $this->closeModal();

            $this->alert('success', 'Save Success', [
                'position' => 'center'
            ]);
        }catch(Throwable $e){
            DB::rollback();
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
        }

    }
    public function render()
    {
        return view('livewire.batal.batal-suratjalan');
    }
}
