<?php

namespace App\Http\Livewire\Batal;

use App\Models\VPembayaran;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PembayaranSelect extends Component
{
    public $search;
    public $pembayaran;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->pembayaran = [];
    }

    public function selectdata($id)
    {
        $pembayaran = VPembayaran::find($id);
        $this->deskripsi = $pembayaran->nopembayaran.' - '.$pembayaran->keterangan;
        $this->emitTo('batal.batal-pembayaran','selectpembayaran', $id);
    }

    public function selectDeskripsi($id){
        $pembayaran = VPembayaran::find($id);
        $this->deskripsi = $pembayaran->nopembayaran.' - '.$pembayaran->keterangan;
    }

    public function updatedSearch()
    {
        $this->pembayaran = VPembayaran::where(
            function($query) {
                return $query
                       ->where( 'nopembayaran', 'LIKE', '%'.$this->search.'%')
                       ->Where('tgl_bayar','>=',DB::raw("DATEADD(month, -2, GETDATE())"));
               })
            ->orwhere(function($query) {
                return $query
                       ->where( 'nopembayaran', 'LIKE', '%'.$this->search.'%')
                       ->Where('tgl_bayar','>=',DB::raw("DATEADD(month, -2, GETDATE())"));
               })->get();
    }
    public function render()
    {
        return view('livewire.batal.pembayaran-select');
    }
}
