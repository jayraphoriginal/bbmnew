<?php

namespace App\Http\Livewire\Penjualan;

use App\Models\Customer;
use App\Models\Driver;
use App\Models\Kendaraan;
use App\Models\Mpajak;
use App\Models\MSalesorder;
use Brick\Math\BigInteger;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\DB;
use Throwable;

class SalesorderModal extends ModalComponent
{
    use LivewireAlert;
    public MSalesorder $MSalesorder;
    public $editmode;
    public $salesorder_id;
    public $customer;

    protected $listeners = ['selectcustomer' => 'selectcustomer'];

    protected $rules=[
        'MSalesorder.nopo'=> 'required',
        'MSalesorder.tgl_so'=> 'required',
        'MSalesorder.marketing'=> 'required',
        'MSalesorder.pembayaran'=> 'required',
        'MSalesorder.jenis_pembayaran'=> 'required',
        'MSalesorder.jatuh_tempo'=> 'required',
        'MSalesorder.customer_id'=> 'required',
    ];

    public function mount(){

        if ($this->editmode=='edit') {
            $this->MSalesorder = MSalesorder::find($this->salesorder_id);
            $this->customer = Customer::find($this->MSalesorder->customer_id)->nama_customer;
        }else{
            $this->MSalesorder = new MSalesorder();
            $this->salesorder_id = 0;
        }

    }

    public function selectcustomer($id){
        $this->MSalesorder->customer_id=$id;
    }

    public function save(){

        $this->validate();
        if ($this->editmode!='edit') {
            $nomorterakhir = DB::table('m_salesorders')
                ->orderBy('id', 'DESC')->get();

            if (count($nomorterakhir) == 0){
                $noso = '0001/PC/'.date('m').'/'.date('Y');               
            }else{
                if (
                    substr($nomorterakhir[0]->noso, 8, 2) == date('m')
                    &&
                    substr($nomorterakhir[0]->noso, 11, 4) == date('Y')
                ) {
                    $noakhir = intval(substr($nomorterakhir[0]->noso, 0, 4)) + 1;
                    $noso = substr('0000' . $noakhir, -4) . '/PC/' . date('m') . '/' . date('Y');
                } else {
                    $noso = '0001/PC/' . date('m') . '/' . date('Y');
                }
            }

            $pajak = Mpajak::where('jenis_pajak','PPN')->first();

            $this->MSalesorder->noso = $noso;
            $this->MSalesorder->status_so = 'Open';
            $this->MSalesorder->pajak = $pajak->persen;
        }
        try{
            $this->MSalesorder->save();
        }
        catch(Throwable $e){
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
            return;
        }
        
        $this->salesorder_id = $this->MSalesorder->id;
        
        $this->emit("openModal", "penjualan.salesorder-detail-modal",[$this->salesorder_id]);

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('penjualan.salesorder-table', 'pg:eventRefresh-default');

    }

    public function render()
    {
        return view('livewire.penjualan.salesorder-modal');
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }
}
