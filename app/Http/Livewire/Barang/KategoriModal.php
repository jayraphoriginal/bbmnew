<?php

namespace App\Http\Livewire\Barang;

use App\Models\Coa;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class KategoriModal extends ModalComponent
{
    use LivewireAlert;

    public Kategori $kategori;
    public $editmode='';
    public $kategori_id, $header_akun;

    protected function rules() {
        return [
            'kategori.kategori' => 'required|min:2',
            'kategori.coa_asset_id' => 'nullable',
            'kategori.coa_hpp_id' => 'nullable',
        ];
    }

    public function mount(){
        if ($this->editmode=='edit') {
            $this->kategori = Kategori::find($this->kategori_id);
        }else{
            $this->kategori = new Kategori();
        }
    }

    public function save(){

        $this->validate();

        try{
            if ($this->editmode != 'edit'){
                $nomorterakhir = Coa::where('header_akun','120000')
                        ->orderBy('kode_akun', 'DESC')->get();
                if (count($nomorterakhir) == 0){
                    $kodeakun = '120001';            
                }else{
                    $noakhir = intval(substr($nomorterakhir[0]->kode_akun, 3)) + 1;
                    $kodeakun = '120'.substr('000' . $noakhir, -3);
                }
                $coapersediaan = New Coa();
                $coapersediaan['kode_akun'] = $kodeakun;
                $coapersediaan['nama_akun'] = 'Persediaan '.$this->kategori->kategori;
                $coapersediaan['level'] = 5;
                $coapersediaan['tipe'] = 'Detail';
                $coapersediaan['posisi'] = 'Asset';
                $coapersediaan['header_akun'] = '120000';
                $coapersediaan->save();

                $nomorterakhir = Coa::where('header_akun','500000')
                        ->orderBy('kode_akun', 'DESC')->get();
                if (count($nomorterakhir) == 0){
                    $kodeakun = '500001';            
                }else{
                    $noakhir = intval(substr($nomorterakhir[0]->kode_akun, 3)) + 1;
                    $kodeakun = '500'.substr('000' . $noakhir, -3);
                }
                $coahpp = New Coa();
                $coahpp['kode_akun'] = $kodeakun;
                $coahpp['nama_akun'] = 'HPP '.$this->kategori->kategori;
                $coahpp['level'] = 5;
                $coahpp['tipe'] = 'Detail';
                $coahpp['posisi'] = 'Expense';
                $coahpp['header_akun'] = '500000';
                $coahpp->save();

            }else{
                $coapersediaan = Coa::find($this->kategori->coa_asset_id);
                $coapersediaan['nama_akun'] = 'Persediaan '.$this->kategori->kategori;
                $coapersediaan->save();

                $coahpp = Coa::find($this->kategori->coa_hpp_id);
                $coahpp['nama_akun'] = 'HPP '.$this->kategori->kategori;
                $coahpp->save();
            }

            $this->kategori->coa_asset_id = $coapersediaan->id;
            $this->kategori->coa_hpp_id = $coahpp->id;
    
            $this->kategori->save();
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
        $this->emitTo('barang.kategori-table', 'pg:eventRefresh-default');
    }


    public function render()
    {
        return view('livewire.barang.kategori-modal', [
            'header' => Coa::where('header_akun','114.000')->get() 
        ]);
    }
}
