<?php

namespace App\Http\Livewire\Sewa;

use App\Models\Itemsewa;
use Livewire\Component;

class ItemsewaSelect extends Component
{
    public $search;
    public $itemsewa;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->itemsewa = [];
    }

    public function selectdata($id)
    {
        $this->deskripsi = Itemsewa::find($id)->nama_item;
        $this->emitTo('sewa.salesorder-sewa-detail-modal','selectitemsewa', $id);
    }

    public function selectDeskripsi($id){
        $this->deskripsi = Itemsewa::find($id)->nama_item;
    }

    public function updatedSearch()
    {
        $this->itemsewa = Itemsewa::where('nama_item', 'like', '%' . $this->search . '%')
            ->get();
    }

    public function render()
    {
        return view('livewire.sewa.itemsewa-select');
    }
}
