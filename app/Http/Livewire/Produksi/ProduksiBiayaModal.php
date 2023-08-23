<?php

namespace App\Http\Livewire\Produksi;

use App\Models\MBiaya;
use App\Models\TmpBiayaProduksi;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class ProduksiBiayaModal extends ModalComponent
{

    use LivewireAlert;

    public TmpBiayaProduksi $tmp;
    public $tmp_id, $nama_biaya, $editmode;

    protected $rules=[
        'tmp.biaya_id' => 'required',
        'tmp.jumlah' => 'required',
        'tmp.keterangan' => 'required'
    ];

    public function mount(){
        if ($this->editmode=='edit') {
            $this->tmp = TmpBiayaProduksi::find($this->tmp_id);
            $biaya = MBiaya::find($this->tmp->biaya_id);
            $this->nama_biaya = $biaya->nama_biaya;

        }else{
            $this->tmp = new TmpBiayaProduksi();
        }
    }

    public function save(){

        $this->tmp->jumlah = str_replace(',', '', $this->tmp->jumlah);
        $this->tmp->user_id = Auth::user()->id;

        $this->validate();

        try{
            
            $this->tmp->save();

        }
        catch(Throwable $e){
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
            return;
        }
       
        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('produksi.tmp-biaya-produksi-table', 'pg:eventRefresh-default');
    }
    public function render()
    {
        return view('livewire.produksi.produksi-biaya-modal',[
            'biaya' => MBiaya::all(),
        ]);
    }
}
