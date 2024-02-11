<?php

namespace App\Http\Livewire\Rekalkulasi;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class RekalkulasiperBarangModal extends ModalComponent
{
    use LivewireAlert;
    public $barang_id, $barang;

    protected $listeners = [
        'selectbarang' => 'selectbarang',
    ];

    public function selectbarang($id){
        $this->barang_id=$id;
    }

    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Rekalkulasi')){
            return abort(401);
        }
        return view('livewire.rekalkulasi.rekalkulasiper-barang-modal');
    }

    public function save(){
        DB::beginTransaction();

        try{

            DB::statement("SET NOCOUNT ON; Exec SP_RekalkulasiStok ".$this->barang_id."");
            DB::statement("SET NOCOUNT ON; Exec SP_RekalkulasiModal ".$this->barang_id."");

            DB::commit();
            $this->alert('success', 'Rekalkulasi Success', [
                'position' => 'center'
            ]);
            $this->closeModal();
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
