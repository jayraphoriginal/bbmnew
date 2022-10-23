<?php

namespace App\Http\Livewire\Rate;


use App\Models\JarakTempuh;
use App\Models\Rate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;

class RateModal extends ModalComponent
{

    use LivewireAlert;

    public Rate $rate;
    public $editmode='';
    public $rate_id;


    protected function rules() {
        return [
            'rate.jarak_tempuh_id' => 'required',
            'rate.lokasi_awal' => 'required',
            'rate.tujuan' => 'required',
            'rate.estimasi_jarak' => 'required',
        ];
    }

    public function mount(){
        if ($this->editmode=='edit') {
            $this->rate = Rate::find($this->rate_id);
        }else{
            $this->rate = new Rate();
        }
    }

    public function selectjaraktempuh($id){
        $this->rate->jarak_tempuh_id=$id;
    }

    public function save(){

        $this->validate();

        $this->rate->estimasi_jarak = str_replace(',', '', $this->rate->estimasi_jarak);


        $this->rate->save();

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('rate.rate-table', 'pg:eventRefresh-default');

    }

    public function render()
    {
        return view('livewire.rate.rate-modal',[
            'jaraktempuh' => JarakTempuh::all()
        ]);
    }
}
