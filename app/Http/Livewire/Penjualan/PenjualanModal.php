<?php

namespace App\Http\Livewire\Penjualan;

use App\Models\Barang;
use App\Models\Customer;
use App\Models\DBarang;
use App\Models\DPenjualan;
use App\Models\Journal;
use App\Models\Kartustok;
use App\Models\Kategori;
use App\Models\Mpajak;
use App\Models\MPenjualan;
use App\Models\TmpPenjualan;
use App\Models\VSuratJalan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class PenjualanModal extends ModalComponent
{

    use LivewireAlert;
    public MPenjualan $MPenjualan;
    public $editmode, $penjualan_id;
    public $customer;

    protected $listeners = ['selectcustomer' => 'selectcustomer'];

    protected $rules=[
        'MPenjualan.tgl_penjualan'=> 'required',
        'MPenjualan.marketing'=> 'required',
        'MPenjualan.pembayaran'=> 'required',
        'MPenjualan.jenis_pembayaran'=> 'required',
        'MPenjualan.jatuh_tempo'=> 'required',
        'MPenjualan.customer_id'=> 'required',
    ];

    public function mount(){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Penjualan Barang')){
            return abort(401);
        }

        if ($this->editmode=='edit') {
            $this->MPenjualan = MPenjualan::find($this->penjualan_id);
            $this->customer = Customer::find($this->MPenjualan->customer_id)->nama_customer;
        }else{
            $this->MPenjualan = new MPenjualan();
        }

    }

    public function selectcustomer($id){
        $this->MPenjualan->customer_id=$id;
    }

    public function save(){

        $this->validate();

        $tmp = TmpPenjualan::where('user_id',Auth::user()->id)->get();

        if(count($tmp)<=0){
            $this->alert('warning','Isi detail penjualan');
            return;
        }

        $suratjalan = VSuratJalan::where('m_penjualan_id', $this->MPenjualan->id)->get();

        if (count($suratjalan) > 0){
        
            if ($this->editmode=='edit') {
                $this->MPenjualan->save();
            }

            $this->alert('warning','Sudah Ada Surat Jalan, Rincian Barang gagal update');
            return;
        }else{



            DB::beginTransaction();

            if ($this->editmode!='edit') {
                $nomorterakhir = DB::table('m_penjualans')
                    ->orderBy('id', 'DESC')->get();

                if (count($nomorterakhir) == 0){
                    $nopenjualan = '0001/SS/'.date('m').'/'.date('Y');               
                }else{
                    if (
                        substr($nomorterakhir[0]->nopenjualan, 8, 2) == date('m')
                        &&
                        substr($nomorterakhir[0]->nopenjualan, 11, 4) == date('Y')
                    ) {
                        $noakhir = intval(substr($nomorterakhir[0]->nopenjualan, 0, 4)) + 1;
                        $nopenjualan = substr('0000' . $noakhir, -4) . '/SS/' . date('m') . '/' . date('Y');
                    } else {
                        $nopenjualan = '0001/SS/' . date('m') . '/' . date('Y');
                    }
                }

                $pajak = Mpajak::where('jenis_pajak','PPN')->first();

                $this->MPenjualan->nopenjualan = $nopenjualan;
                $this->MPenjualan->status = 'Open';
                $this->MPenjualan->pajak = $pajak->persen;
            }
            try{
                $this->MPenjualan->save();

                foreach($tmp as $tmpbarang){
                    $dpenjualan = New DPenjualan();
                    $dpenjualan['m_penjualan_id']=$this->MPenjualan->id;
                    $dpenjualan['barang_id']=$tmpbarang->barang_id;
                    $dpenjualan['jumlah']=$tmpbarang->jumlah;
                    $dpenjualan['sisa']=$tmpbarang->jumlah;
                    $dpenjualan['satuan_id']=$tmpbarang->satuan_id;
                    $dpenjualan['harga_intax']=$tmpbarang->harga_intax;
                    $dpenjualan['status_detail']='Open';
                    $dpenjualan->save();
                }              
                $tmp = TmpPenjualan::where('user_id',Auth::user()->id)->delete();
                DB::commit();
            }
            catch(Throwable $e){
                $this->alert('error', $e->getMessage(), [
                    'position' => 'center'
                ]);
                return;
            }
            
            $this->penjualan_id = $this->MPenjualan->id;

            $this->closeModal();

            $this->alert('success', 'Save Success', [
                'position' => 'center'
            ]);

            $this->emitTo('penjualan.salesorder-table', 'pg:eventRefresh-default');
        }
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }

    public function render()
    {
        $user = Auth::user();
        if (!$user->hasPermissionTo('Penjualan Barang')){
            return abort(401);
        }
        return view('livewire.penjualan.penjualan-modal');
    }
}
