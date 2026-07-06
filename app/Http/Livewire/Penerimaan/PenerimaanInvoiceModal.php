<?php

namespace App\Http\Livewire\Penerimaan;

use App\Models\Bank;
use App\Models\NoBuktikas;
use App\Models\Rekening;
use App\Models\TmpPenerimaanInvoice;
use App\Models\VInvoiceHeader;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class PenerimaanInvoiceModal extends ModalComponent
{

    use LivewireAlert;

    public $tgl_bayar, $tipe_pembayaran, $jatuh_tempo, $nowarkat, $bank_asal_id, $bankasal,
    $rekening_id, $rekening, $jumlah, $keterangan, $customer_id, $customer, $nobuktikas, $retail;
    public $jumlah_bayar = [];
    public $jumlah_biaya = [];
    public $biaya = [];
    public $invoices = [];
    
    protected $rules=[
        'customer_id' => 'required',
        'tgl_bayar' => 'required',
        'tipe_pembayaran' => 'required',
        'jatuh_tempo' => 'nullable',
        'nowarkat' => 'nullable',
        'bank_asal_id' => 'required',
        'rekening_id' => 'required',
        'jumlah' => 'required|min:1',
        'keterangan' => 'nullable',
    ];

    protected $listeners = [
        'selectrekening' => 'selectrekening',
        'selectbankasal' => 'selectbankasal',
        'selectcustomer' => 'selectcustomer'
    ];

    public function selectcustomer($id){
        $this->customer_id=$id;
    }

    public function selectrekening($id){
        $this->rekening_id=$id;
        $rekening = Rekening::find($this->rekening_id);
        $this->rekening = $rekening->norek.' - '.$rekening->atas_nama;
    }

    public function selectbankasal($id){
        $this->bank_asal_id=$id;
        $bankasal = Bank::find($this->bank_asal_id);
        $this->bankasal = $bankasal->nama_bank;
    }

    public function updateJumlahBayar($invoice_id){

        $invoice = VInvoiceHeader::find($invoice_id);
        $jumlahBayar =  $this->jumlah_bayar[$invoice_id] ?? 0;
        $jumlahBiaya =  $this->jumlah_biaya[$invoice_id] ?? 0;

        if ((str_replace(',', '', $jumlahBayar) + str_replace(',', '', $jumlahBiaya)) > $invoice->sisa_invoice) {
            $this->jumlah_bayar[$invoice_id] = $invoice->sisa_invoice;
            $this->alert('error', 'Jumlah bayar tidak boleh lebih dari sisa invoice');
        }

        $jumlah_bayar = str_replace(',', '', $jumlahBayar);
        $this->jumlah_bayar[$invoice_id] = $jumlah_bayar;

        $this->jumlah = array_sum($this->jumlah_bayar);
    }

    public function save(){

        $this->validate();

        foreach ($this->invoices as $invoice) {

            $invoice_id = $invoice->id;

            $jumlahBayar = $this->jumlah_bayar[$invoice_id] ?? 0;
            $jumlahBiaya = $this->jumlah_biaya[$invoice_id] ?? 0;
            $biaya = $this->biaya[$invoice_id] ?? '';

            if (intval(str_replace(',', '', $jumlahBayar)) + intval(str_replace(',', '', $jumlahBiaya)) > 0 && empty($biaya)) {

                $this->addError(
                    'biaya.'.$invoice_id,
                    'Pilih jenis biaya terlebih dahulu.'
                );

                return;
            }

            if (($biaya == 'Admin' || $biaya == 'Diskon') && $jumlahBiaya ==0) {

                $this->addError(
                    'jumlah_biaya.'.$invoice_id,
                    'Jumlah biaya tidak boleh kosong.'
                );

                return;
            }
        }

        if ($this->retail){
            $tipe = "masuk retail";
        }
        else{
            $tipe = "masuk";
        }

        $nobuktikas = NoBuktikas::where('tipe',$tipe)->where('tahun', date('Y', strtotime($this->tgl_bayar)))->get();
        if (count($nobuktikas) > 0){
            $this->nobuktikas = $nobuktikas[0]->nomor + 1;
        }else{
            $this->nobuktikas = 1;
        }

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

        try{

            $nomorterakhir = DB::table('penerimaans')->orderBy('id', 'DESC')->get();

                if (count($nomorterakhir) == 0){
                    $nopembayaran = '0001/PN/'.date('m').'/'.date('Y');               
                }else{
                    if (
                        substr($nomorterakhir[0]->nopenerimaan, 8, 2) == date('m')
                        &&
                        substr($nomorterakhir[0]->nopenerimaan, 11, 4) == date('Y')
                    ) {
                        $noakhir = intval(substr($nomorterakhir[0]->nopenerimaan, 0, 4)) + 1;
                        $nopembayaran = substr('0000' . $noakhir, -4) . '/PN/' . date('m') . '/' . date('Y');
                    } else {
                        $nopembayaran = '0001/PN/' . date('m') . '/' . date('Y');
                    }
                }


            foreach($this->jumlah_bayar as $invoice_id => $jumlah_bayar){
                $tmp = new TmpPenerimaanInvoice();
                $tmp->invoice_id = $invoice_id;
                $tmp->jumlah_bayar = str_replace(',', '', $jumlah_bayar);
                $tmp->jumlah_biaya = str_replace(',', '', $this->jumlah_biaya[$invoice_id] ?? 0);
                $tmp->biaya = $this->biaya[$invoice_id] ?? '';
                $tmp->save();
            }

            DB::statement("SET NOCOUNT ON; Exec SP_PenerimaanInvoice  '$nopembayaran',        '$this->tgl_bayar', 
                                            '$this->tipe_pembayaran', '$this->nowarkat', 
                                            '$this->jatuh_tempo',     $this->bank_asal_id,
                                            $this->rekening_id,     $this->customer_id,
                                            $this->jumlah,          '$this->keterangan',
                                            '$this->nobuktikas'");

            DB::table('no_buktikas')->where('tipe',$tipe)
                ->where('tahun', date('Y', strtotime($this->tgl_bayar)))
                ->where('nomor', $this->nobuktikas)
                ->update([
                    'status' => 'finish'
                ]);

//            DB::table('tmp_penerimaan_invoice')->delete();

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

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }

    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Penerimaan Pembayaran')){
            return abort(401);
        }

        if ($this->customer_id == ''){
            $this->invoices = [];
        }else{
            $this->invoices = VInvoiceHeader::where('customer_id', $this->customer_id)
                ->where('sisa_invoice', '>', 0)
                ->orderby('tgl_cetak', 'asc')
                ->get();
        }       

        return view('livewire.penerimaan.penerimaan-invoice-modal',[
            'invoices' => $this->invoices
        ]);
    }
}
