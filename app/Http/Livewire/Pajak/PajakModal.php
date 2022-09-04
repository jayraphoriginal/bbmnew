<?php

namespace App\Http\Livewire\Pajak;

use App\Models\Coa;
use App\Models\Mpajak;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class PajakModal extends ModalComponent
{
    use LivewireAlert;

    public Mpajak $mpajak;
    public $editmode='';
    public $pajak_id;
    public $tipe;

    protected function rules() {
        return [
            'mpajak.jenis_pajak' => 'required',
            'mpajak.persen' => 'required',
            'tipe' => 'required',
            'mpajak.coa_id_debet' => 'nullable',
            'mpajak.coa_id_kredit' => 'nullable'
        ];
    }

    public function mount(){
        if ($this->editmode=='edit') {
            $this->mpajak = Mpajak::find($this->pajak_id);
        }else{
            $this->mpajak = new Mpajak();
        }
    }

    public function save(){

        $this->validate();

        $this->mpajak->persen = str_replace(',', '', $this->mpajak->persen);

        DB::beginTransaction();
        try{
            if ($this->editmode != 'edit'){
                if ($this->tipe == 'PPN'){

                    $nomorterakhir = Coa::where('header_akun','131000')
                            ->orderBy('kode_akun', 'DESC')->get();
                    if (count($nomorterakhir) == 0){
                        $kodeakun = '131001';            
                    }else{
                        $noakhir = intval(substr($nomorterakhir[0]->kode_akun,3)) + 1;
                        $kodeakun = '131'.substr('000' . $noakhir, -3);
                    }
                    $coadebet = New Coa();
                    $coadebet['kode_akun'] = $kodeakun;
                    $coadebet['nama_akun'] = 'PPN Masukan';
                    $coadebet['level'] = 5;
                    $coadebet['tipe'] = 'Detail';
                    $coadebet['posisi'] = 'Asset';
                    $coadebet['header_akun'] = '131000';
                    $coadebet->save();

                    //COA Kredit
                    $nomorterakhir = Coa::where('header_akun','231000')
                            ->orderBy('kode_akun', 'DESC')->get();
                    if (count($nomorterakhir) == 0){
                        $kodeakun = '231001';            
                    }else{
                        $noakhir = intval(substr($nomorterakhir[0]->kode_akun, 3)) + 1;
                        $kodeakun = '231'.substr('000' . $noakhir, -3);
                    }
                    $coakredit = New Coa();
                    $coakredit['kode_akun'] = $kodeakun;
                    $coakredit['nama_akun'] = 'PPN Keluaran';
                    $coakredit['level'] = 5;
                    $coakredit['tipe'] = 'Detail';
                    $coakredit['posisi'] = 'Liability';
                    $coakredit['header_akun'] = '231000';
                    $coakredit->save();

                    $this->mpajak->coa_id_debet = $coadebet->id;
                    $this->mpajak->coa_id_kredit = $coakredit->id;

                }else{
                    
                    $nomorterakhir = Coa::where('header_akun','130000')
                            ->orderBy('kode_akun', 'DESC')->get();
                    if (count($nomorterakhir) == 0){
                        $kodeakun = '130001';            
                    }else{
                        $noakhir = intval(substr($nomorterakhir[0]->kode_akun, 3)) + 1;
                        $kodeakun = '130'.substr('000' . $noakhir, -3);
                    }
                    $coadebet = New Coa();
                    $coadebet['kode_akun'] = $kodeakun;
                    $coadebet['nama_akun'] = $this->mpajak->jenis_pajak;
                    $coadebet['level'] = 5;
                    $coadebet['tipe'] = 'Detail';
                    $coadebet['posisi'] = 'Asset';
                    $coadebet['header_akun'] = '130000';
                    $coadebet->save();

                    //COA Kredit
                    $nomorterakhir = Coa::where('header_akun','230000')
                            ->orderBy('kode_akun', 'DESC')->get();
                    if (count($nomorterakhir) == 0){
                        $kodeakun = '230001';            
                    }else{
                        $noakhir = intval(substr($nomorterakhir[0]->kode_akun, 3)) + 1;
                        $kodeakun = '230'.substr('000' . $noakhir, -3);
                    }
                    $coakredit = New Coa();
                    $coakredit['kode_akun'] = $kodeakun;
                    $coakredit['nama_akun'] = $this->mpajak->jenis_pajak;
                    $coakredit['level'] = 5;
                    $coakredit['tipe'] = 'Detail';
                    $coakredit['posisi'] = 'Liability';
                    $coakredit['header_akun'] = '230000';
                    $coakredit->save();

                    $this->mpajak->coa_id_debet = $coadebet->id;
                    $this->mpajak->coa_id_kredit = $coakredit->id;
                }
            }
            
            $this->mpajak->save();

            DB::commit();

            $this->closeModal();

            $this->alert('success', 'Save Success', [
                'position' => 'center'
            ]);
        }catch(Throwable $e){
            DB::rollBack();
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
        }

        $this->emitTo('pajak.pajak-table', 'pg:eventRefresh-default');

    }

    public function render()
    {
        return view('livewire.pajak.pajak-modal');
    }
}
