<?php

namespace App\Http\Livewire\ProdukTurunan;

use App\Models\Barang;
use App\Models\Produkturunan;
use App\Models\Satuan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class ProdukTurunanModal extends ModalComponent
{
   

    use LivewireAlert;

    public Produkturunan $produkturunan;
    public $editmode, $produkturunan_id;
    public $satuan, $barang;

    protected $listeners = [
        'selectbarang' => 'selectbarang'
    ];

    
    protected $rules=[
        'produkturunan.barang_id' => 'required',
        'produkturunan.deskripsi' => 'required',
        'produkturunan.jumlah' => 'required',
        'produkturunan.status' => 'required',
        'produkturunan.tgl_berlaku' => 'required'
    ];

    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Produk Turunan')){
            return abort(401);
        }
        return view('livewire.produk-turunan.produk-turunan-modal');
    }

    public function mount(){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Produk Turunan')){
            return abort(401);
        }

        if ($this->editmode=='edit') {
            $this->produkturunan = Produkturunan::find($this->produkturunan_id);
            $barang = Barang::find($this->produkturunan->barang_id);
            $this->barang = $barang->nama_barang;
            $this->satuan = Satuan::find($barang->satuan_id)->satuan;
        }else{
            $this->produkturunan = new Produkturunan();
        }

    }

    public function selectbarang($id){
        $this->produkturunan->barang_id=$id;
        $barang = Barang::find($id);
        $this->satuan = Satuan::find($barang->satuan_id)->satuan;
    }

    public function save(){

        $this->validate();

        $this->produkturunan->jumlah = str_replace(',', '', $this->produkturunan->jumlah);

        DB::beginTransaction();

        try{

            $this->produkturunan->save();
            DB::commit();

            $this->closeModal();

            $this->alert('success', 'Save Success', [
                'position' => 'center'
            ]);

            $this->emitTo('produk-turunan.produk-turunan-table', 'pg:eventRefresh-default');

        }
        catch(Throwable $e){
            DB::rollBack();
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
        }
    }
}
