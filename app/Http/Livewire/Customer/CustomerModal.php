<?php

namespace App\Http\Livewire\Customer;

use App\Models\Customer;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class CustomerModal extends ModalComponent
{

    use LivewireAlert;

    public Customer $customer;
    public $editmode, $customer_id;


    protected $rules=[
        'customer.nama_customer' => 'required',
        'customer.npwp' => 'required',
        'customer.alamat' => 'required',
        'customer.notelp' => 'required',
        'customer.nofax' => 'required',
        'customer.nama_pemilik' => 'required',
        'customer.jenis_usaha' => 'required',
    ];

    public function mount(){

        if ($this->editmode=='edit') {
            $this->customer = Customer::find($this->customer_id);
        }else{
            $this->customer = new Customer();
        }

    }

    public function save(){

        $this->validate();

        $this->customer->save();

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('customer.customer-table', 'pg:eventRefresh-default');

    }

    public function render()
    {
        return view('livewire.customer.customer-modal');
    }
}
