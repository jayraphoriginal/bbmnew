<?php

namespace App\Http\Livewire\Jurnal;

use App\Models\Coa;
use App\Models\TmpJurnalManual;
use COM;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class JurnalManualDetailModal extends ModalComponent
{

    use LivewireAlert;
    public TmpJurnalManual $tmp;
    public $editmode, $tmp_id;
    public $coa, $tipe, $jumlah;

    protected $listeners = [
        'selectcoa' => 'selectcoa',
    ];

    protected $rules=[
        'tmp.coa_id'=> 'required',
        'jumlah'=> 'required',
        'tipe'=> 'required',
        'tmp.debet' => 'nullable',
        'tmp.kredit' => 'nullable',
        'tmp.user_id' => 'required'
    ];

    public function mount(){
        if ($this->editmode=='edit') {
            $this->tmp = TmpJurnalManual::find($this->tmp_id);
            $coa = Coa::find($this->tmp->coa_id);
            $this->coa = $coa->kode_akun.' - '.$coa->nama_akun;
            if ($this->tmp->debet > 0){
                $this->tipe = 'debet';
                $this->jumlah = $this->tmp->debet;
            }else{
                $this->tipe = 'kredit';
                $this->jumlah = $this->tmp->kredit;
            }

        }else{
            $this->tmp = new TmpJurnalManual();
        }
    }

    public function selectcoa($id){
        $this->tmp->coa_id=$id;
        $coa = Coa::find($this->tmp->coa_id);
        $this->coa = $coa->kode_akun.' - '.$coa->nama_akun;
    }

    public function save(){

        $this->jumlah = str_replace(',', '', $this->jumlah);

        if ($this->jumlah <=0){
            $this->alert('error', 'Jumlah harus > 0', [
                'position' => 'center'
            ]);
        }else{

            $this->tmp->user_id = Auth::user()->id;
            $this->validate();

            if ($this->tipe == 'debet'){
                $this->tmp->debet = $this->jumlah;
                $this->tmp->kredit = 0;
            }else{
                $this->tmp->debet = 0;
                $this->tmp->kredit = $this->jumlah;
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

            $this->emitTo('jurnal.tmp-jurnal-manual-table', 'pg:eventRefresh-default');
        }
    }

    public function render()
    {
        return view('livewire.jurnal.jurnal-manual-detail-modal');
    }
}
