<?php

namespace App\Http\Livewire\Sewa;

use App\Models\Customer;
use App\Models\Mpajak;
use App\Models\MSalesorderSewa;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class SalesorderSewaModal extends ModalComponent
{
    use LivewireAlert;
    public MSalesorderSewa $MSalesorder;
    public $editmode, $salesorder_id;
    public $customer;

    protected $listeners = ['selectcustomer' => 'selectcustomer'];

    protected $rules=[
        'MSalesorder.tgl_so'=> 'required',
        'MSalesorder.marketing'=> 'required',
        'MSalesorder.pembayaran'=> 'required',
        'MSalesorder.jenis_pembayaran'=> 'required',
        'MSalesorder.jatuh_tempo'=> 'required',
        'MSalesorder.customer_id'=> 'required',
    ];

    public function mount(){

        if ($this->editmode=='edit') {
            $this->MSalesorder = MSalesorderSewa::find($this->salesorder_id);
            $this->customer = Customer::find($this->MSalesorder->customer_id)->nama_customer;
        }else{
            $this->MSalesorder = new MSalesorderSewa();
        }

    }

    public function selectcustomer($id){
        $this->MSalesorder->customer_id=$id;
    }

    public function save(){

        $this->validate();

        if ($this->editmode!='edit') {
            $nomorterakhir = DB::table('m_salesorder_sewas')
                ->orderBy('id', 'DESC')->get();

            if (count($nomorterakhir) == 0){
                $noso = '0001/RO/'.date('m').'/'.date('Y');               
            }else{
                if (
                    substr($nomorterakhir[0]->noso, 8, 2) == date('m')
                    &&
                    substr($nomorterakhir[0]->noso, 11, 4) == date('Y')
                ) {
                    $noakhir = intval(substr($nomorterakhir[0]->noso, 0, 4)) + 1;
                    $noso = substr('0000' . $noakhir, -4) . '/RO/' . date('m') . '/' . date('Y');
                } else {
                    $noso = '0001/RO/' . date('m') . '/' . date('Y');
                }
            }
            $this->MSalesorder->noso = $noso;    
            $this->MSalesorder->status_so = 'Open';
            $pajak = Mpajak::where('jenis_pajak','PPN')->first();
            $this->MSalesorder->pajak = $pajak->persen;
        }

        try{
            $this->MSalesorder->save();
        }catch(Throwable $e){
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
            return;
        }
       
        $this->salesorder_id = $this->MSalesorder->id;
        
        $this->emit("openModal", "sewa.salesorder-sewa-detail-modal",[$this->salesorder_id]);

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('sewa.salesorder-sewa-table', 'pg:eventRefresh-default');

    }

    public function render()
    {
        return view('livewire.sewa.salesorder-sewa-modal');
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }
}
