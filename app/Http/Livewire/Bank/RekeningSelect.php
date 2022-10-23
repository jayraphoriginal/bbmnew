<?php

namespace App\Http\Livewire\Bank;

use App\Models\Rekening;
use Livewire\Component;

class RekeningSelect extends Component
{

    public $search;
    public $rekening;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->rekening = [];
    }

    public function selectdata($id)
    {
        $rekening =  Rekening::find($id);
        $this->deskripsi = $rekening->norek.' - '.$rekening->atas_nama;
        $this->emitTo('invoice.invoice-modal','selectrekening', $id);
        $this->emitTo('pembayaran.pembayaran-pembelian-modal','selectrekening', $id);
    }

    public function selectDeskripsi($id){
        $rekening =  Rekening::find($id);
        $this->deskripsi = $rekening->norek.' - '.$rekening->atas_nama;
    }

    public function updatedSearch()
    {
        if ($this->search == ''){
            $this->rekening = Rekening::all();
        }else{
            $this->rekening = Rekening::where('norek', 'like', '%' . $this->search . '%')
                ->orwhere('atas_nama', 'like', '%' . $this->search . '%')
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.bank.rekening-select');
    }
}
