<?php

namespace App\Http\Livewire\Mutubeton;

use App\Models\Barang;
use App\Models\PerhitunganHpp;
use LivewireUI\Modal\ModalComponent;

class PerhitunganHppModal extends ModalComponent
{

    public PerhitunganHpp $perhitunganHpp;
    public $editmode, $perhitungan_hpp_id, $barang;

    protected $listeners = ['selectbarang' => 'selectbarang'];

    protected $rules = [
        'perhitunganHpp.komponen' => 'required',
        'perhitunganHpp.kriteria' => 'required',
        'perhitunganHpp.perhitungan' => 'required',
        'perhitunganHpp.barang_id' => 'nullable',
        'perhitunganHpp.jumlah' => 'required',
        'perhitunganHpp.biaya_non' => 'required',
    ];
 
    public function mount(){
        if ($this->editmode == 'edit') {
            $this->perhitunganHpp = PerhitunganHpp::find($this->perhitungan_hpp_id);
            $this->barang = Barang::find($this->perhitunganHpp->barang_id)->nama_barang;
        } else {
            $this->perhitunganHpp = new PerhitunganHpp();
        }
    }    
    
    public function selectbarang($barang_id){
        $this->perhitunganHpp->barang_id = $barang_id;
    }   
    

    public function render()
    {
        return view('livewire.mutubeton.perhitungan-hpp-modal');
    }

    public function save(){

        $this->validate();

        $this->perhitunganHpp->jumlah = str_replace(',', '', $this->perhitunganHpp->jumlah);
        $this->perhitunganHpp->biaya_non = str_replace(',', '', $this->perhitunganHpp->biaya_non);

        try{
            $this->perhitunganHpp->save();

            $this->emitTo('mutubeton.perhitungan-hpp-table', 'pg:eventRefresh-default');
            $this->alert('success', 'Save Success', [
                'position' => 'center'
            ]);
            $this->closeModal();
        }catch(\Throwable $e){
            $this->alert('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

    }
}
