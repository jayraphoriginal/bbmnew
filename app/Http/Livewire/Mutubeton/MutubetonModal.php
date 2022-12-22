<?php

namespace App\Http\Livewire\Mutubeton;

use App\Models\Barang;
use App\Models\Komposisi;
use App\Models\KomposisiStandar;
use App\Models\Satuan;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Models\Mutubeton;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class MutubetonModal extends ModalComponent
{
    use LivewireAlert;

    public function render()
    {
        return view('livewire.mutubeton.mutubeton-modal');
    }

    public Mutubeton $mutubeton;
    public $editmode, $mutubeton_id;
    public $satuan;

    protected $listeners = ['selectsatuan' => 'selectsatuan'];

    protected $rules=[
        'mutubeton.kode_mutu' => 'required',
        'mutubeton.deskripsi' => 'required',
        'mutubeton.jumlah' => 'required',
        'mutubeton.satuan_id' => 'required',
        'mutubeton.berat_jenis' => 'required',
        'mutubeton.status' => 'required'
    ];

    public function mount(){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Mutubeton')){
            return abort(401);
        }

        if ($this->editmode=='edit') {
            $this->mutubeton = Mutubeton::find($this->mutubeton_id);
            $this->satuan = Satuan::find($this->mutubeton->satuan_id)->satuan;
        }else{
            $this->mutubeton = new Mutubeton();
        }

    }

    public function selectsatuan($id){
        $this->mutubeton->satuan_id=$id;
    }

    public function save(){

        $this->validate();

        $this->mutubeton->jumlah = str_replace(',', '', $this->mutubeton->jumlah);

        $this->mutubeton->berat_jenis = str_replace(',', '', $this->mutubeton->berat_jenis);

        DB::beginTransaction();

        try{

            $this->mutubeton->save();

            $jumlahkomposisi = Komposisi::where('mutubeton_id',$this->mutubeton_id)->count('*');

            if ($jumlahkomposisi <=0){

                $komposisistandar = KomposisiStandar::all();

                foreach($komposisistandar as $komposisi){
        
                    $barang = Barang::find($komposisi->material_id);

                    $datakomposisi = New Komposisi();
                    $datakomposisi['mutubeton_id'] = $this->mutubeton->id;
                    $datakomposisi['barang_id'] = $komposisi->material_id;
                    $datakomposisi['jumlah'] = 0;
                    $datakomposisi['satuan_id'] = $barang->satuan_id;
                    $datakomposisi['tipe'] = $komposisi->tipe;
                    $datakomposisi->save();
                }
            }

            DB::commit();

            $this->closeModal();

            $this->alert('success', 'Save Success', [
                'position' => 'center'
            ]);

            $this->emitTo('mutubeton.mutubeton-table', 'pg:eventRefresh-default');

        }
        catch(Throwable $e){
            DB::rollBack();
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
        }
    }
}
