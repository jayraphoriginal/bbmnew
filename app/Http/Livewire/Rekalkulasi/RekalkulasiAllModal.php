<?php

namespace App\Http\Livewire\Rekalkulasi;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class RekalkulasiAllModal extends ModalComponent
{
    use LivewireAlert;
    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Rekalkulasi')){
            return abort(401);
        }
        return view('livewire.rekalkulasi.rekalkulasi-all-modal');
    }

    public function save(){
        DB::beginTransaction();

        try{

            DB::statement("SET NOCOUNT ON; Exec SP_RekalkulasiStokAll");
            DB::statement("SET NOCOUNT ON; Exec SP_RekalkulasiModalAll");

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
