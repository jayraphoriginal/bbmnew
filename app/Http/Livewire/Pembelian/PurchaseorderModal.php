<?php

namespace App\Http\Livewire\Pembelian;

use App\Models\Alat;
use App\Models\MPurchaseorder;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class PurchaseorderModal extends ModalComponent
{
    use LivewireAlert;
    public MPurchaseorder $Mpo;
    public $editmode, $po_id;
    public $supplier, $kendaraan, $alat;

    protected $listeners = [
        'selectsupplier' => 'selectsupplier',
        'selectkendaraan' => 'selectkendaraan',
        'selectalat' => 'selectalat'
    ];

    protected $rules=[
        'Mpo.nofaktur'=> 'required',
        'Mpo.tgl_masuk'=> 'required',
        'Mpo.tipe' => 'required',
        'Mpo.jatuh_tempo'=> 'required',
        'Mpo.supplier_id'=> 'required',
        'Mpo.pembebanan'=> 'required',
        'Mpo.jenis_pembebanan'=> 'required',
    ];

    public function mount(){

        if ($this->editmode=='edit') {
            $this->Mpo = MPurchaseorder::find($this->po_id);
            $this->supplier = Supplier::find($this->Mpo->supplier_id)->nama_supplier;
            
            if ($this->Mpo->jenis_pembebanan=='Biaya Kendaraan'){
                $this->kendaraan = Supplier::find($this->Mpo->beban_id)->nopol;
            }
            elseif($this->Mpo->jenis_pembebanan=='Biaya Alat'){
                $this->alat = Alat::find($this->Mpo->beban_id)->nama_alat;
            }
        }else{
            $this->Mpo = new MPurchaseorder();
        }

    }

    public function selectsupplier($id){
        $this->Mpo->supplier_id=$id;
    }
    public function selectkendaraan($id){
        $this->Mpo->beban_id=$id;
    }
    public function selectalat($id){
        $this->Mpo->beban_id=$id;
    }

    public function save(){

        $this->validate();

        if ($this->editmode!='edit') {
            $nomorterakhir = DB::table('m_purchaseorders')
                ->orderBy('id', 'DESC')->get();

            if (count($nomorterakhir) == 0){
                $nopo = '0001/PO/'.date('m').'/'.date('Y');               
            }else{
                if (
                    substr($nomorterakhir[0]->nopo, 8, 2) == date('m')
                    &&
                    substr($nomorterakhir[0]->nopo, 11, 4) == date('Y')
                ) {
                    $noakhir = intval(substr($nomorterakhir[0]->nopo, 0, 4)) + 1;
                    $nopo = substr('0000' . $noakhir, -4) . '/PO/' . date('m') . '/' . date('Y');
                } else {
                    $nopo = '0001/PO/' . date('m') . '/' . date('Y');
                }

                
            }
            $this->Mpo->nopo = $nopo;
            $this->Mpo->dpp = 0;
            $this->Mpo->ppn = 0;
            $this->Mpo->total = 0;
            $this->Mpo->status= 'Open';
        }

        try{
            $this->Mpo->save();
        }
        catch(Throwable $e){
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
            return;
        }
        
        $this->po_id = $this->Mpo->id;
        
        $this->emit("openModal", "pembelian.purchaseorder-detail-modal",[$this->po_id]);

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('pembelian.purchaseorder-table', 'pg:eventRefresh-default');

    }

    public function render()
    {
        return view('livewire.pembelian.purchaseorder-modal');
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }
}
