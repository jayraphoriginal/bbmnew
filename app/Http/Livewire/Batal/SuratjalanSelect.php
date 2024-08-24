<?php

namespace App\Http\Livewire\Batal;

use App\Models\VSuratJalanHeader;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SuratjalanSelect extends Component
{
    
    public $search;
    public $suratjalan;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->suratjalan = [];
    }

    public function selectdata($id)
    {
        $suratjalan = VSuratJalanHeader::find($id);
        $this->deskripsi = $suratjalan->nosuratjalan.' - '.$suratjalan->nama_customer;
        $this->emitTo('batal.batal-suratjalan','selectsj', $id);
    }

    public function selectDeskripsi($id){
        $suratjalan = VSuratJalanHeader::find($id);  
        $this->deskripsi = $suratjalan->nosuratjalan.' - '.$suratjalan->nama_customer;
    }

    public function updatedSearch()
    {
        $this->suratjalan = VSuratJalanHeader::where(
                function($query) {
                    return $query
                           ->where( 'nosuratjalan', 'LIKE', '%'.$this->search.'%');
                        //   ->Where('tgl_pengiriman','>=',DB::raw("DATEADD(month, -2, GETDATE())"))
                   })
                ->orwhere(function($query) {
                    return $query
                           ->where( 'nama_customer', 'LIKE', '%'.$this->search.'%');
                        //   ->Where('tgl_pengiriman','>=',DB::raw("DATEADD(month, -2, GETDATE())"))
                   })
                ->get();
    }

    public function render()
    {
        return view('livewire.batal.suratjalan-select');
    }
}
