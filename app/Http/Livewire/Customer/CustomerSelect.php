<?php

namespace App\Http\Livewire\Customer;

use App\Models\Customer;
use Livewire\Component;

class CustomerSelect extends Component
{

    public $search;
    public $customer;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->customer = [];
    }

    public function selectdata($id)
    {
        $this->deskripsi = Customer::find($id)->nama_customer;
        $this->emitTo('penjualan.salesorder-modal','selectcustomer', $id);
        $this->emitTo('sewa.salesorder-sewa-modal','selectcustomer', $id);
        $this->emitTo('penjualan.penjualan-modal','selectcustomer', $id);
    }

    public function selectDeskripsi($id){
        $this->deskripsi = Customer::find($id)->nama_customer;
    }

    public function updatedSearch()
    {
        $this->customer = Customer::where('nama_customer', 'like', '%' . $this->search . '%')
            ->get();
    }

    public function render()
    {
        return view('livewire.customer.customer-select');
    }
}
