<?php

namespace App\Http\Livewire\Pembayaran;

use App\Models\Bank;
use App\Models\Rekening;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class PembayaranPembelianModal extends ModalComponent
{
    use LivewireAlert;

    public $supplier_id, $supplier, $tgl_bayar, $tipe_pembayaran, $jatuh_tempo, $nowarkat, 
    $rekening_id, $rekening, $jumlah, $keterangan;

    protected $rules=[
        'supplier_id' => 'required',
        'tgl_bayar' => 'required',
        'tipe_pembayaran' => 'required',
        'jatuh_tempo' => 'nullable',
        'nowarkat' => 'nullable',
        'rekening_id' => 'required',
        'jumlah' => 'required',
        'keterangan' => 'nullable',
    ];

    protected $listeners = [
        'selectsupplier' => 'selectsupplier',
        'selectrekening' => 'selectrekening',
    ];

    public function selectrekening($id){
        $this->rekening_id=$id;
        $rekening = Rekening::find($this->rekening_id);
        $this->rekening = $rekening->norek.' - '.$rekening->atas_nama;
    }

    public function selectsupplier($id){
        $this->supplier_id=$id;
        $supplier = Supplier::find($this->supplier_id);
        $this->supplier = $supplier->nama_supplier;
    }

    public function save(){

        $this->jumlah = str_replace(',', '', $this->jumlah);
        $this->validate();

        DB::beginTransaction();

        try{

            $rekening = Rekening::find($this->rekening_id);

            $nomorterakhir = DB::table('pembayarans')->orderBy('id', 'DESC')->get();

                if (count($nomorterakhir) == 0){
                    $nopembayaran = '0001/PB/'.date('m').'/'.date('Y');               
                }else{
                    if (
                        substr($nomorterakhir[0]->nopembayaran, 8, 2) == date('m')
                        &&
                        substr($nomorterakhir[0]->nopembayaran, 11, 4) == date('Y')
                    ) {
                        $noakhir = intval(substr($nomorterakhir[0]->nopembayaran, 0, 4)) + 1;
                        $nopembayaran = substr('0000' . $noakhir, -4) . '/PB/' . date('m') . '/' . date('Y');
                    } else {
                        $nopembayaran = '0001/PB/' . date('m') . '/' . date('Y');
                    }
                }

            DB::update("Exec SP_Pembayaran  '$nopembayaran',        '$this->tgl_bayar', 
                                            '$this->tipe_pembayaran', '$this->nowarkat', 
                                            '$this->jatuh_tempo',     $rekening->bank_id,
                                            $this->rekening_id,     $this->supplier_id,
                                            $this->jumlah,          '$this->keterangan'");
            
            DB::commit();

            $this->closeModal();

            $this->alert('success', 'Save Success', [
                'position' => 'center'
            ]);

            $this->emitTo('pembayaran.pembayaran-pembelian-table', 'pg:eventRefresh-default');


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
        return view('livewire.pembayaran.pembayaran-pembelian-modal');
    }
}
