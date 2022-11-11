<?php

namespace App\Http\Livewire\Pajak;

use App\Models\Mpajak;
use Livewire\Component;

class PajakSelect extends Component
{

    public $search;
    public $pajak;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->pajak = [];
    }

    public function selectdata($id)
    {
        $this->deskripsi = Mpajak::find($id)->jenis_pajak;
        $this->emitTo('pengeluaran-biaya.pengeluaran-biaya-component','selectpajak', $id);
    }

    public function selectDeskripsi($id){
        $this->deskripsi = Mpajak::find($id)->jenis_pajak;
    }

    public function updatedSearch()
    {
        $this->pajak = Mpajak::where('jenis_pajak', 'like', '%' . $this->search . '%')
            ->get();
    }
    public function render()
    {
        return view('livewire.pajak.pajak-select');
    }
}
