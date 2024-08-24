<?php

namespace App\Http\Livewire\Jurnal;

use App\Models\Journal;
use App\Models\ManualJournal;
use App\Models\Coa;
use App\Models\NoBuktikas;
use App\Models\TmpJurnalManual;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class JurnalManualModal extends ModalComponent
{

    use LivewireAlert;

    public ManualJournal $jurnalmanual;
    public $retail;

    protected $rules=[
        'jurnalmanual.tanggal' => 'required',
        'jurnalmanual.keterangan' => 'required',
        'jurnalmanual.bukti_kas' => 'required',
    ];

    public function mount(){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Jurnal Manual')){
            return abort(401);
        }
        $this->jurnalmanual = new ManualJournal();
    }

    public function save(){

        $this->validate();
        $debet = TmpJurnalManual::where('user_id', Auth::user()->id)->sum('debet');
        $kredit = TmpJurnalManual::where('user_id', Auth::user()->id)->sum('kredit');

        $tmpjurnal = TmpJurnalManual::where('user_id', Auth::user()->id)->get();

        if ($debet<>$kredit || count($tmpjurnal) <= 0){
            $this->alert('error', 'Total debet tidak sama dengan kredit / Detail jurnal tidak ada', [
                'position' => 'center'
            ]);
        }else{

            if ($this->jurnalmanual->bukti_kas == "bukti penerimaan kas"){

                if ($this->retail){
                    $tipe = "masuk retail";
                }
                else{
                    $tipe = "masuk";
                }

                $nobuktikas = NoBuktikas::where('tipe',$tipe)->where('tahun', date('Y', strtotime($this->jurnalmanual->tanggal)))
                ->where('status','open')
                ->orderby('nomor','asc')
                ->get();

                if (count($nobuktikas)>0){
                    $this->jurnalmanual->nobuktikas = $nobuktikas[0]->nomor;
                }else{
                    $nomor = NoBuktikas::where('tipe',$tipe)->where('tahun', date('Y', strtotime($this->jurnalmanual->tanggal)))
                    ->where('status','finish')
                    ->orderby('nomor','desc')
                    ->get();

                    if (count($nomor) > 0){
                        $nomorterakhir = $nomor[0]->nomor;
                    }else{
                        $nomorterakhir = 0;
                    }

                    for($i=$nomorterakhir+1;$i<100;$i++){
                        $nokas = new NoBuktikas();
                        $nokas['tipe'] = $tipe;
                        $nokas['tahun'] = date('Y', strtotime($this->jurnalmanual->tanggal));
                        $nokas['nomor'] = $i;
                        $nokas['status'] = 'open';
                        $nokas->save();
                    }
                    $this->jurnalmanual->nobuktikas =  $nomorterakhir + 1;
                }
            }elseif($this->jurnalmanual->bukti_kas == "bukti pengeluaran kas"){

                if ($this->retail){
                    $tipe = "keluar retail";
                }
                else{
                    $tipe = "keluar";
                }

                $nobuktikas = NoBuktikas::where('tipe',$tipe)->where('tahun', date('Y', strtotime($this->jurnalmanual->tanggal)))
                ->where('status','open')
                ->orderby('nomor','asc')
                ->get();

                if (count($nobuktikas) > 0){
                    $this->jurnalmanual->nobuktikas = $nobuktikas[0]->nomor;
                }else{
                    $nomor = NoBuktikas::where('tipe',$tipe)->where('tahun', date('Y', strtotime($this->jurnalmanual->tanggal)))
                    ->where('status','finish')
                    ->orderby('nomor','desc')
                    ->get();

                    if (count($nomor) > 0){
                        $nomorterakhir = $nomor[0]->nomor;
                    }else{
                        $nomorterakhir = 0;
                    }

                    for($i=$nomorterakhir+1;$i<100;$i++){
                        $nokas = new NoBuktikas();
                        $nokas['tipe'] = $tipe;
                        $nokas['tahun'] = date('Y', strtotime($this->jurnalmanual->tanggal));
                        $nokas['nomor'] = $i;
                        $nokas['status'] = 'open';
                        $nokas->save();
                    }
                    $this->jurnalmanual->nobuktikas =  $nomorterakhir + 1;
                }
            }

            DB::beginTransaction();
               
            try{

                $this->jurnalmanual->save();

                if ($this->jurnalmanual->bukti_kas == "bukti penerimaan kas"){
                    DB::table('no_buktikas')->where('tipe',$tipe)
                    ->where('tahun', date('Y', strtotime($this->jurnalmanual->tanggal)))
                    ->where('nomor', $this->jurnalmanual->nobuktikas)
                    ->update([
                        'status' => 'finish'
                    ]);
                }elseif($this->jurnalmanual->bukti_kas == "bukti pengeluaran kas"){
                    DB::table('no_buktikas')->where('tipe',$tipe)
                    ->where('tahun', date('Y', strtotime($this->jurnalmanual->tanggal)))
                    ->where('nomor', $this->jurnalmanual->nobuktikas)
                    ->update([
                        'status' => 'finish'
                    ]);
                }

                foreach($tmpjurnal as $tmp){
                    $journal = new Journal();
                    $journal['tipe']='Jurnal Manual';
                    $journal['trans_id']=$this->jurnalmanual->id;
                    $journal['tanggal_transaksi']=$this->jurnalmanual->tanggal;
                    $journal['coa_id']=$tmp->coa_id;
                    $journal['debet']=$tmp->debet;
                    $journal['kredit']=$tmp->kredit;
                    $journal->save();
                }

                TmpJurnalManual::where('user_id',Auth::user()->id)->delete();

                DB::commit();

                $this->closeModal();

                $this->alert('success', 'Save Success', [
                    'position' => 'center'
                ]);

                $this->emitTo('jurnal.jurnal-manual-table', 'pg:eventRefresh-default');

            }
            catch(Throwable $e){
                DB::rollBack();
                $this->alert('error', $e->getMessage(), [
                    'position' => 'center'
                ]);
            }
        }

        
    }

    public function render()
    {
        return view('livewire.jurnal.jurnal-manual-modal',[
            'coa' => Coa::where('level',5)->get()
        ]);
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }
}
