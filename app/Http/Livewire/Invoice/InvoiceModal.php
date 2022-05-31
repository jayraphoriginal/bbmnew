<?php

namespace App\Http\Livewire\Invoice;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\MSalesorder;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class InvoiceModal extends ModalComponent
{
    public $noso, $m_salesorder_id, $tipe, $customer;
    public Invoice $invoice;
    public $tgl_awal, $tgl_akhir, $jumlah_total,$dp;

    protected $rules =[
        'invoice.customer_id' => 'required',
        'invoice.m_salesorder_id' => 'required',
        'invoice.jumlah' => 'required'
    ];

    public function mount(){
        $this->invoice = new Invoice();
        $this->invoice->tipe = $this->tipe;
        $msalesorder = MSalesorder::find($this->m_salesorder_id);
        $this->invoice->customer_id = $msalesorder->customer_id;
        $this->noso = $msalesorder->noso;
        $customers = Customer::find($msalesorder->customer_id);
        $this->customer = $customers->nama_customer;
        $this->jumlah_total = 0;
        $this->dp = "DP";
    }

    public function render()
    {
        return view('livewire.invoice.invoice-modal');
    }

    public function updatedTglAwal(){
        $this->jumlah_total = Ticket::join('d_salesorders','tickets.d_salesorder_id','d_salesorders.id')
        ->where('d_salesorders.m_salesorder_id', $this->m_salesorder_id)
        ->where('tickets.status','Open')
        ->whereBetween(DB::raw('date(tickets.jam_ticket)'),array(date_create($this->tgl_awal)->format('Y-m-d'),date_create($this->tgl_akhir)->format('Y-m-d')))
        ->sum(DB::raw('tickets.jumlah * d_salesorders.harga_intax'));

        if ($this->jumlah_total > 0) {
            $this->dp = "";
            $this->invoice->jumlah = $this->jumlah_total;
        }else{
            $this->dp = "DP";
            $this->invoice->jumlah = 0;
        }

        $this->jumlah_total = number_format($this->jumlah_total,2,',','.');
    }
    public function updatedTglAkhir(){
        $this->jumlah_total = Ticket::join('d_salesorders','tickets.d_salesorder_id','d_salesorders.id')
        ->where('d_salesorders.m_salesorder_id', $this->m_salesorder_id)
        ->where('tickets.status','Open')
        ->whereBetween(DB::raw('date(tickets.jam_ticket)'),array(date_create($this->tgl_awal)->format('Y-m-d'),date_create($this->tgl_akhir)->format('Y-m-d')))
        ->sum(DB::raw('tickets.jumlah * d_salesorders.harga_intax'));

        if ($this->jumlah_total > 0) {
            $this->dp = "";
            $this->invoice->jumlah = $this->jumlah_total;
        }else{
            $this->dp = "DP";
            $this->invoice->jumlah = 0;
        }

        $this->jumlah_total = number_format($this->jumlah_total,2,',','.');
    }

    public function save(){

        $this->validate();

        DB::beginTransaction();

        try{

            if ($this->editmode!='edit') {

                $nomorterakhir = DB::table('tickets')->orderBy('id', 'DESC')->get();

                if (count($nomorterakhir) == 0){
                    $noticket = '0001/DO/'.date('m').'/'.date('Y');               
                }else{
                    if (
                        substr($nomorterakhir[0]->noticket, 8, 2) == date('m')
                        &&
                        substr($nomorterakhir[0]->noticket, 11, 4) == date('Y')
                    ) {
                        $noakhir = intval(substr($nomorterakhir[0]->noticket, 0, 4)) + 1;
                        $noticket = substr('0000' . $noakhir, -4) . '/DO/' . date('m') . '/' . date('Y');
                    } else {
                        $noticket = '0001/DO/' . date('m') . '/' . date('Y');
                    }
                }
            }

            $this->ticket->noticket = $noticket;

            $this->ticket->save();


    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }
}
