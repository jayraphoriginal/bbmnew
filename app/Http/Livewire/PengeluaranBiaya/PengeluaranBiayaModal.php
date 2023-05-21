<?php

namespace App\Http\Livewire\PengeluaranBiaya;

use App\Models\Coa;
use App\Models\Journal;
use App\Models\MBiaya;
use App\Models\Mpajak;
use App\Models\PengeluaranBiaya;
use App\Models\PengeluaranBiayaDetail;
use App\Models\Rekening;
use App\Models\Supplier;
use App\Models\TmpPengeluaranBiaya;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class PengeluaranBiayaModal extends ModalComponent
{
    use LivewireAlert;

    public PengeluaranBiaya $pengeluaran;
    public $editmode, $pengeluaran_id;
    public $supplier;

    protected $listeners = [ 
        'selectsupplier' => 'selectsupplier',
        'caritotal' => 'caritotal'
    ];

    protected $rules=[
        'pengeluaran.supplier_id' => 'nullable',
        'pengeluaran.tgl_biaya' => 'required',
        'pengeluaran.tipe_pembayaran' => 'required',
        'pengeluaran.ppn_id' => 'required',
        'pengeluaran.pajaklain_id' => 'required',
        'pengeluaran.rekening_id' => 'nullable',
        'pengeluaran.persen_ppn' => 'required',
        'pengeluaran.persen_pajaklain' => 'required',
        'pengeluaran.ppn' => 'required',
        'pengeluaran.total' => 'required|numeric|min:1',
        'pengeluaran.ket' => 'nullable|max:50',
        'pengeluaran.nobuktikas' => 'nullable|max:50'
    ];

    public function selectsupplier($id){
        $this->pengeluaran->supplier_id=$id;
    }

    public function mount(){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Pengeluaran Biaya')){
            return abort(401);
        }

        if ($this->editmode=='edit') {
            $this->pengeluaran = PengeluaranBiaya::find($this->pengeluaran_id);
            if (!is_null($this->pengeluaran->supplier_id)){
                $this->supplier = Supplier::find($this->pengeluaran->supplier_id)->nama_supplier;
            }
        }else{
            $this->pengeluaran = new PengeluaranBiaya();
        }
        $this->pengeluaran->total=0;

    }

    public function caritotal(){
        $this->pengeluaran->total = TmpPengeluaranBiaya::where('user_id',Auth::user()->id)->sum('jumlah');
    }

    public function save(){

        $this->pengeluaran->total = str_replace(',', '', $this->pengeluaran->total);    

        if ($this->pengeluaran->ppn_id!=0){
            $datappn = Mpajak::find($this->pengeluaran->ppn_id);
            $this->pengeluaran->persen_ppn = $datappn->persen;
            $dpp = $this->pengeluaran->total / (1 + ($this->pengeluaran->persen_ppn/100));
            $this->pengeluaran->ppn = $this->pengeluaran->total - $dpp;
        }else{
            $this->pengeluaran->persen_ppn = 0;
            $dpp = $this->pengeluaran->total;
            $this->pengeluaran->ppn = $this->pengeluaran->total - $dpp;
        }

        if ($this->pengeluaran->pajaklain_id!=0){
            $datapajak = Mpajak::find($this->pengeluaran->pajaklain_id);
            $this->pengeluaran->persen_pajaklain = $datapajak->persen;
        }
        else{
            $this->pengeluaran->persen_pajaklain = 0;
         }
        $this->validate();

        if ($this->pengeluaran->tipe_pembayaran == 'cash' || $this->pengeluaran->tipe_pembayaran == 'transfer'){
            $this->validate([
                'pengeluaran.rekening_id' => 'required',
            ]);
        }else{
            $this->validate([
                'pengeluaran.supplier_id' => 'required',
            ]);
        }

        DB::beginTransaction();
        try{

            if ($this->pengeluaran->tipe_pembayaran == 'cash' || $this->pengeluaran->tipe_pembayaran == 'transfer'){
                $this->pengeluaran->sisa = 0;
            }else{
                $this->pengeluaran->sisa = $this->pengeluaran->total;
            }
            $this->pengeluaran->save();

            $tmps = TmpPengeluaranBiaya::where('user_id',Auth::user()->id)->get();

            foreach($tmps as $tmp){
                $dpp =0;
                $ppn = 0;
                if ($this->pengeluaran->ppn_id!=0){
                    $datappn = Mpajak::find($this->pengeluaran->ppn_id);
                    $dpp = $tmp->jumlah / (1 + ($datappn->persen/100));
                    $ppn = $tmp->jumlah - $dpp;
                }else{
                    $dpp = $tmp->jumlah;
                    $ppn = $tmp->jumlah - $dpp;
                }

                $pajaklain = 0;

                 if ($this->pengeluaran->pajaklain_id!=0){
                    $datapajak = Mpajak::find($this->pengeluaran->pajaklain_id);
                    $pajaklain = $dpp * $datapajak->persen/100;
                }
                else{
                    $this->pengeluaran->persen_pajaklain = 0;
                    $pajaklain = 0;
                }

                $pengeluaran_detail = new PengeluaranBiayaDetail();
                $pengeluaran_detail['pengeluaran_biaya_id'] = $this->pengeluaran->id;
                $pengeluaran_detail['jenis_pembebanan'] = $tmp->jenis_pembebanan;
                $pengeluaran_detail['m_biaya_id'] = $tmp->m_biaya_id;
                $pengeluaran_detail['beban_id'] = $tmp->beban_id;
                $pengeluaran_detail['jumlah'] = $tmp->jumlah;
                $pengeluaran_detail['keterangan'] = $tmp->keterangan;
                $pengeluaran_detail->save();

                $coabiaya = MBiaya::find($tmp->m_biaya_id);

                $journal = new Journal();
                $journal['tipe']='Pengeluaran Biaya';
                $journal['trans_id']=$this->pengeluaran->id;
                $journal['tanggal_transaksi']=$this->pengeluaran->tgl_biaya;
                $journal['coa_id']=$coabiaya->coa_id;
                $journal['debet']=$dpp;
                $journal['kredit']=0;
                $journal->save();

                if ($this->pengeluaran->ppn_id!=0){
                    $journal = new Journal();
                    $journal['tipe']='Pengeluaran Biaya';
                    $journal['trans_id']=$this->pengeluaran->id;
                    $journal['tanggal_transaksi']=$this->pengeluaran->tgl_biaya;
                    $journal['coa_id']=$datappn->coa_id_debet;
                    $journal['debet']=$ppn ;
                    $journal['kredit']=0;
                    $journal->save();
                }

                if ($this->pengeluaran->pajaklain_id!=0){
                    $journal = new Journal();
                    $journal['tipe']='Pengeluaran Biaya';
                    $journal['trans_id']=$this->pengeluaran->id;
                    $journal['tanggal_transaksi']=$this->pengeluaran->tgl_biaya;
                    $journal['coa_id']=$datapajak->coa_id_kredit;
                    $journal['debet']=0;
                    $journal['kredit']=$pajaklain;
                    $journal->save();
                }
            }

            if ($this->pengeluaran->tipe_pembayaran == 'cash' || $this->pengeluaran->tipe_pembayaran == 'transfer'){

                $rekening = Rekening::find($this->pengeluaran->rekening_id);

                $journal = new Journal();
                $journal['tipe']='Pengeluaran Biaya';
                $journal['trans_id']=$this->pengeluaran->id;
                $journal['tanggal_transaksi']=$this->pengeluaran->tgl_biaya;
                $journal['coa_id']=$rekening->coa_id;
                $journal['debet']=0;
                $journal['kredit']=$this->pengeluaran->total-$pajaklain;
                $journal->save();

            }else{

                $supplier = Supplier::find($this->pengeluaran->supplier_id);

                $journal = new Journal();
                $journal['tipe']='Pengeluaran Biaya';
                $journal['trans_id']=$this->pengeluaran->id;
                $journal['tanggal_transaksi']=$this->pengeluaran->tgl_biaya;
                $journal['coa_id']=$supplier->coa_id;
                $journal['debet']=0;
                $journal['kredit']=$this->pengeluaran->total-$pajaklain;
                $journal->save();
            }

            DB::table('tmp_pengeluaran_biayas')->where('user_id',Auth::user()->id)->delete();

            DB::Commit();

            $this->closeModal();

            $this->alert('success', 'Save Success', [
                'position' => 'center'
            ]);

            $this->emitTo('pengeluaran-biaya.pengeluaran-biaya-table', 'pg:eventRefresh-default');

        }catch(Throwable $e){
            DB::rollBack();
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
        }
    }
    
    public function render()
    {
        return view('livewire.pengeluaran-biaya.pengeluaran-biaya-modal',[
            'pajakppn' => Mpajak::where('jenis_pajak','PPN')->get(),
            'pajakpph' => Mpajak::where('jenis_pajak','<>','PPN')->get(),
            'rekening' => Rekening::all()
        ]);
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }
}
