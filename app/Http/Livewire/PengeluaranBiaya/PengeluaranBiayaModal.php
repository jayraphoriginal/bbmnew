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

    protected $listeners = [ 'selectsupplier' => 'selectsupplier',];

    protected $rules=[
        'pengeluaran.supplier_id' => 'nullable',
        'pengeluaran.m_biaya_id' => 'required',
        'pengeluaran.tipe_pembayaran' => 'required',
        'pengeluaran.mpajak_id' => 'nullable',
        'pengeluaran.rekening_id' => 'nullable',
        'pengeluaran.persen_pajak' => 'required',
        'pengeluaran.pajak' => 'required',
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

        $this->validate();

        $this->pengeluaran->total = str_replace('.', '', $this->pengeluaran->total);
        $this->pengeluaran->total = str_replace(',', '.', $this->pengeluaran->total);

    

        DB::beginTransaction();
        try{

            if (!is_null($this->pengeluaran->mpajak_id)){

                $datapajak = Mpajak::find($this->pengeluaran->mpajak_id);
                $this->pengeluaran->persen_pajak = $datapajak->persen;
                $this->pengeluaran->pajak = $this->pengeluaran->total / (1 + $this->pengeluaran->persen_pajak);

            }else{
                $this->pengeluaran->persen_pajak = 0;
                $this->pengeluaran->pajak = 0;
            }


            $this->pengeluaran->save();

            $coabiaya = MBiaya::find($this->pengeluaran->m_biaya_id);

            $journal = new Journal();
            $journal['tipe']='Pengeluaran Biaya';
            $journal['trans_id']=$this->Mpo->id;
            $journal['tanggal_transaksi']=$this->Mpo->tgl_masuk;
            $journal['coa_id']=$coabiaya->coa_id;
            $journal['debet']=$this->pengeluaran->total - $this->pengeluaran->pajak ;
            $journal['kredit']=0;
            $journal->save();

            if (!is_null($this->pengeluaran->mpajak_id)){
                $journal = new Journal();
                $journal['tipe']='Pengeluaran Biaya';
                $journal['trans_id']=$this->Mpo->id;
                $journal['tanggal_transaksi']=$this->Mpo->tgl_masuk;
                $journal['coa_id']=$datapajak->coa_id_debet;
                $journal['debet']=$this->pengeluaran->pajak ;
                $journal['kredit']=0;
                $journal->save();
            }

            if ($this->pengeluaran->tipe_pembayaran == 'Cash'){

                if (!is_null($this->pengeluaran->rekening_id)){
                    DB::rollBack();
                    $this->alert('error', 'Isi Rekening', [
                        'position' => 'center'
                    ]);
                    exit;
                }

                $rekening = Rekening::find($this->pengeluaran->rekening_id);
                $journal = new Journal();
                $journal['tipe']='Pengeluaran Biaya';
                $journal['trans_id']=$this->Mpo->id;
                $journal['tanggal_transaksi']=$this->Mpo->tgl_masuk;
                $journal['coa_id']=$rekening->coa_id;
                $journal['debet']=0;
                $journal['kredit']=$this->pengeluaran->total;
                $journal->save();

            }else{

                if (!is_null($this->pengeluaran->supplier_id)){
                    DB::rollBack();
                    $this->alert('error', 'Isi Supplier', [
                        'position' => 'center'
                    ]);
                    exit;
                }

                $supplier = Supplier::find($this->pengeluaran->supplier_id);
                $journal = new Journal();
                $journal['tipe']='Pengeluaran Biaya';
                $journal['trans_id']=$this->Mpo->id;
                $journal['tanggal_transaksi']=$this->Mpo->tgl_masuk;
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
            'coa' => Coa::where('header_akun')->get(),
            'pajak' => Mpajak::all(),
            'rekening' => Rekening::all()
        ]);
    }
}
