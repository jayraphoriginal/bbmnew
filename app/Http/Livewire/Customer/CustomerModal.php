<?php

namespace App\Http\Livewire\Customer;

use App\Models\Coa;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

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
        'customer.penyetoran_ppn' => 'required',
        'customer.penyetoran_pph' => 'required'
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
        DB::beginTransaction();
        try{
            if ($this->editmode != 'edit'){
                $nomorterakhir = Coa::where('header_akun','110000')
                        ->orderBy('kode_akun', 'DESC')->get();
                
                if (count($nomorterakhir) == 0){
                    $kodeakun = '110001';
                }else{
                    $noakhir = intval(substr($nomorterakhir[0]->kode_akun, 3)) + 1;
                    $kodeakun = '11'.substr('0000' . $noakhir, -4);
                }
            
                $coa = New Coa();
                $coa['kode_akun'] = $kodeakun;
                $coa['nama_akun'] = $this->customer->nama_customer;
                $coa['level'] = 5;
                $coa['tipe'] = 'Detail';
                $coa['posisi'] = 'Asset';
                $coa['header_akun'] = '110000';
                $coa->save();
                $this->customer->coa_id = $coa->id;
            }else{
                $coa = Coa::find($this->customer->coa_id);
                $coa['nama_akun'] = $this->customer->nama_customer;
                $coa->save();
            }
            
            $this->customer->save();
            DB::commit();

            $this->closeModal();

            $this->alert('success', 'Save Success', [
                'position' => 'center'
            ]);
        }catch(Throwable $e){
            DB::rollBack();
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
        }

        $this->emitTo('customer.customer-table', 'pg:eventRefresh-default');

    }

    public function render()
    {
        return view('livewire.customer.customer-modal');
    }
}
