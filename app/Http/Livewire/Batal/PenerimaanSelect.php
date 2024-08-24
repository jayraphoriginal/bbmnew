<?php

namespace App\Http\Livewire\Batal;

use App\Models\VPenerimaan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PenerimaanSelect extends Component
{  public $search;
    public $penerimaan;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->penerimaan = [];
    }

    public function selectdata($id)
    {
        $penerimaan = VPenerimaan::find($id);
        $this->deskripsi = $penerimaan->nopenerimaan.' - '.$penerimaan->keterangan;
        $this->emitTo('batal.batal-penerimaan','selectpenerimaan', $id);
    }

    public function selectDeskripsi($id){
        $penerimaan = VPenerimaan::find($id);
        $this->deskripsi = $penerimaan->nopenerimaan.' - '.$penerimaan->keterangan;
    }

    public function updatedSearch()
    {
        $this->penerimaan = VPenerimaan::where(
            function($query) {
                return $query
                       ->where( 'nopenerimaan', 'LIKE', '%'.$this->search.'%')
                       ->Where('tgl_bayar','>=',DB::raw("DATEADD(month, -2, GETDATE())"));
               })
            ->orwhere(function($query) {
                return $query
                       ->where( 'nopenerimaan', 'LIKE', '%'.$this->search.'%')
                       ->Where('tgl_bayar','>=',DB::raw("DATEADD(month, -2, GETDATE())"));
               })->get();
    }
    public function render()
    {
        return view('livewire.batal.penerimaan-select');
    }
}
