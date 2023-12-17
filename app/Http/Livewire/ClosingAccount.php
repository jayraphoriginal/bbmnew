<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

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

        $tutupbuku = DB::table('journals')->where('tipe','laba rugi')->where(DB::raw('month(tanggal_transaksi)',$this->bulan))
        ->where(DB::raw('year(tanggal_transaksi)',$this->tahun))->get();

        if (count($tutupbuku) <= 0)
        {
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
        else{
            $this->alert('error', 'Tahun dan bulan ini sudah closing account', [
                'position' => 'center'
            ]);
        }
    }
}
