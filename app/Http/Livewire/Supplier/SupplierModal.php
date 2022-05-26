<?php

namespace App\Http\Livewire\Supplier;

use App\Models\Supplier;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class SupplierModal extends ModalComponent
{

    use LivewireAlert;

    public Supplier $supplier;
    public $editmode, $supplier_id;


    protected $rules=[
        'supplier.nama_supplier' => 'required',
        'supplier.npwp' => 'required',
        'supplier.alamat' => 'required',
        'supplier.notelp' => 'required',
        'supplier.nofax' => 'required',
        'supplier.nama_pemilik' => 'required',
        'supplier.jenis_usaha' => 'required',
    ];

    public function mount(){

        if ($this->editmode=='edit') {
            $this->supplier = Supplier::find($this->supplier_id);
        }else{
            $this->supplier = new Supplier();
        }

    }

    public function save(){

        $this->validate();

        $this->supplier->save();

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('supplier.supplier-table', 'pg:eventRefresh-default');

    }

    public function render()
    {
        return view('livewire.supplier.supplier-modal');
    }
}
