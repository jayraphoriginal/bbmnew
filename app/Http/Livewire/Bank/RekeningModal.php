<?php

namespace App\Http\Livewire\Bank;

use App\Models\Bank;
use App\Models\Coa;
use App\Models\Rekening;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class RekeningModal extends ModalComponent
{

    use LivewireAlert;

    public Rekening $rekening;
    public $editmode, $rekening_id;
    public $bank;
    public $header_coa;

    protected $listeners = ['selectbank' => 'selectbank'];

    protected $rules=[
        'rekening.norek' => 'required',
        'rekening.atas_nama' => 'required',
        'rekening.bank_id' => 'required',
        'header_coa' => 'required',
        'rekening.coa_id' => 'nullable'
    ];

    public function mount(){

        if ($this->editmode=='edit') {
            $this->rekening = Rekening::find($this->rekening_id);
            $this->bank = Bank::find($this->rekening->bank_id)->nama_bank;
        }else{
            $this->rekening = new Rekening();
        }

    }

    public function selectbank($id){
        $this->rekening->bank_id=$id;
    }

    public function save(){

        $this->validate();

        DB::beginTransaction();
        try{
            if($this->editmode!='edit'){

                $nomorterakhir = Coa::where('header_akun',$this->header_coa)
                        ->orderBy('kode_akun', 'DESC')->get();
                if (count($nomorterakhir) == 0){
                    $kodeakun = substr($this->header_coa,0,3).'001';            
                }else{
                    $noakhir = intval(substr($nomorterakhir[0]->kode_akun, 3)) + 1;
                    $kodeakun = substr($this->header_coa,0,3).substr('000' . $noakhir, -3);
                }

                $coa = New Coa();
                $coa['kode_akun'] = $kodeakun;
                $coa['nama_akun'] = $this->rekening->norek.' - '.$this->rekening->atas_nama;
                $coa['level'] = 5;
                $coa['tipe'] = 'Detail';
                $coa['posisi'] = 'Asset';
                $coa['header_akun'] = $this->header_coa;
                $coa->save();

                $this->rekening->coa_id=$coa->id;

            }else{

                $coa = Coa::find($this->rekening->coa_id);
                $coa['nama_akun'] = $this->rekening->norek.' - '.$this->rekening->atas_nama;
                $coa->save();

            }

            $this->rekening->save();
            DB::commit();
            $this->closeModal();

            $this->alert('success', 'Save Success', [
                'position' => 'center'
            ]);
            
        }catch(Throwable $e){
            DB::rollBack();
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
        }   

        $this->emitTo('bank.rekening-table', 'pg:eventRefresh-default');

    }
    public function render()
    {
        return view('livewire.bank.rekening-modal',[
            'coa' => Coa::where('header_akun','100')->get()
        ]);
    }
}
