<?php

namespace App\Http\Livewire\Jurnal;

use App\Models\Journal;
use App\Models\ManualJournal;
use App\Models\Coa;
use App\Models\TmpJurnalManual;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class JurnalManualModal extends ModalComponent
{

    use LivewireAlert;

    public ManualJournal $jurnalmanual;

    protected $rules=[
        'jurnalmanual.tanggal' => 'required',
        'jurnalmanual.keterangan' => 'required',
    ];

    public function mount(){
        $this->jurnalmanual = new ManualJournal();
    }

    public function save(){

        $this->validate();
        $debet = TmpJurnalManual::where('user_id', Auth::user()->id)->sum('debet');
        $kredit = TmpJurnalManual::where('user_id', Auth::user()->id)->sum('kredit');

        $tmpjurnal = TmpJurnalManual::where('user_id', Auth::user()->id)->get();

        if ($debet<>$kredit || count($tmpjurnal) <= 0){
            $this->alert('error', 'Total debet tidak sama dengan kredit / Detail jurnal tidak ada', [
                'position' => 'center'
            ]);
        }else{

            DB::beginTransaction();
               
            try{

                $this->jurnalmanual->save();

                foreach($tmpjurnal as $tmp){
                    $journal = new Journal();
                    $journal['tipe']='Jurnal Manual';
                    $journal['trans_id']=$this->jurnalmanual->id;
                    $journal['tanggal_transaksi']=$this->jurnalmanual->tanggal;
                    $journal['coa_id']=$tmp->coa_id;
                    $journal['debet']=$tmp->debet;
                    $journal['kredit']=$tmp->kredit;
                    $journal->save();
                }

                ManualJournal::where('user_id',Auth::user()->id)->delete();

                DB::commit();

                $this->closeModal();

                $this->alert('success', 'Save Success', [
                    'position' => 'center'
                ]);

                $this->emitTo('jurnal.jurnal-manual-table', 'pg:eventRefresh-default');

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
        return view('livewire.jurnal.jurnal-manual-modal',[
            'coa' => Coa::where('level',5)->get()
        ]);
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }
}
