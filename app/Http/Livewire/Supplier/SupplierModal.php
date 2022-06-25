<?php

namespace App\Http\Livewire\Supplier;

use App\Models\Coa;
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
        'supplier.coa_id' => 'nullable'
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

        if ($this->editmode != 'edit'){
            $nomorterakhir = Coa::where('header_akun','220.000')
                    ->orderBy('kode_akun', 'DESC')->get();
            
            if (count($nomorterakhir) == 0){
                $kodeakun = '220.001';
            }else{
                $noakhir = intval(substr($nomorterakhir[0]->kode_akun, 0, 3)) + 1;
                $kodeakun = '220.'.substr('000' . $noakhir, -3);
            }
           
            $coa = New Coa();
            $coa['kode_akun'] = $kodeakun;
            $coa['nama_akun'] = $this->supplier->nama_supplier;
            $coa['level'] = 3;
            $coa['tipe'] = 'Detail';
            $coa['posisi'] = 'Neraca';
            $coa['header_akun'] = '220.000';
            $coa->save();
        }else{
            $coa = Coa::find($this->supplier->coa_id);
            $coa['nama_akun'] = $this->supplier->nama_supplier;
            $coa->save();
        }

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
