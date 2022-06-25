<?php

namespace App\Http\Livewire\Barang;

use App\Models\Coa;
use App\Models\Kategori;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;

class KategoriModal extends ModalComponent
{
    use LivewireAlert;

    public Kategori $kategori;
    public $editmode='';
    public $kategori_id, $header_akun;

    protected function rules() {
        return [
            'kategori.kategori' => 'required|min:2',
            'kategori.coa_id' => 'nullable',
            'header_akun' => 'required'
        ];
    }

    public function mount(){
        if ($this->editmode=='edit') {
            $this->kategori = Kategori::find($this->kategori_id);
            $this->header_akun = Coa::find($this->kategori->coa_id)->header_akun;
        }else{
            $this->kategori = new Kategori();
        }
    }

    public function save(){

        $this->validate();

        if ($this->editmode != 'edit'){
            $nomorterakhir = Coa::where('header_akun',$this->header_akun)
                    ->orderBy('kode_akun', 'DESC')->get();
            if (count($nomorterakhir) == 0){
                $kodeakun = substr($this->header_akun,0,5).'01';            
            }else{
                $noakhir = intval(substr($nomorterakhir[0]->kode_akun, 0, 2)) + 1;
                $kodeakun = substr($this->header_akun,0,5).substr('00' . $noakhir, -2);
            }
            $coa = New Coa();
            $coa['kode_akun'] = $kodeakun;
            $coa['nama_akun'] = 'Persediaan '.$this->kategori->kategori;
            $coa['level'] = 5;
            $coa['tipe'] = 'Detail';
            $coa['posisi'] = 'Neraca';
            $coa['header_akun'] = $this->header_akun;
            $coa->save();
        }else{
            $coa = Coa::find($this->kategori->coa_id);
            $coa['nama_akun'] = 'Persediaan '.$this->kategori->kategori;
            $coa->save();
        }

        $this->kategori->coa_id = $coa->id;

        $this->kategori->save();

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('barang.kategori-table', 'pg:eventRefresh-default');

    }


    public function render()
    {
        return view('livewire.barang.kategori-modal', [
            'header' => Coa::where('header_akun','114.000')->get() 
        ]);
    }
}
