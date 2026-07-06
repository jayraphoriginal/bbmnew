<?php

namespace App\Http\Livewire\Penerimaan;

use App\Models\Customer;
use App\Models\Journal;
use App\Models\Mpajak;
use App\Models\NoBuktikas;
use App\Models\PenerimaanPph23;
use App\Models\VInvoiceHeader;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class PenerimaanPph23Modal extends ModalComponent
{
    use LivewireAlert;
    public $customer_id, $customer, $noinvoice, $nobukti_potong, $invoice_id, $jumlah, $tgl_penerimaan, $keterangan, $nobuktikas;

    protected $listeners = [
        'selectcustomer' => 'selectcustomer',
        'selectinvoice' => 'selectinvoice'
    ];

    public function selectcustomer($id){
        $this->customer_id=$id;
    }

    public function selectinvoice($id){
        $this->invoice_id=$id;
        $this->noinvoice = VInvoiceHeader::find($this->invoice_id)->noinvoice;
    }

    public function render()
    {
        return view('livewire.penerimaan.penerimaan-pph23-modal');
    }

    public function save(){

        $this->jumlah = str_replace(',', '', $this->jumlah);

        $this->validate([
            'customer_id' => 'required',
            'invoice_id' => 'required',
            'nobukti_potong' => 'required',
            'jumlah' => 'required',
            'tgl_penerimaan' => 'required',
            'keterangan' => 'nullable',
        ]);

        $tipe = "masuk";

        $nobuktikas = NoBuktikas::where('tipe',$tipe)->where('tahun', date('Y', strtotime($this->tgl_bayar)))
        ->where('status','open')
        ->orderby('nomor','asc')
        ->get();

        if (count($nobuktikas)>0){
            $this->nobuktikas = $nobuktikas[0]->nomor;
        }else{
            $nomor = NoBuktikas::where('tipe',$tipe)->where('tahun', date('Y', strtotime($this->tgl_bayar)))
            ->where('status','finish')
            ->orderby('nomor','asc')
            ->get();

            if (count($nomor) > 0){
                $nomorterakhir = $nomor[0]->nomor;
            }else{
                $nomorterakhir = 0;
            }

            for($i=$nomorterakhir+1;$i<1000;$i++){
                $nokas = new NoBuktikas();
                $nokas['tipe'] = $tipe;
                $nokas['tahun'] = date('Y', strtotime($this->tgl_bayar));
                $nokas['nomor'] = $i;
                $nokas['status'] = 'open';
                $nokas->save();
            }
            $this->nobuktikas =  $nomorterakhir + 1;
        }


        DB::beginTransaction();

        try {        

            
            $pph23 = new PenerimaanPph23();
            $pph23->invoice_id = $this->invoice_id;
            $pph23->nobuktikas = $this->nobuktikas;
            $pph23->tgl_penerimaan = $this->tgl_penerimaan;
            $pph23->nobukti_potong = $this->nobukti_potong;
            $pph23->jumlah = $this->jumlah;
            $pph23->keterangan = $this->keterangan;
            $pph23->save();

            $coapph23 = Mpajak::where('jenis_pajak', 'PPH 23')->first();

            $journal = new Journal();
            $journal['tipe']='Pemotongan PPh 23';
            $journal['trans_id']=$pph23->id;
            $journal['tanggal_transaksi']=$this->tgl_penerimaan;
            $journal['coa_id']=$coapph23->coa_id_debet;
            $journal['debet']=$this->jumlah;
            $journal['kredit']=0;
            $journal['trans_detail_id'] = $pph23->id;
            $journal->save();

            $customer = Customer::find($this->customer_id);

            $journal = new Journal();
            $journal['tipe']='Pemotongan PPh 23';
            $journal['trans_id']=$pph23->id;
            $journal['tanggal_transaksi']=$this->tgl_penerimaan;
            $journal['coa_id']=$customer->coa_id;
            $journal['debet']=0;
            $journal['kredit']=$this->jumlah;
            $journal['trans_detail_id'] = $pph23->id;
            $journal->save();

            DB::table('no_buktikas')->where('tipe',$tipe)
                ->where('tahun', date('Y', strtotime($this->tgl_bayar)))
                ->where('nomor', $this->nobuktikas)
                ->update([
                    'status' => 'finish'
                ]);

            DB::commit();

            $this->alert('success', 'Save Success', [
                'position' => 'center'
            ]);
            
            $this->closeModal();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->alert('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }

    }    
}
