<?php

namespace App\Http\Livewire\Pembayaran;

use App\Models\Rekening;
use App\Models\VPembayaran;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class PencairanWarkatKeluar extends ModalComponent
{
    use LivewireAlert;
 
    public $pembayaran_id, $tgl_cair, $jatuh_tempo, $nowarkat, $jumlah, $rekening_id;
 
    public function mount($pembayaran_id){
        $this->pembayaran_id = $pembayaran_id;
        $pembayaran = VPembayaran::find($pembayaran_id);
        $this->jatuh_tempo = $pembayaran->jatuh_tempo;
        $this->nowarkat = $pembayaran->nowarkat;
        $this->jumlah = $pembayaran->jumlah;
    }

    protected $rules =[
        'tgl_cair'=> 'required',
        'rekening_id' => 'required'
    ];

    public function render()
    {
        return view('livewire.pembayaran.pencairan-warkat-keluar',[
            'rekening' => Rekening::join('banks','rekenings.bank_id','banks.id')->select('rekenings.*','banks.kode_bank')->get(),
        ]);
    }

    public function save(){

        $this->validate();

        $bank_id = Rekening::find($this->rekening_id)->bank_id;

        DB::beginTransaction();

        try{

            DB::update("Exec SP_Pencairan_Warkat_Keluar ".$this->pembayaran_id.",'".
            $this->tgl_cair."',".
            $bank_id.",".
            $this->rekening_id);

            DB::commit();
            $this->resetpage();
            $this->alert('success', 'Save Success', [
                'position' => 'center'
            ]);
            $this->closeModal();
            $this->emitTo('pembayaran.warkat-table', 'pg:eventRefresh-default');
        }
        catch(Throwable $e){
            DB::rollBack();
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
            $this->closeModal();
            return;
        }

    }
}
