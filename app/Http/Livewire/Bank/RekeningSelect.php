<?php

namespace App\Http\Livewire\Bank;

use App\Models\Bank;
use App\Models\Rekening;
use Livewire\Component;

class RekeningSelect extends Component
{

    public $search;
    public $rekening;
    public $deskripsi;

    protected $listeners = ['selectdata' => 'selectDeskripsi'];

    public function mount($deskripsi)
    {
        $this->deskripsi=$deskripsi;
    }

    public function resetdata()
    {
        $this->search = '';
        $this->rekening = [];
    }

    public function selectdata($id)
    {
        $rekening =  Rekening::find($id);
        $bank = Bank::find($rekening->bank_id);
        $this->deskripsi = $bank->nama_bank.' - '.$rekening->norek.' - '.$rekening->atas_nama;
        $this->emitTo('invoice.invoice-modal','selectrekening', $id);
        $this->emitTo('pembayaran.pembayaran-pembelian-modal','selectrekening', $id);
        $this->emitTo('penerimaan.penerimaan-modal','selectrekening', $id);
        $this->emitTo('laporan.laporan-saldo-rekening','selectrekening', $id);
    }

    public function selectDeskripsi($id){
        $rekening =  Rekening::find($id);
        $bank = Bank::find($rekening->bank_id);
        $this->deskripsi = $bank->nama_bank.' - '.$rekening->norek.' - '.$rekening->atas_nama;
    }

    public function updatedSearch()
    {
        if ($this->search == ''){
            $this->rekening = Rekening::select('rekenings.id','banks.nama_bank','rekenings.norek','rekenings.atas_nama')
            ->join('banks','rekenings.bank_id','banks.id')->get();
        }else{
            $this->rekening = Rekening::select('rekenings.id','banks.nama_bank','rekenings.norek','rekenings.atas_nama')
                ->join('banks','rekenings.bank_id','banks.id')
                ->orwhere('nama_bank', 'like', '%' . $this->search . '%')
                ->orwhere('norek', 'like', '%' . $this->search . '%')
                ->orwhere('atas_nama', 'like', '%' . $this->search . '%')
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.bank.rekening-select');
    }
}
