<?php

namespace App\Http\Livewire\Produksi;

use App\Models\Barang;
use App\Models\DBarang;
use App\Models\Produkturunan;
use App\Models\Satuan;
use App\Models\TmpProduksi;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use DB;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class ProduksiNewModal extends ModalComponent
{

    use LivewireAlert;
    public $driver, $deskripsi, $satuan, $ticket;
    public $barang_id, $produk_turunan_id, $jumlah, $satuan_id, $ticket_id, $jumlah_ticket, $keterangan, $tanggal;

    protected $listeners = [
        'selectprodukturunan' => 'selectprodukturunan',
        'selectticket' => 'selectticket',
    ];

    protected $rules=[
        'barang_id'=> 'required',
        'tanggal'=> 'required',
        'jumlah'=> 'required',
        'satuan_id' => 'required',
        'keterangan'=> 'required',
        'ticket_id' => 'required',
        'jumlah_ticket' => 'required'
    ];

    public function mount(){
        $user = Auth::user();
        if (!$user->hasPermissionTo('Produksi')){
            return abort(401);
        }
    }

    public function selectprodukturunan($id){
        $this->produk_turunan_id=$id;
        $produkturunan = Produkturunan::find($id);
        $barang = Barang::find($produkturunan->barang_id);
        $this->barang_id = $produkturunan->barang_id;
        $this->satuan_id=$barang->satuan_id;
        $this->satuan = Satuan::find($this->satuan_id)->satuan;
    }
  
    public function selectticket($id){
        $this->ticket_id=$id;
    }

    
    public function insertkomposisi(){

        $this->validate([
            'barang_id'=> 'required',
            'jumlah'=> 'required',
        ]);

        $this->jumlah = str_replace(',', '', $this->jumlah);
        DB::statement("SET NOCOUNT ON; Exec SP_InsertKomposisiProduksi ".$this->barang_id.",".$this->jumlah.",".Auth::user()->id);

        $this->emitTo('produksi.tmp-produksi-table', 'pg:eventRefresh-default');

    }

    public function save(){

        $this->validate();

        $this->jumlah = str_replace(',', '', $this->jumlah);
        $this->jumlah_ticket = str_replace(',', '', $this->jumlah_ticket);
        $this->tanggal = date_create($this->tanggal)->format('Y-m-d');
        $tmp = TmpProduksi::where('user_id',Auth::user()->id)->get();

        DB::beginTransaction();

        try{

           
            foreach($tmp as $komposisi){

                $pemakaianmaterial = $komposisi->jumlah;

                $jumlahstok = DBarang::where('barang_id',$komposisi->barang_id)
                                ->sum('jumlah');
                
                if ($jumlahstok < $pemakaianmaterial){
                    $barang = Barang::find($komposisi->barang_id);
                    DB::Rollback();
                    $this->alert('error', 'Stok '.$barang->nama_barang.' tidak mencukupi', [
                        'position' => 'center'
                    ]);
                    return;
                }
            }

            DB::statement("SET NOCOUNT ON; Exec SP_Produksi '".$this->tanggal."',".
            $this->barang_id.",".
            $this->jumlah.",".
            $this->satuan_id.",".
            $this->ticket_id.",".
            $this->jumlah_ticket.",'".
            $this->keterangan."',".
            Auth::user()->id);

            DB::commit();

        }catch(Throwable $e){
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
            return;
        }

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('produksi.produksi-table', 'pg:eventRefresh-default');

    }
    
    public static function modalMaxWidth(): string
    {
        return '7xl';
    }
    public function render()
    {
        return view('livewire.produksi.produksi-new-modal');
    }
}
