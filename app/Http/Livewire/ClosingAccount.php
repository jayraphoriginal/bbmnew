<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class ClosingAccount extends ModalComponent
{
    use LivewireAlert;
    public $tahun, $bulan;

    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Closing Account')){
            return abort(401);
        }
        return view('livewire.closing-account');
    }

    protected $rules =[
        'tahun' => 'required',
        'bulan' => 'required',
    ];

    public function save(){

        $this->validate();

        DB::beginTransaction();

        try{

            DB::statement("SET NOCOUNT ON; exec SP_JurnalPenyesuaian ".$this->tahun.", ".
            $this->bulan."");
            DB::statement("SET NOCOUNT ON; exec SP_TutupBuku ".$this->tahun.", ".
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
