<?php

namespace App\Http\Livewire\Penerimaan;

use App\Models\Rekening;
use App\Models\VPenerimaan;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class PencairanWarkatMasuk extends ModalComponent
{

    use LivewireAlert;
 
    public $penerimaan_id, $tgl_cair, $jatuh_tempo, $nowarkat, $jumlah, $rekening_id;
 
    public function mount($penerimaan_id){
        $this->penerimaan_id = $penerimaan_id;
        $penerimaan = VPenerimaan::find($penerimaan_id);
        $this->jatuh_tempo = $penerimaan->jatuh_tempo;
        $this->nowarkat = $penerimaan->nowarkat;
        $this->jumlah = $penerimaan->jumlah;
    }

    protected $rules =[
        'tgl_cair'=> 'required',
        'rekening_id' => 'required'
    ];

    public function render()
    {
        return view('livewire.penerimaan.pencairan-warkat-masuk',[
            'rekening' => Rekening::join('banks','rekenings.bank_id','banks.id')->select('rekenings.*','banks.kode_bank')->get(),
        ]);
    }

    public function save(){

        $this->validate();

        $bank_id = Rekening::find($this->rekening_id)->bank_id;

        DB::beginTransaction();

        try{

            DB::update("Exec SP_Pencairan_Warkat_Masuk ".$this->penerimaan_id.",'".
            $this->tgl_cair."',".
            $bank_id.",".
            $this->rekening_id);

            DB::commit();
            $this->alert('success', 'Save Success', [
                'position' => 'center'
            ]);
            $this->closeModal();
            $this->emitTo('penerimaan.warkat-masuk-table', 'pg:eventRefresh-default');
        }
        catch(Throwable $e){
            DB::rollBack();
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
            $this->closeModal();
            return;
        }
        
    }
}
