<?php

namespace App\Http\Livewire\Batal;

use App\Models\PengisianBbm;
use App\Models\VPengisianBbm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class BatalPengisianBbm extends ModalComponent
{

    public $pengisian_bbm_id, $nama_supplier, $nopol, $nama_driver, $jumlah;
    use LivewireAlert;

    public function mount(){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Pembatalan Pengisian BBM')){
            return abort(401);
        }
        $pengisian = VPengisianBbm::find($this->pengisian_bbm_id);
        $this->nama_supplier = $pengisian->nama_supplier;
        $this->nopol = $pengisian->nopol;
        $this->nama_driver = $pengisian->nama_driver;
        $this->jumlah = $pengisian->jumlah;
    }

    public function save(){

        $pengisian = VPengisianBbm::find($this->pengisian_bbm_id);

        if($pengisian->total <> $pengisian->sisa)
        {
            $this->alert('error', 'Pengisian BBM sudah terbayar', [
                'position' => 'center'
            ]);
            $this->closeModal();
        }
        else{
            $this->validate([
                'pengisian_bbm_id' => 'required'
            ]);

            DB::beginTransaction();

            try{

                DB::table('journals')->where('tipe','Pengisian BBM')->where('trans_id', $this->pengisian_bbm_id)->delete();
                $pengisian = PengisianBbm::find($this->pengisian_bbm_id);
                $pengisian->delete();

                DB::commit();
                $this->closeModal();

                $this->alert('success', 'Delete Success', [
                    'position' => 'center'
                ]);

                $this->emitTo('bbm.pengisian-bbm-table', 'pg:eventRefresh-default');
            }catch(Throwable $e){
                DB::rollback();
                $this->alert('error', $e->getMessage(), [
                    'position' => 'center'
                ]);
            }
        }
    }


    public function render()
    {
        return view('livewire.batal.batal-pengisian-bbm');
    }
}
