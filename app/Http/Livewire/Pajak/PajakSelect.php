<?php

namespace App\Http\Livewire\Pajak;

use App\Models\Mpajak;
use Livewire\Component;

class PajakSelect extends Component
{

    public $search;
    public $mutubeton;
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
        $this->deskripsi = Mutubeton::find($id)->kode_mutu;
    }

    public function updatedSearch()
    {
        $this->mutubeton = Mutubeton::where('kode_mutu', 'like', '%' . $this->search . '%')
            ->get();
    }
    public function render()
    {
        return view('livewire.pajak.pajak-select');
    }
}
