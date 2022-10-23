<?php

namespace App\Http\Livewire\PengeluaranBiaya;

use App\Models\Coa;
use App\Models\Journal;
use App\Models\MBiaya;
use App\Models\Mpajak;
use App\Models\PengeluaranBiaya;
use App\Models\Rekening;
use App\Models\Supplier;
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
    ];

    protected $rules=[
        'pengeluaran.supplier_id' => 'nullable',
        'pengeluaran.m_biaya_id' => 'required',
        'pengeluaran.tipe_pembayaran' => 'required',
        'pengeluaran.ppn_id' => 'required',
        'pengeluaran.pajaklain_id' => 'required',
        'pengeluaran.rekening_id' => 'nullable',
        'pengeluaran.persen_ppn' => 'required',
        'pengeluaran.persen_pajaklain' => 'required',
        'pengeluaran.ppn' => 'required',
        'pengeluaran.total' => 'required',
        'pengeluaran.keterangan' => 'nullable',
    ];

    public function selectsupplier($id){
        $this->pengeluaran->supplier_id=$id;
    }

    public function mount(){

        if ($this->editmode=='edit') {
            $this->pengeluaran = PengeluaranBiaya::find($this->pengeluaran_id);
            if (!is_null($this->pengeluaran->supplier_id)){
                $this->supplier = Supplier::find($this->pengeluaran->supplier_id)->nama_supplier;
            }
        }else{
            $this->pengeluaran = new PengeluaranBiaya();
        }

    }

    public function save(){

        $this->pengeluaran->total = str_replace(',', '', $this->pengeluaran->total);
        

        $dpp =0;
        $nettbiaya=0;
        if ($this->pengeluaran->ppn_id!=0){
            $datappn = Mpajak::find($this->pengeluaran->ppn_id);
            $this->pengeluaran->persen_ppn = $datappn->persen;
            $dpp = $this->pengeluaran->total / (1 + $this->pengeluaran->persen_ppn);
            $this->pengeluaran->ppn = $this->pengeluaran->total - $dpp;
        }else{
            $this->pengeluaran->persen_ppn = 0;
            $dpp = $this->pengeluaran->total;
            $this->pengeluaran->ppn = $this->pengeluaran->total - $dpp;
        }

        if ($this->pengeluaran->pajaklain_id!=0){
            $datapajak = Mpajak::find($this->pengeluaran->pajaklain_id);
            $this->pengeluaran->persen_pajaklain = $datapajak->persen;
            $nettbiaya = $dpp / (1 + $this->pengeluaran->persen_pajaklain);
        }
        else{
            $this->pengeluaran->persen_pajaklain = 0;
            $nettbiaya = $dpp;
        }
        $this->validate();

        DB::beginTransaction();
        try{

            if ($this->pengeluaran->tipe_pembayaran == 'Cash'){
                $this->pengeluaran->sisa = 0;
            }else{
                $this->pengeluaran->sisa = $this->pengeluaran->total;
            }
            $this->pengeluaran->save();
            $coabiaya = MBiaya::find($this->pengeluaran->m_biaya_id);

            $journal = new Journal();
            $journal['tipe']='Pengeluaran Biaya';
            $journal['trans_id']=$this->pengeluaran->id;
            $journal['tanggal_transaksi']=$this->pengeluaran->created_at;
            $journal['coa_id']=$coabiaya->coa_id;
            $journal['debet']=$nettbiaya;
            $journal['kredit']=0;
            $journal->save();

            if ($this->pengeluaran->ppn_id!=0){
                $journal = new Journal();
                $journal['tipe']='Pengeluaran Biaya';
                $journal['trans_id']=$this->pengeluaran->id;
                $journal['tanggal_transaksi']=$this->pengeluaran->created_at;
                $journal['coa_id']=$datappn->coa_id_debet;
                $journal['debet']=$this->pengeluaran->ppn ;
                $journal['kredit']=0;
                $journal->save();
            }

            if ($this->pengeluaran->pajaklain_id!=0){
                $journal = new Journal();
                $journal['tipe']='Pengeluaran Biaya';
                $journal['trans_id']=$this->pengeluaran->id;
                $journal['tanggal_transaksi']=$this->pengeluaran->created_at;
                $journal['coa_id']=$datapajak->coa_id_debet;
                $journal['debet']=$dpp - $nettbiaya ;
                $journal['kredit']=0;
                $journal->save();
            }

            if ($this->pengeluaran->tipe_pembayaran == 'Cash'){

                if (is_null($this->pengeluaran->rekening_id)){
                    DB::rollBack();
                    $this->alert('error', 'Isi Rekening', [
                        'position' => 'center'
                    ]);
                    exit;
                }

                $rekening = Rekening::find($this->pengeluaran->rekening_id);
                $journal = new Journal();
                $journal['tipe']='Pengeluaran Biaya';
                $journal['trans_id']=$this->pengeluaran->id;
                $journal['tanggal_transaksi']=$this->pengeluaran->created_at;
                $journal['coa_id']=$rekening->coa_id;
                $journal['debet']=0;
                $journal['kredit']=$this->pengeluaran->total;
                $journal->save();

            }else{

                if (is_null($this->pengeluaran->supplier_id)){
                    DB::rollBack();
                    $this->alert('error', 'Isi Supplier', [
                        'position' => 'center'
                    ]);
                    exit;
                }

                $supplier = Supplier::find($this->pengeluaran->supplier_id);
                $journal = new Journal();
                $journal['tipe']='Pengeluaran Biaya';
                $journal['trans_id']=$this->pengeluaran->id;
                $journal['tanggal_transaksi']=$this->pengeluaran->created_at;
                $journal['coa_id']=$supplier->coa_id;
                $journal['debet']=0;
                $journal['kredit']=$this->pengeluaran->total;
                $journal->save();

            }

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
            'biaya' => MBiaya::all(),
            'pajakppn' => Mpajak::where('jenis_pajak','PPN')->get(),
            'pajakpph' => Mpajak::where('jenis_pajak','<>','PPN')->get(),
            'rekening' => Rekening::all()
        ]);
    }
}
