<?php

namespace App\Http\Livewire\Supplier;

use App\Models\Customer;
use App\Models\Supplier;
use Livewire\Component;

class SupplierSelect extends Component
{

    public $search;
    public $supplier;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->supplier = [];
    }

    public function selectdata($id)
    {
        $this->deskripsi = Supplier::find($id)->nama_supplier;
        $this->emitTo('pembelian.purchaseorder-modal','selectsupplier', $id);
        $this->emitTo('bbm.pengisian-bbm-modal','selectsupplier', $id);
    }

    public function selectDeskripsi($id){
        $this->deskripsi = Supplier::find($id)->nama_supplier;
    }

    public function updatedSearch()
    {
        $this->supplier = Supplier::where('nama_supplier', 'like', '%' . $this->search . '%')
            ->get();
    }

    public function render()
    {
        return view('livewire.supplier.supplier-select');
    }
}
