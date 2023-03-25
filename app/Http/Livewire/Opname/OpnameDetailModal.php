<?php

namespace App\Http\Livewire\Opname;

use App\Models\Barang;
use App\Models\Satuan;
use App\Models\TmpOpname;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class OpnameDetailModal extends ModalComponent
{
    use LivewireAlert;
    public TmpOpname $tmp;
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
            $this->tmp = TmpOpname::find($this->tmp_id);
            $barang = Barang::find($this->tmp->barang_id);
            $this->barang = $barang->nama_barang;
            $this->satuan = Satuan::find($barang->satuan_id)->satuan;
        }else{
            $this->tmp = new TmpOpname();
        }
    }

    public function selectbarang($id){
        $this->tmp->barang_id=$id;
        $this->tmp->satuan_id=Barang::find($id)->satuan_id;
        $this->satuan = Satuan::find($this->tmp->satuan_id)->satuan;
    }

    public function selectsatuan($id){
        $this->tmp->satuan_id=$id;
    }
    public function save(){

        $this->tmp->jumlah = str_replace(',', '', $this->tmp->jumlah);
        $this->tmp->status_detail = 'Open';
        $this->tmp->user_id = Auth::user()->id;

        $this->validate();

        try{
            
            $this->tmp->save();

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

        $this->emitTo('opname.opname-detail-table', 'pg:eventRefresh-default');
        $this->emitTo('opname.opname-table', 'pg:eventRefresh-default');

    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }

    public function render()
    {
        return view('livewire.opname.opname-detail-modal');
    }
}
