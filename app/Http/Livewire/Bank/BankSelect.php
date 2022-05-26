<?php

namespace App\Http\Livewire\Bank;

use App\Models\Bank;
use Livewire\Component;

class BankSelect extends Component
{

    public $search;
    public $bank;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->bank = [];
    }

    public function selectdata($id)
    {
        $this->deskripsi = Bank::find($id)->nama_bank;
        $this->emitTo('bank.rekening-modal','selectbank', $id);

    }

    public function selectDeskripsi($id){
        $this->deskripsi = Bank::find($id)->nama_bank;
    }

    public function updatedSearch()
    {
        $this->bank = Bank::where('nama_bank', 'like', '%' . $this->search . '%')
            ->orwhere('kode_bank', 'like', '%' . $this->search . '%')
            ->get();
    }

    public function render()
    {
        return view('livewire.bank.bank-select');
    }
}
