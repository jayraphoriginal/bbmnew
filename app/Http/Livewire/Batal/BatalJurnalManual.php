<?php

namespace App\Http\Livewire\Batal;

use App\Models\ManualJournal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class BatalJurnalManual extends ModalComponent
{
    public $manual_journal_id, $keterangan;
    use LivewireAlert;

    public function mount(){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Pembatalan Jurnal Manual')){
            return abort(401);
        }
        $manualjurnal = ManualJournal::find($this->manual_journal_id);
        $this->keterangan = $manualjurnal->keterangan;
    }

    public function save(){

        $this->validate([
            'manual_journal_id' => 'required'
        ]);

        DB::beginTransaction();

        try{

            DB::table('journals')->where('tipe','Jurnal Manual')->where('trans_id', $this->manual_journal_id)->delete();
            $manualjurnal = ManualJournal::find($this->manual_journal_id);
            $manualjurnal->delete();

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

        $this->emitTo('jurnal.jurnal-manual-table', 'pg:eventRefresh-default');

    }

    public function render()
    {
        return view('livewire.batal.batal-jurnal-manual');
    }
}
