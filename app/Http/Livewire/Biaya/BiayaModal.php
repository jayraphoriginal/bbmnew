<?php

namespace App\Http\Livewire\Biaya;

use App\Models\Coa;
use App\Models\MBiaya;
use App\Models\Rekening;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class BiayaModal extends ModalComponent{

    use LivewireAlert;

    public MBiaya $biaya;
    public $editmode, $biaya_id;
    public $header_coa;

    protected $rules=[
        'biaya.nama_biaya' => 'required',
        'header_coa' => 'required',
        'biaya.coa_id' => 'nullable',
    ];

    public function mount(){

        if ($this->editmode=='edit') {
            $this->biaya = MBiaya::find($this->biaya_id);
        }else{
            $this->biaya = new MBiaya();
        }

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
                $coa['nama_akun'] = $this->biaya->nama_biaya;
                $coa['level'] = 5;
                $coa['tipe'] = 'Detail';
                $coa['posisi'] = 'Expense';
                $coa['header_akun'] = $this->header_coa;
                $coa->save();

                $this->biaya->coa_id=$coa->id;

            }else{

                $coa = Coa::find($this->biaya->coa_id);
                $coa['nama_akun'] = $this->biaya->nama_biaya;
                $coa->save();

            }
            $this->biaya->save();
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
        
        $this->emitTo('biaya.biaya-table', 'pg:eventRefresh-default');

    }

    public function render()
    {
        return view('livewire.biaya.biaya-modal',[
            'coa' => Coa::where('header_akun','600')->orwhere('header_akun','699')->get()
        ]);
    }
}
