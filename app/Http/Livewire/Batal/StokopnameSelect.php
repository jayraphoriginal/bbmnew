<?php

namespace App\Http\Livewire\Batal;

use App\Models\MOpname;
use App\Models\VOpname;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class StokopnameSelect extends Component
{

    public $search;
    public $stokopname;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->stokopname = [];
    }

    public function selectdata($id)
    {
        $stokopname = MOpname::find($id);
        $this->deskripsi = $stokopname->noopname.' - '.$stokopname->keterangan;
        $this->emitTo('batal.batal-stok-opname','selectstokopname', $id);
    }

    public function selectDeskripsi($id){
        $stokopname = MOpname::find($id);
        $this->deskripsi = $stokopname->noopname.' - '.$stokopname->keterangan;
    }

    public function updatedSearch()
    {
        $this->stokopname = MOpname::where(
            function($query) {
                return $query
                       ->where( 'keterangan', 'LIKE', '%'.$this->search.'%')
                       ->Where('tgl_opname','>=',DB::raw("DATEADD(month, -2, GETDATE())"));
               })
            ->orwhere(function($query) {
                return $query
                       ->where( 'noopname', 'LIKE', '%'.$this->search.'%')
                       ->Where('tgl_opname','>=',DB::raw("DATEADD(month, -2, GETDATE())"));
               })
            ->get();
    }

    public function render()
    {
        return view('livewire.batal.stokopname-select');
    }
}
