<?php

namespace App\Http\Livewire\Penjualan;

use App\Models\DSalesorder;
use App\Models\JarakTempuh;
use App\Models\Mutubeton;
use App\Models\Rate;
use App\Models\Satuan;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class SalesorderDetailModal extends ModalComponent
{
    use LivewireAlert;
    public DSalesorder $DSalesorder;
    public $editmode, $dsalesorder_id;
    public $rate, $mutubeton, $satuan;
    public $m_salesorder_id;

    protected $listeners = [
        'selectmutubeton' => 'selectmutubeton',
        'selectrate' => 'selectrate'
    ];

    protected $rules=[
        'DSalesorder.jarak_tempuh_id'=> 'required',
        'DSalesorder.rate_id'=> 'required',
        'DSalesorder.mutubeton_id'=> 'required',
        'DSalesorder.jumlah'=> 'required',
        'DSalesorder.harga_intax'=> 'required',
        'DSalesorder.satuan_id'=> 'required',
        'DSalesorder.tgl_awal'=> 'required',
        'DSalesorder.tgl_akhir'=> 'required',
    ];

    public function mount($m_salesorder_id){
        $this->m_salesorder_id = $m_salesorder_id;
        if ($this->editmode=='edit') {
            $this->DSalesorder = DSalesorder::find($this->dsalesorder_id);
            $mutubeton = Mutubeton::find($this->DSalesorder->mutubeton_id);
            $this->mutubeton = $mutubeton->kode_mutu;
            $rate = Rate::find($this->DSalesorder->rate_id);
            $this->rate = $rate->tujuan.' - '.number_format($rate->estimasi_jarak,2,'.',',').' KM';
            $this->satuan = Satuan::find($mutubeton->satuan_id)->satuan;
        }else{
            $this->DSalesorder = new DSalesorder();
        }

    }

    public function selectmutubeton($id){
        $this->DSalesorder->mutubeton_id=$id;
        $this->DSalesorder->satuan_id=Mutubeton::find($id)->satuan_id;
        $this->satuan = Satuan::find($this->DSalesorder->satuan_id)->satuan;
    }

    public function selectrate($id){
        $this->DSalesorder->rate_id=$id;
    }

    public function save(){

        $this->DSalesorder->harga_intax = str_replace(',', '', $this->DSalesorder->harga_intax);

        $this->DSalesorder->m_salesorder_id = $this->m_salesorder_id;
        $this->DSalesorder->sisa = $this->DSalesorder->jumlah;
        $this->DSalesorder->status_detail = 'Open';
        $this->DSalesorder->user_id = Auth::user()->id;

        $this->validate();

        try{
            $this->DSalesorder->save();
        }
        catch(Throwable $e){
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
            return;
        }
       
        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('penjualan.salesorder-detail-table', 'pg:eventRefresh-default');

    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }

    public function render()
    {
        return view('livewire.penjualan.salesorder-detail-modal',[
            'jaraktempuh' => JarakTempuh::all()
        ]);
    }
}
