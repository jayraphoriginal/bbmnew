<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\DB;
use Throwable;

class OpenClosing extends ModalComponent
{
    use LivewireAlert;
    public $tahun, $bulan;

    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Open Closing')){
            return abort(401);
        }
        return view('livewire.open-closing');
    }

    protected $rules =[
        'tahun' => 'required',
        'bulan' => 'required',
    ];

    public function save(){

        $this->validate();

        DB::beginTransaction();

        try{

            DB::statement("SET NOCOUNT ON; exec SP_OpenClosing ".$this->tahun.", ".
            $this->bulan."");

            DB::commit();
            $this->closeModal();
            $this->alert('success', 'Save Success', [
                'position' => 'center'
            ]);
        }
        catch(Throwable $e){
            DB::rollBack();
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
        }
    }
}
