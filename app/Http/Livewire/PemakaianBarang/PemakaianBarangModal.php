<?php

namespace App\Http\Livewire\PemakaianBarang;

use App\Models\Barang;
use App\Models\DBarang;
use App\Models\MBiaya;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;
use Throwable;


class PemakaianBarangModal extends ModalComponent
{
    use LivewireAlert;

    public $tgl_pemakaian, $m_biaya_id, $jenis_pembebanan, $beban_id, $jumlah, $keterangan;
    public $editmode, $pemakaian_id;
    public $barang,$alat,$kendaraan, $barang_id;

    protected $rules=[
        'tgl_pemakaian' => 'required',
        'm_biaya_id' => 'required',
        'jenis_pembebanan' => 'required',
        'beban_id' => 'nullable',
        'barang_id' => 'required',
        'jumlah' => 'required',
        'keterangan' => 'required',
    ];

    protected $listeners = [
        'selectbarang' => 'selectbarang',
        'selectkendaraan' => 'selectkendaraan',
        'selectalat' => 'selectalat'
    ];

    public function selectkendaraan($id){
        $this->beban_id=$id;
    }
    public function selectalat($id){
        $this->beban_id=$id;
    }

    public function selectbarang($id){
        $this->barang_id = $id;
    }

    public function mount(){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Pemakaian Barang')){
            return abort(401);
        }

    }

    public function save(){

        if (date_diff(date_create($this->tgl_pemakaian),date_create(date("Y-m-d")))->format("%a") > 60){
            $this->alert('error', 'Tanggal Dibawah 2 bulan', [
                'position' => 'center'
            ]);
            $this->addError('tgl_pemakaian', 'Tanggal Dibawah 2 bulan');
        }

        $this->jumlah = str_replace(',', '', $this->jumlah);

        $this->validate();

        if ($this->jenis_pembebanan <> '-'){
            $this->validate([
                'beban_id' => 'required'
            ]);
        }
     

        DB::beginTransaction();
        try{

            $jumlahstok = DBarang::where('barang_id',$this->barang_id)
                                ->sum('jumlah');

            $pemakaianstok = $this->jumlah;
            
                
            if ($jumlahstok < $pemakaianstok){
                $mbarang = Barang::find($this->barang_id);
                DB::Rollback();
                $this->alert('error', 'Stok '.$mbarang->nama_barang.' tidak mencukupi', [
                    'position' => 'center'
                ]);
                return;
            }else{

                if ($this->beban_id != ''){
                    $beban = $this->beban_id;
                }else{
                    $beban = 0;
                }
             
                DB::statement("SET NOCOUNT ON; Exec SP_PemakaianBarang '".$this->tgl_pemakaian."',".
                $this->m_biaya_id.",'".
                $this->jenis_pembebanan."',".
                $beban.",".
                $this->barang_id.",".
                $this->jumlah.",'".
                $this->keterangan."'");

            }
            DB::Commit();

            $this->closeModal();

            $this->alert('success', 'Save Success', [
                'position' => 'center'
            ]);

            $this->emitTo('pemakaian-barang.pemakaian-barang-table', 'pg:eventRefresh-default');

        }catch(Throwable $e){
            DB::rollBack();
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
        }
    }
    public function render()
    {
        return view('livewire.pemakaian-barang.pemakaian-barang-modal',[
            'biaya' => MBiaya::all()
        ]);
    }
}
