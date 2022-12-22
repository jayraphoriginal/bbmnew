<?php

namespace App\Http\Livewire\Mutubeton;

use App\Models\Mutubeton;
use Livewire\Component;

class MutubetonSelect extends Component
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
        $this->mutubeton = [];
    }

    public function selectdata($id)
    {
        $this->deskripsi = Mutubeton::find($id)->deskripsi;
        $this->emitTo('penjualan.salesorder-detail-modal','selectmutubeton', $id);
    }

    public function selectDeskripsi($id){
        $this->deskripsi = Mutubeton::find($id)->deskripsi;
    }

    public function updatedSearch()
    {
        $this->mutubeton = Mutubeton::where('status','aktif')
                        ->where(function($q) {
                            $q->where('kode_mutu', 'like', '%' . $this->search . '%')
                            ->orwhere('deskripsi', 'like', '%' . $this->search . '%');
                        })
                        ->get();
    }

    public function render()
    {
        return view('livewire.mutubeton.mutubeton-select');
    }
}
