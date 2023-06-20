<?php

namespace App\Http\Livewire\Penerimaan;

use App\Models\Bank;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Rekening;
use App\Models\VInvoiceHeader;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class PenerimaanModal extends ModalComponent
{
    use LivewireAlert;

    public $tgl_bayar, $tipe_pembayaran, $jatuh_tempo, $nowarkat, $bank_asal_id, $bankasal,
    $rekening_id, $rekening, $jumlah, $keterangan, $customer_id, $customer, $nobuktikas;

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
        'nobuktikas' => 'nullable'
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

    public function save(){

        $this->jumlah = str_replace(',', '', $this->jumlah);
        $this->validate();

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

            DB::statement("SET NOCOUNT ON; Exec SP_Penerimaan  '$nopembayaran',        '$this->tgl_bayar', 
                                            '$this->tipe_pembayaran', '$this->nowarkat', 
                                            '$this->jatuh_tempo',     $this->bank_asal_id,
                                            $this->rekening_id,     $this->customer_id,
                                            $this->jumlah,          '$this->keterangan',
                                            '$this->nobuktikas'");
            
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

    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Penerimaan Pembayaran')){
            return abort(401);
        }
        return view('livewire.penerimaan.penerimaan-modal');
    }
}
