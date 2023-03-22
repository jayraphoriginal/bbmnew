<?php

namespace App\Http\Livewire\Opname;

use App\Models\Barang;
use App\Models\Coa;
use App\Models\DBarang;
use App\Models\DOpname;
use App\Models\Journal;
use App\Models\Kartustok;
use App\Models\Kategori;
use App\Models\MOpname;
use App\Models\TmpOpname;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Throwable;

class OpnameModal extends ModalComponent
{

    use LivewireAlert;
    public MOpname $MOpname;
    public $editmode, $opname_id;

    protected $rules=[
        'MOpname.tgl_opname'=> 'required',
        'MOpname.tipe'=> 'required',
        'MOpname.keterangan'=> 'required',
    ];

    public function mount(){

        $user = Auth::user();
        if (!$user->hasPermissionTo('Opname')){
            return abort(401);
        }

        if ($this->editmode=='edit') {
            $this->MOpname = MOpname::find($this->penjualan_id);
        }else{
            $this->MOpname = new MOpname();
        }

    }

    public function save(){

        $this->validate();

        $tmp = TmpOpname::where('user_id',Auth::user()->id)->get();

        if(count($tmp)<=0){
            $this->alert('warning','Isi detail penjualan');
            return;
        }

        DB::beginTransaction();

        if ($this->editmode!='edit') {
            $nomorterakhir = DB::table('m_opnames')
                ->orderBy('id', 'DESC')->get();

            if (count($nomorterakhir) == 0){
                $noopname = '0001/OP/'.date('m').'/'.date('Y');               
            }else{
                if (
                    substr($nomorterakhir[0]->noopname, 8, 2) == date('m')
                    &&
                    substr($nomorterakhir[0]->noopname, 11, 4) == date('Y')
                ) {
                    $noakhir = intval(substr($nomorterakhir[0]->noopname, 0, 4)) + 1;
                    $noopname = substr('0000' . $noakhir, -4) . '/OP/' . date('m') . '/' . date('Y');
                } else {
                    $noopname = '0001/OP/' . date('m') . '/' . date('Y');
                }
            }


            $this->MOpname->noopname = $noopname;
            $this->MOpname->status = 'Open';
        }
        try{
            $this->MOpname->save();

            if ($this->MOpname->tipe =='Pengurangan'){
                foreach($tmp as $tmpbarang){

                    $pemakaianmaterial = $tmpbarang->jumlah;

                    $jumlahstok = DBarang::where('barang_id',$tmpbarang->barang_id)
                                    ->sum('jumlah');
                    
                    if ($jumlahstok < $pemakaianmaterial){
                        $barang = Barang::find($tmpbarang->barang_id);
                        DB::Rollback();
                        $this->alert('error', 'Stok '.$barang->nama_barang.' tidak mencukupi', [
                            'position' => 'center'
                        ]);
                        return;
                    }else{
                        $detailbarang = DBarang::where('barang_id',$tmpbarang->barang_id)
                                        ->where('jumlah', '>',0)
                                        ->orderBy('tgl_masuk','asc')
                                        ->get();

                        foreach($detailbarang as $barang){

                            if ($pemakaianmaterial > 0){
                                if($pemakaianmaterial > $barang->jumlah){
                                    
                                    $stok = DBarang::find($barang->id);
                                    $pemakaianmaterial = $pemakaianmaterial - $stok->jumlah;
                                    $pengurangan = $stok->jumlah;
                                    $stok['jumlah']=0;
                                    $stok->save();

                                    $jumlahstok = DBarang::where('barang_id',$tmpbarang->barang_id)
                                        ->sum('jumlah');

                                    $dopname = New DOpname();
                                    $dopname['m_opname_id']=$this->MOpname->id;
                                    $dopname['barang_id']=$tmpbarang->barang_id;
                                    $dopname['jumlah']=$pengurangan;
                                    $dopname['satuan_id']=$tmpbarang->satuan_id;
                                    $dopname['hpp']=$stok->hpp;
                                    $dopname['status_detail']='Open';
                                    $dopname->save();

                                    $kartustok = new Kartustok();
                                    $kartustok['tanggal'] = date_create($this->MOpanme->tgl_opname)->format('Y-m-d');
                                    $kartustok['barang_id']=$tmpbarang->barang_id;
                                    $kartustok['tipe']='Stok Opname';
                                    $kartustok['trans_id']=$this->MOpname->id;
                                    $kartustok['increase']=0;
                                    $kartustok['decrease']=$pengurangan;
                                    $kartustok['harga_debet']=0;
                                    $kartustok['harga_kredit']=$stok->hpp;
                                    $kartustok['qty']=$jumlahstok;
                                    $kartustok['modal']=$stok->hpp;
                                    $kartustok->save();

                                    $databarang = Barang::find($tmpbarang->barang_id);
                                    $kategori = Kategori::find($databarang->kategori_id);

                                    $journal = new Journal();
                                    $journal['tipe']='Stok Opname';
                                    $journal['trans_id']=$this->MOpname->id;
                                    $journal['tanggal_transaksi']=date_create($this->MOpanme->tgl_opname)->format('Y-m-d');
                                    $journal['coa_id']=$kategori->coa_hpp_id;
                                    $journal['debet']=round($stok->hpp*$pengurangan,4);
                                    $journal['kredit']=0;
                                    $journal->save();

                                    $journal = new Journal();
                                    $journal['tipe']='Stok Opname';
                                    $journal['trans_id']=$this->MOpname->id;
                                    $journal['tanggal_transaksi']=date_create($this->MOpanme->tgl_opname)->format('Y-m-d');
                                    $journal['coa_id']=$kategori->coa_asset_id;
                                    $journal['debet']=0;
                                    $journal['kredit']=round($stok->hpp*$pengurangan,4);
                                    $journal->save();

                                }else{

                                    $stok = DBarang::find($barang->id);
                                    $stok['jumlah']=$stok['jumlah']-$pemakaianmaterial;
                                    $stok->save();

                                    $jumlahstok = DBarang::where('barang_id',$tmpbarang->barang_id)
                                        ->sum('jumlah');

                                    $dopname = New DOpname();
                                    $dopname['m_opname_id']=$this->MOpname->id;
                                    $dopname['barang_id']=$tmpbarang->barang_id;
                                    $dopname['jumlah']=$pemakaianmaterial;
                                    $dopname['satuan_id']=$tmpbarang->satuan_id;
                                    $dopname['hpp']=$stok->hpp;
                                    $dopname['status_detail']='Open';
                                    $dopname->save();

                                    $kartustok = new Kartustok();
                                    $kartustok['tanggal'] = date_create($this->MOpanme->tgl_opname)->format('Y-m-d');
                                    $kartustok['barang_id']=$tmpbarang->barang_id;
                                    $kartustok['tipe']='Stok Opname';
                                    $kartustok['trans_id']=$this->MOpname->id;
                                    $kartustok['increase']=0;
                                    $kartustok['decrease']=$pemakaianmaterial;
                                    $kartustok['harga_debet']=0;
                                    $kartustok['harga_kredit']=$stok->hpp;
                                    $kartustok['qty']=$jumlahstok;
                                    $kartustok['modal']=$stok->hpp;
                                    $kartustok->save();

                                    $databarang = Barang::find($tmpbarang->barang_id);
                                    $kategori = Kategori::find($databarang->kategori_id);

                                    $journal = new Journal();
                                    $journal['tipe']='Stok Opname';
                                    $journal['trans_id']=$this->MOpname->id;
                                    $journal['tanggal_transaksi']=date_create($this->MOpanme->tgl_opname)->format('Y-m-d');
                                    $journal['coa_id']=$kategori->coa_hpp_id;
                                    $journal['debet']=round($stok->hpp*$pemakaianmaterial,4);
                                    $journal['kredit']=0;
                                    $journal->save();

                                    $journal = new Journal();
                                    $journal['tipe']='Stok Opname';
                                    $journal['trans_id']=$this->MOpname->id;
                                    $journal['tanggal_transaksi']=date_create($this->MOpanme->tgl_opname)->format('Y-m-d');
                                    $journal['coa_id']=$kategori->coa_asset_id;
                                    $journal['debet']=0;
                                    $journal['kredit']=round($stok->hpp*$pemakaianmaterial,4);
                                    $journal->save();

                                    $pemakaianmaterial = 0;

                                }
                            }
                        }
                    }  
                }

                $tmp = TmpOpname::where('user_id',Auth::user()->id)->delete();
                DB::commit();
            }
            else{
                foreach($tmp as $tmpbarang){

                    $lebihstok = $tmpbarang->jumlah;

                    $barang = DBarang::where('barang_id',$tmpbarang->barang_id)->orderby('tgl_masuk','asc')->first();

                    $stok = DBarang::find($barang->id);
                    $stok['jumlah']=$stok['jumlah']+$lebihstok;
                    $stok->save();

                    $jumlahstok = DBarang::where('barang_id',$tmpbarang->barang_id)
                        ->sum('jumlah');

                    $dopname = New DOpname();
                    $dopname['m_opname_id']=$this->MOpname->id;
                    $dopname['barang_id']=$tmpbarang->barang_id;
                    $dopname['jumlah']=$lebihstok;
                    $dopname['satuan_id']=$tmpbarang->satuan_id;
                    $dopname['hpp']=$stok->hpp;
                    $dopname['status_detail']='Open';
                    $dopname->save();

                    $kartustok = new Kartustok();
                    $kartustok['tanggal'] = date_create($this->MOpanme->tgl_opname)->format('Y-m-d');
                    $kartustok['barang_id']=$tmpbarang->barang_id;
                    $kartustok['tipe']='Stok Opname';
                    $kartustok['trans_id']=$this->MOpname->id;
                    $kartustok['increase']=$lebihstok;
                    $kartustok['decrease']=0;
                    $kartustok['harga_debet']=$stok->hpp;
                    $kartustok['harga_kredit']=0;
                    $kartustok['qty']=$jumlahstok;
                    $kartustok['modal']=$stok->hpp;
                    $kartustok->save();

                    $databarang = Barang::find($tmpbarang->barang_id);
                    $kategori = Kategori::find($databarang->kategori_id);

                    $journal = new Journal();
                    $journal['tipe']='Stok Opname';
                    $journal['trans_id']=$this->MOpname->id;
                    $journal['tanggal_transaksi']=date_create($this->MOpanme->tgl_opname)->format('Y-m-d');
                    $journal['coa_id']=$kategori->coa_asset_id;
                    $journal['debet']=round($stok->hpp*$lebihstok,4);
                    $journal['kredit']=0;
                    $journal->save();

                    $coa = Coa::where('kode_akun','710002')->first();

                    $journal = new Journal();
                    $journal['tipe']='Stok Opname';
                    $journal['trans_id']=$this->MOpname->id;
                    $journal['tanggal_transaksi']=date_create($this->MOpanme->tgl_opname)->format('Y-m-d');
                    $journal['coa_id']=$coa->id;
                    $journal['debet']=0;
                    $journal['kredit']=round($stok->hpp*$lebihstok,4);
                    $journal->save();

                    $pemakaianmaterial = 0;
                }
            }
        }
        catch(Throwable $e){
            $this->alert('error', $e->getMessage(), [
                'position' => 'center'
            ]);
            return;
        }
        
        $this->opname_id = $this->MOpname->id;

        $this->closeModal();

        $this->alert('success', 'Save Success', [
            'position' => 'center'
        ]);

        $this->emitTo('opname.opname-table', 'pg:eventRefresh-default');

    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }

    public function render()
    {
        return view('livewire.opname.opname-modal');
    }
}
