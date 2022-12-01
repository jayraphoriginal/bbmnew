<?php

namespace App\Http\Livewire\PengeluaranBiaya;

use App\Models\Alat;
use App\Models\Kendaraan;
use App\Models\MBiaya;
use App\Models\TmpPengeluaranBiaya;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class PengeluaranBiayaDetailModal extends ModalComponent
{
    use LivewireAlert;

    public TmpPengeluaranBiaya $tmp;
    public $tmp_id, $nama_biaya, $editmode, $kendaraan, $alat;

    protected $listeners = [
        'selectkendaraan' => 'selectkendaraan',
        'selectalat' => 'selectalat'
    ];

    public function selectkendaraan($id){
        $this->tmp->beban_id=$id;
    }
    public function selectalat($id){
        $this->tmp->beban_id=$id;
    }

    protected $rules=[
        'tmp.jenis_pembebanan' => 'required',
        'tmp.m_biaya_id' => 'required',
        'tmp.beban_id' => 'nullable',
        'tmp.jumlah' => 'required',
        'tmp.keterangan' => 'required'
    ];

    public function mount(){
        if ($this->editmode=='edit') {
            $this->tmp = TmpPengeluaranBiaya::find($this->tmp_id);
            $biaya = MBiaya::find($this->tmp->m_biaya_id);
            $this->nama_biaya = $biaya->nama_biaya;

            if($this->tmp->jenis_pembebanan == 'Beban Kendaraan'){
                $this->kendaraan = Kendaraan::find($this->tmp->beban_id)->nopol;
            }else if($this->tmp->jenis_pembebanan == 'Beban Alat'){
                $this->alat = Alat::find($this->tmp->beban_id)->nama_alat;
            }

        }else{
            $this->tmp = new TmpPengeluaranBiaya();
        }
    }

    public function save(){

        $this->tmp->jumlah = str_replace(',', '', $this->tmp->jumlah);
        $this->tmp->user_id = Auth::user()->id;

        $this->validate();

        if ($this->tmp->jenis_pembebanan <> '-'){
            $this->validate([
                'tmp.beban_id' => 'required',
            ]);
        }

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

        $this->emitTo('pengeluaran-biaya.pengeluaran-biaya-detail-table', 'pg:eventRefresh-default');
        $this->emitTo('pengeluaran-biaya.pengeluaran-biaya-modal', 'caritotal');
    }

    public function render()
    {
        return view('livewire.pengeluaran-biaya.pengeluaran-biaya-detail-modal',[
            'biaya' => MBiaya::all(),
        ]);
    }
}
