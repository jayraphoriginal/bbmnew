<?php

namespace App\Http\Livewire\Produksi;

use App\Models\Barang;
use App\Models\Satuan;
use App\Models\TmpProduksi;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;

class ProduksiDetailModal extends ModalComponent
{
    use LivewireAlert;
    public TmpProduksi $tmp;
    public $editmode, $tmp_id;
    public $barang, $satuan;

    protected $listeners = [
        'selectbarang' => 'selectbarang',
    ];

    protected $rules=[
        'tmp.barang_id'=> 'required',
        'tmp.jumlah'=> 'required',
        'tmp.satuan_id'=> 'required',
    ];

    public function mount(){
        if ($this->editmode=='edit') {
            $this->tmp = TmpProduksi::find($this->tmp_id);
            $barang = Barang::find($this->tmp->barang_id);
            $this->barang = $barang->nama_barang;
            $this->satuan = Satuan::find($barang->satuan_id)->satuan;
        }else{
            $this->tmp = new TmpProduksi();
        }
    }

    public function selectbarang($id){
        $this->tmp->barang_id=$id;
        $this->tmp->satuan_id=Barang::find($id)->satuan_id;
        $this->satuan = Satuan::find($this->tmp->satuan_id)->satuan;
    }

    public function save(){

        $this->tmp->jumlah = str_replace(',', '', $this->tmp->jumlah);

        $this->tmp->user_id = Auth::user()->id;

        $this->validate();
        $this->tmp->save();

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('produksi.tmp-produksi-table', 'pg:eventRefresh-default');

    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }

    public function render()
    {
        return view('livewire.produksi.produksi-detail-modal');
    }
}
