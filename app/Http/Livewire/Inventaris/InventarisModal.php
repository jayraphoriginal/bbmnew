<?php

namespace App\Http\Livewire\Inventaris;

use App\Models\Coa;
use App\Models\Golongan;
use App\Models\Inventaris;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class InventarisModal extends ModalComponent
{
    use LivewireAlert;

    public Inventaris $inventaris;
    public $editmode='';
    public $inventaris_id;

    protected function rules() {
        return [
            'inventaris.golongan_id' => 'required',
            'inventaris.nama_inventaris' => 'required',
            'inventaris.tgl_perolehan' => 'required',
            'inventaris.harga_perolehan' => 'required',
            'inventaris.coa_asset_id' => 'nullable',
            'inventaris.coa_penyusutan_id' => 'nullable',
            'inventaris.status' => 'required',
        ];
    }

    public function mount(){
        if ($this->editmode=='edit') {
            $this->inventaris = Inventaris::find($this->inventaris_id);
        }else{
            $this->inventaris = new Inventaris();
        }
    }

    public function save(){

        $this->inventaris->harga_perolehan = str_replace(',', '', $this->inventaris->harga_perolehan);

        $this->inventaris->status = 'Aktif';
        $this->validate();

        try{
            if ($this->editmode != 'edit'){
                $nomorterakhir = Coa::where('header_akun','150000')
                        ->orderBy('kode_akun', 'DESC')->get();
                if (count($nomorterakhir) == 0){
                    $kodeakun = '150001';            
                }else{
                    $noakhir = intval(substr($nomorterakhir[0]->kode_akun, 3)) + 1;
                    $kodeakun = '150'.substr('000' . $noakhir, -3);
                }
                $coaaktiva = New Coa();
                $coaaktiva['kode_akun'] = $kodeakun;
                $coaaktiva['nama_akun'] = 'Aktiva '.$this->inventaris->nama_inventaris;
                $coaaktiva['level'] = 5;
                $coaaktiva['tipe'] = 'Detail';
                $coaaktiva['posisi'] = 'Asset';
                $coaaktiva['header_akun'] = '150000';
                $coaaktiva->save();

                $nomorterakhir = Coa::where('header_akun','151000')
                        ->orderBy('kode_akun', 'DESC')->get();
                if (count($nomorterakhir) == 0){
                    $kodeakun = '151001';            
                }else{
                    $noakhir = intval(substr($nomorterakhir[0]->kode_akun, 3)) + 1;
                    $kodeakun = '151'.substr('000' . $noakhir, -3);
                }
                $coapenyusutan = New Coa();
                $coapenyusutan['kode_akun'] = $kodeakun;
                $coapenyusutan['nama_akun'] = 'Akumulasi penyusutan '.$this->inventaris->nama_inventaris;
                $coapenyusutan['level'] = 5;
                $coapenyusutan['tipe'] = 'Detail';
                $coapenyusutan['posisi'] = 'Asset';
                $coapenyusutan['header_akun'] = '151000';
                $coapenyusutan->save();

            }else{
                $coaaktiva = Coa::find($this->inventaris->coa_asset_id);
                $coaaktiva['nama_akun'] = 'Aktiva '.$this->inventaris->nama_inventaris;
                $coaaktiva->save();

                $coapenyusutan = Coa::find($this->inventaris->coa_penyusutan_id);
                $coapenyusutan['nama_akun'] = 'Akumulasi penyusutan '.$this->inventaris->nama_inventaris;
                $coapenyusutan->save();
            }

            $this->inventaris->coa_asset_id = $coaaktiva->id;
            $this->inventaris->coa_penyusutan_id = $coapenyusutan->id;
    
            $this->inventaris->save();
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

        $this->emitTo('inventaris.inventaris-table', 'pg:eventRefresh-default');

    }
    public function render()
    {
        return view('livewire.inventaris.inventaris-modal',[
            'golongan' => Golongan::all()
        ]);
    }
}
