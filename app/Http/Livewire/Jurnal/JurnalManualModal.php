<?php

namespace App\Http\Livewire\Jurnal;

use App\Models\Journal;
use App\Models\ManualJournal;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class JurnalManualModal extends ModalComponent
{

    use LivewireAlert;

    public ManualJournal $jurnalmanual;

    protected $rules=[
        'jurnalmanual.id_coa_debet' => 'required',
        'jurnalmanual.id_coa_kredit' => 'required',
        'jurnalmanual.jumlah' => 'required',
        'jurnalmanual.keterangan' => 'required',
    ];

    public function mount(){
        $this->jurnalmanual = new ManualJournal();
    }

    public function save(){

        $this->validate();

        $this->jumlah = str_replace('.', '', $this->jumlah);
        $this->jumlah = str_replace(',', '.',$this->jumlah );

        DB::beginTransaction();

        try{

            $this->jurnalmanual->save();
            //Jurnal Debet 
            $journal = new Journal();
            $journal['tipe']='Jurnal Manual';
            $journal['trans_id']=$this->jurnalmanual->id;
            $journal['tanggal_transaksi']=$this->jurnalmanual->created_at;
            $journal['coa_id']=$this->jurnalmanual->id_coa_debet;
            $journal['debet']=$this->jurnalmanual->jumlah;
            $journal['kredit']=0;
            $journal->save();
            
            $journal = new Journal();
            $journal['tipe']='Jurnal Manual';
            $journal['trans_id']=$this->jurnalmanual->id;
            $journal['tanggal_transaksi']=$this->jurnalmanual->created_at;
            $journal['coa_id']=$this->jurnalmanual->id_coa_kredit;
            $journal['debet']=0;
            $journal['kredit']=$this->jurnalmanual->jumlah;
            $journal->save();

            DB::commit();

            $this->alert('success', 'Save Success', [
                'position' => 'center'
            ]);

        }
        catch(Throwable $e){
            DB::rollBack();
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
        }

    }

    public function render()
    {
        return view('livewire.jurnal.jurnal-manual-modal');
    }
}
