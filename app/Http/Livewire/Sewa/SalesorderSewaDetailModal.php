<?php

namespace App\Http\Livewire\Sewa;

use App\Models\DSalesorderSewa;
use App\Models\Itemsewa;
use App\Models\Satuan;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class SalesorderSewaDetailModal extends ModalComponent
{
    use LivewireAlert;
    public DSalesorderSewa $DSalesorder;
    public $editmode, $dsalesorder_id;
    public $itemsewa, $satuan;
    public $m_salesorder_id;

    protected $listeners = [
        'selectitemsewa' => 'selectitemsewa',
    ];

    protected $rules=[
        'DSalesorder.itemsewa_id'=> 'required',
        'DSalesorder.lama'=> 'required',
        'DSalesorder.harga_intax'=> 'required',
        'DSalesorder.satuan_id'=> 'required',
        'DSalesorder.tgl_awal'=> 'required',
        'DSalesorder.tgl_akhir'=> 'required',
    ];

    public function mount($m_salesorder_id){
        $this->m_salesorder_id = $m_salesorder_id;
        if ($this->editmode=='edit') {
            $this->DSalesorder = DSalesorderSewa::find($this->dsalesorder_id);
            $itemsewa = Itemsewa::find($this->DSalesorder->itemsewa_id);
            $this->itemsewa = $itemsewa->nama_item;
            $this->satuan = Satuan::find($itemsewa->satuan_id)->satuan;
        }else{
            $this->DSalesorder = new DSalesorderSewa();
        }

    }

    public function selectitemsewa($id){
        $this->DSalesorder->itemsewa_id=$id;
        $this->DSalesorder->satuan_id=Itemsewa::find($id)->satuan_id;
        $this->satuan = Satuan::find($this->DSalesorder->satuan_id)->satuan;
    }

    public function save(){

        $this->DSalesorder->harga_intax = str_replace(',', '', $this->DSalesorder->harga_intax);

        $this->DSalesorder->m_salesorder_sewa_id = $this->m_salesorder_id;
        $this->DSalesorder->status_detail = 'Open';
        $this->DSalesorder->user_id = Auth::user()->id;

        $this->validate();
        try{
            $this->DSalesorder->save();
        }catch(Throwable $e){
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
            return;
        }
        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('sewa.salesorder-sewa-detail-table', 'pg:eventRefresh-default');

    }

    public function render()
    {
        return view('livewire.sewa.salesorder-sewa-detail-modal');
    }
}
