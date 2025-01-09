<?php

namespace App\Http\Livewire\Penjualan;

use App\Models\Barang;
use App\Models\DPenjualan;
use App\Models\Satuan;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class PenjualanDetailEditModal extends ModalComponent
{

    use LivewireAlert;
    public DPenjualan $dpenjualan;
    public $editmode, $d_penjualan_id, $m_penjualan_id;
    public $barang, $satuan;

    protected $listeners = [
        'selectbarang' => 'selectbarang',
    ];

    protected $rules=[
        'dpenjualan.barang_id'=> 'required',
        'dpenjualan.jumlah'=> 'required',
        'dpenjualan.harga_intax'=> 'required',
        'dpenjualan.satuan_id'=> 'required',
        'dpenjualan.m_penjualan_id' => 'required'
    ];

    public function mount(){
        if ($this->editmode=='edit') {
            $this->dpenjualan = DPenjualan::find($this->d_penjualan_id);
            $barang = Barang::find($this->dpenjualan->barang_id);
            $this->barang = $barang->nama_barang;
            $this->satuan = Satuan::find($barang->satuan_id)->satuan;
        }else{
            $this->dpenjualan = new DPenjualan();
            $this->dpenjualan->m_penjualan_id = $this->m_penjualan_id;
        }
    }

    public function selectbarang($id){
        $this->dpenjualan->barang_id=$id;
        $this->dpenjualan->satuan_id=Barang::find($id)->satuan_id;
        $this->satuan = Satuan::find($this->dpenjualan->satuan_id)->satuan;
    }

    public function save(){

        $this->dpenjualan->jumlah = str_replace(',', '', $this->dpenjualan->jumlah);
        $this->dpenjualan->sisa = str_replace(',', '', $this->dpenjualan->jumlah);
        $this->dpenjualan->harga_intax = str_replace(',', '', $this->dpenjualan->harga_intax);
      //  $this->dpenjualan->user_id = Auth::user()->id;
        $this->dpenjualan->status_detail = 'Open';
        $this->validate();
        
        $this->dpenjualan->save();

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('penjualan.penjualan-detail-edit-table', 'pg:eventRefresh-default');

    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }
    public function render()
    {
        return view('livewire.penjualan.penjualan-detail-edit-modal');
    }
}
