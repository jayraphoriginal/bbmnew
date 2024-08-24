<?php

namespace App\Http\Livewire\Batal;

use App\Models\PengeluaranBiaya;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PengeluaranBiayaSelect extends Component
{
    public $search;
    public $pengeluaranbiaya;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->pengeluaranbiaya = [];
    }

    public function selectdata($id)
    {
        $pengeluaranbiaya = PengeluaranBiaya::find($id);
        $this->deskripsi = $pengeluaranbiaya->ket.' - '.number_format($pengeluaranbiaya->total,0,',','.');
        $this->emitTo('batal.batal-pengeluaran-biaya','selectid', $id);
    }

    public function selectDeskripsi($id){
        $pengeluaranbiaya = PengeluaranBiaya::find($id);
        $this->deskripsi = $pengeluaranbiaya->id.' - '.$pengeluaranbiaya->ket.' - '.number_format($pengeluaranbiaya->total,0,',','.');
    }

    public function updatedSearch()
    {
        $this->pengeluaranbiaya = PengeluaranBiaya::where(
                function($query) {
                    return $query
                           ->where( 'ket', 'LIKE', '%'.$this->search.'%')
                           ->Where('tgl_biaya','>=',DB::raw("DATEADD(month, -2, GETDATE())"));
                   })
                ->orwhere(function($query) {
                    return $query
                           ->where( 'id', 'LIKE', '%'.$this->search.'%')
                           ->Where('tgl_biaya','>=',DB::raw("DATEADD(month, -2, GETDATE())"));
                   })
                ->get();
    }
    public function render()
    {
        return view('livewire.batal.pengeluaran-biaya-select');
    }
}
