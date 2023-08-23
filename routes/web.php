<?php

use App\Http\Controllers\CreateCoaCustomerSupplier;
use App\Http\Controllers\PrintController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\GiveAllPermissionController;
use App\Http\Controllers\LaporanAccountingController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanFinanceController;
use App\Http\Controllers\LaporanPajakController;
use App\Http\Controllers\LaporanPembelianController;
use App\Http\Controllers\LaporanPersediaanController;
use App\Http\Livewire\AccessComponent;
use App\Http\Livewire\ChartComponent;
use App\Http\Livewire\DashboardComponent;
use App\Http\Livewire\Jurnal\JurnalManualComponent;
use App\Http\Livewire\Laporan\BukuBesarHutang;
use App\Http\Livewire\Laporan\LaporanComponent;
use App\Http\Livewire\Opname\OpnameComponent;
use App\Http\Livewire\Pembayaran\PembayaranPembelianComponent;
use App\Http\Livewire\Penerimaan\PenerimaanComponent;
use App\Http\Livewire\Produksi\TicketProduksiComponent;
use App\Http\Livewire\User\PermissionComponent;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Spatie\Permission\Contracts\Permission;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return redirect('/dashboard');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');


Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    //Route::get('backupdatabase', [BackupController::class,'index'])->name('backupdatabase');

    Route::get('dashboard', DashboardComponent::class)->name('dashboard');
    Route::get('register', [RegisteredUserController::class,'create'])->name('register');
    Route::get('access', AccessComponent::class)->name('access');
    Route::post('register', [RegisteredUserController::class,'store']);
    Route::get('alat', \App\Http\Livewire\Alat\AlatComponent::class)->name('alat');
    Route::get('satuan', \App\Http\Livewire\Satuan\SatuanComponent::class)->name('satuan');
    Route::get('barang', \App\Http\Livewire\Barang\BarangComponent::class)->name('barang');
    Route::get('mutubeton', \App\Http\Livewire\Mutubeton\MutubetonComponent::class)->name('mutubeton');
    Route::get('supplier', \App\Http\Livewire\Supplier\SupplierComponent::class)->name('supplier');
    Route::get('customer', \App\Http\Livewire\Customer\CustomerComponent::class)->name('customer');
    Route::get('driver', \App\Http\Livewire\Driver\DriverComponent::class)->name('driver');
    Route::get('kendaraan', \App\Http\Livewire\Kendaraan\KendaraanComponent::class)->name('kendaraan');
    Route::get('pajak', \App\Http\Livewire\Pajak\PajakComponent::class)->name('pajak');
    Route::get('jaraktempuh', \App\Http\Livewire\Rate\JaraktempuhComponent::class)->name('jaraktempuh');
    Route::get('rate', \App\Http\Livewire\Rate\RateComponent::class)->name('rate');
    Route::get('bahanbakar', \App\Http\Livewire\Barang\BahanbakarComponent::class)->name('bahanbakar');
    Route::get('bank', \App\Http\Livewire\Bank\BankComponent::class)->name('bank');
    Route::get('rekening', \App\Http\Livewire\Bank\RekeningComponent::class)->name('rekening');
    Route::get('itemsewa', \App\Http\Livewire\Sewa\ItemsewaComponent::class)->name('itemsewa');
    Route::get('salesorder', \App\Http\Livewire\Penjualan\SalesorderComponent::class)->name('salesorder');
    Route::get('salesordersewa', \App\Http\Livewire\Sewa\SalesorderSewaComponent::class)->name('salesordersewa');
    Route::get('purchaseorder', \App\Http\Livewire\Pembelian\PurchaseorderComponent::class)->name('purchaseorder');
    Route::get('ticketmaterial', \App\Http\Livewire\Penjualan\TicketComponent::class)->name('ticketmaterial');
    Route::get('ticketproduksi', TicketProduksiComponent::class)->name('ticketproduksi');
    Route::get('timesheet', \App\Http\Livewire\Sewa\SalesorderSewaTimesheetComponent::class)->name('timesheet');
    Route::get('penjualanretail', \App\Http\Livewire\Penjualan\PenjualanRetailComponent::class)->name('penjualanretail');
    Route::get('invoice', \App\Http\Livewire\Invoice\InvoiceComponent::class)->name('invoice');
    Route::get('coa',  \App\Http\Livewire\Coa\CoaComponent::class)->name('coa');
    Route::get('kategori',  \App\Http\Livewire\Barang\KategoriComponent::class)->name('kategori');
    Route::get('produksi',  \App\Http\Livewire\Produksi\ProduksiComponent::class)->name('produksi'); 
    Route::get('penjualan',  \App\Http\Livewire\Penjualan\PenjualanComponent::class)->name('penjualan');
    Route::get('pengisianbbm',  \App\Http\Livewire\Bbm\PengisianBbmComponent::class)->name('pengisianbbm');
    Route::get('pengisianbbmstok',  \App\Http\Livewire\Bbm\PengisianBbmStokComponent::class)->name('pengisianbbmstok');
    Route::get('tambahanbbm',  \App\Http\Livewire\Bbm\PenambahanBbmComponent::class)->name('tambahanbbm');
    Route::get('biaya',  \App\Http\Livewire\Biaya\BiayaComponent::class)->name('biaya');
    Route::get('pengeluaranbiaya', \App\Http\Livewire\PengeluaranBiaya\PengeluaranBiayaComponent::class)->name('pengeluaranbiaya');
    Route::get('pemakaianbarang', \App\Http\Livewire\PemakaianBarang\PemakaianBarangComponent::class)->name('pemakaianbarang');
    Route::get('pencairanwarkatkeluar', \App\Http\Livewire\Pembayaran\PencairanWarkatKeluarComponent::class)->name('pencairanwarkatkeluar');
    Route::get('pencairanwarkatmasuk', \App\Http\Livewire\Penerimaan\PencairanWarkatMasukComponent::class)->name('pencairanwarkatmasuk');
    Route::get('golongan', \App\Http\Livewire\Inventaris\GolonganComponent::class)->name('golongan');
    Route::get('inventaris', \App\Http\Livewire\Inventaris\InventarisComponent::class)->name('inventaris');
    //Route::get('migrasicoa', [CreateCoaCustomerSupplier::class,'index'])->name('migrasicoa');
    Route::get('jurnalmanual', JurnalManualComponent::class)->name('jurnalmanual');
    Route::get('pembayaranpembelian', PembayaranPembelianComponent::class)->name('pembayaranpembelian');
    Route::get('penerimaanpembayaran', PenerimaanComponent::class)->name('penerimaanpembayaran');
    Route::get('permission', PermissionComponent::class)->name('permission');
    Route::get('opname', OpnameComponent::class)->name('opname');

    //Print
    Route::get('stokmaterial', [LaporanPersediaanController::class,'stokmaterial'])->name('stokmaterial');
    Route::get('printso/{id}', [\App\Http\Controllers\PrintController::class,'so'])->name('printso');
    Route::get('printsosewa/{id}', [\App\Http\Controllers\PrintController::class,'sosewa'])->name('printsosewa');
    Route::get('printticketkosong', [\App\Http\Controllers\PrintController::class,'ticketkosong'])->name('printticketkosong');
    Route::get('printticket/{id}', [\App\Http\Controllers\PrintController::class,'ticket'])->name('printticket');
    Route::get('printticketproduksi/{id}', [\App\Http\Controllers\PrintController::class,'ticketproduksi'])->name('printticketproduksi');
    Route::get('printpo/{id}', [\App\Http\Controllers\PrintController::class,'po'])->name('printpo');
    Route::get('printinvoice/{id}', [\App\Http\Controllers\PrintController::class,'invoice'])->name('printinvoice');
    Route::get('printkwitansi/{id}', [\App\Http\Controllers\PrintController::class,'kwitansi'])->name('printkwitansi');
    Route::get('printconcretepump/{id}', [\App\Http\Controllers\PrintController::class,'concretepump'])->name('printconcretepump');
    Route::get('printbuktikas/{id}', [\App\Http\Controllers\PrintController::class,'buktikas'])->name('printbuktikas');
    Route::get('printbuktikaspenerimaan/{id}', [\App\Http\Controllers\PrintController::class,'buktikaspenerimaan'])->name('printbuktikaspenerimaan');
    Route::get('printbuktikasmanual/{id}', [\App\Http\Controllers\PrintController::class,'buktikasmanual'])->name('printbuktikasmanual');
    Route::get('printbuktikasbiaya/{id}', [\App\Http\Controllers\PrintController::class,'buktikasbiaya'])->name('printbuktikasbiaya');
    Route::get('timesheetso/{so_id}', [\App\Http\Controllers\PrintController::class,'timesheet'])->name('timesheetso');
    Route::get('exporttimesheetso/{so_id}', [\App\Http\Controllers\ExportController::class,'ExportTimesheet'])->name('exporttimesheetso');
    Route::get('ttdriver/{tgl_awal}/{tgl_akhir}/{driver_id}', [PrintController::class,'ttdriver'])->name('ttdriver');
    Route::get('laporan', LaporanComponent::class)->name('laporan');
    Route::get('laporanrekapgaji/{tgl_awal}/{tgl_akhir}', [LaporanController::class,'gaji'])->name('rekapgaji');
    Route::get('laporanrekapgajidriver/{tgl_awal}/{tgl_akhir}/{driver_id}', [LaporanController::class,'gajidriver'])->name('rekapgajidriver');
    Route::get('rekapticket/{soid}', [LaporanController::class,'rekapticket'])->name('rekapticket');
    Route::get('rekapticketall/{soid}', [LaporanController::class,'rekapticketall'])->name('rekapticketall');
    Route::get('rekaptickettanggal/{tgl_awal}/{tgl_akhir}', [LaporanController::class,'rekaptickettanggal'])->name('rekaptickettanggal');
    Route::get('exportrekapticket/{tgl_awal}/{tgl_akhir}', [ExportController::class,'exportrekapticket'])->name('exportrekapticket');
    Route::get('rekapticketsotanggal/{tgl_awal}/{tgl_akhir}/{so_id}', [LaporanController::class,'rekapticketsotanggal'])->name('rekapticketsotanggal');
    Route::get('laporanpengirimanbeton/{tgl_awal}/{tgl_akhir}', [LaporanController::class,'laporanpengirimanbeton'])->name('laporanpengirimanbeton');
    Route::get('rekapconcretepump/{soid}', [LaporanController::class,'rekapconcretepump'])->name('rekapconcretepump');
    Route::get('laporanhutang/{tgl_awal}/{tgl_akhir}', [LaporanController::class,'rekaphutang'])->name('rekaphutang');
    Route::get('laporanpenjualanbeton/{tgl_awal}/{tgl_akhir}', [LaporanController::class,'penjualanbeton'])->name('laporanpenjualanbeton');
    Route::get('laporanpenjualanbetonharian/{tgl}', [LaporanController::class,'penjualanbetonharian'])->name('laporanpenjualanbetonharian');
    Route::get('laporanproduksibetonharian/{tgl_awal}/{tgl_akhir}', [LaporanController::class,'laporanproduksibetonperhari'])->name('laporanproduksibetonharian');
    Route::get('laporanproduksicustomer/{tgl_awal}/{tgl_akhir}', [LaporanController::class,'laporanproduksicustomer'])->name('laporanproduksicustomer');
    Route::get('laporanpenjualanbetonmobil/{tgl_awal}/{tgl_akhir}/{kendaraan_id}', [LaporanController::class,'laporanpenjualanpermobil'])->name('laporanpenjualanbetonmobil');
    Route::get('laporanpenjualanbetoncustomer/{tgl_awal}/{tgl_akhir}', [LaporanController::class,'penjualanbetoncustomer'])->name('laporanpenjualanbetoncustomer');
    Route::get('penjualanmutubeton/{tgl_awal}/{tgl_akhir}', [LaporanController::class,'penjualanmutubeton'])->name('penjualanmutubeton');
    Route::get('laporanrekapconcretepump/{tgl_awal}/{tgl_akhir}', [LaporanController::class,'laporanrekapconcretepump'])->name('laporanrekapconcretepump');
    Route::get('laporanpajakmasukan/{tgl_awal}/{tgl_akhir}', [LaporanController::class,'pajakmasukan'])->name('pajakmasukan');
    Route::get('laporanpembelian/{tgl_awal}/{tgl_akhir}', [LaporanController::class,'laporanpembelian'])->name('laporanpembelian');
    Route::get('laporanpembeliansupplier/{tgl_awal}/{tgl_akhir}/{id_supplier}', [LaporanController::class,'laporanpembeliansupplier'])->name('laporanpembeliansupplier');
    Route::get('laporanpemakaianbarang/{tgl_awal}/{tgl_akhir}', [LaporanPersediaanController::class,'laporanpemakaianbarang'])->name('laporanpemakaianbarang');
    Route::get('laporanpemakaianbarangbeban/{tgl_awal}/{tgl_akhir}/{tipe}/{beban_id}', [LaporanPersediaanController::class,'laporanpemakaianbarangbeban'])->name('laporanpemakaianbarangbeban');
    Route::get('laporanpemakaianperbarang/{tgl_awal}/{tgl_akhir}/{tipe}/{beban_id}/{barang_id}', [LaporanPersediaanController::class,'laporanpemakaianperbarang'])->name('laporanpemakaianperbarang');
    Route::get('laporanwarkatmasuk/{tgl_awal}/{tgl_akhir}', [LaporanFinanceController::class,'laporanwarkatmasuk'])->name('laporanwarkatmasuk');
    Route::get('laporanwarkatkeluar/{tgl_awal}/{tgl_akhir}', [LaporanFinanceController::class,'laporanwarkatkeluar'])->name('laporanwarkatkeluar');
    Route::get('laporanpembelianbarang/{tgl_awal}/{tgl_akhir}/{barang_id}', [LaporanPembelianController::class,'laporanpembelianbarang'])->name('laporanpembelianbarang');
    Route::get('laporanpembelianppn/{tgl_awal}/{tgl_akhir}', [LaporanPembelianController::class,'laporanpembelianppn'])->name('laporanpembelianppn');
    Route::get('exportpembelianbarang/{tgl_awal}/{tgl_akhir}/{barang_id}', [ExportController::class,'exportpembelianbarang'])->name('exportpembelianbarang');
    Route::get('laporanbukubesarhutang/{id_supplier}/{tgl_awal}/{tgl_akhir}', [LaporanController::class,'bukubesarhutang'])->name('laporanbukubesarhutang');
    Route::get('laporanpengisianbbm/{tgl_awal}/{tgl_akhir}', [LaporanController::class,'laporanpengisianbbm'])->name('laporanpengisianbbm');
    Route::get('laporankomposisi', [LaporanPersediaanController::class,'laporankomposisi'])->name('laporankomposisi');
    Route::get('laporanstokall', [LaporanPersediaanController::class,'laporanstokall'])->name('laporanstokall');
    Route::get('laporanstokbarangtanggal/{tgl_awal}/{tgl_akhir}', [LaporanPersediaanController::class,'laporanstokbarangtanggal'])->name('laporanstokbarangtanggal');
    Route::get('laporankartustok/{tgl_awal}/{tgl_akhir}/{id_barang}', [LaporanPersediaanController::class,'laporankartustok'])->name('laporankartustok');
    Route::get('laporankartustokharian/{tgl_awal}/{tgl_akhir}/{id_barang}', [LaporanPersediaanController::class,'laporankartustokharian'])->name('laporankartustokharian');
    Route::get('laporansaldorekening/{tgl_awal}/{tgl_akhir}/{rekening_id}', [LaporanController::class,'laporansaldorekening'])->name('laporansaldorekening');
    Route::get('laporanrekapsaldokasbank/{tgl_awal}/{tgl_akhir}', [LaporanFinanceController::class,'laporanrekapsaldokasbank'])->name('laporanrekapsaldokasbank');
    Route::get('laporanjurnalumum/{tgl_awal}/{tgl_akhir}/{coa_id}', [LaporanController::class,'laporanjurnalumum'])->name('laporanjurnalumum');
    Route::get('exportjurnalumum/{tgl_awal}/{tgl_akhir}/{coa_id}', [ExportController::class,'exportjurnalumum'])->name('exportjurnalumum');
    Route::get('rekapinvoice/{tgl_awal}/{tgl_akhir}', [LaporanController::class,'rekapinvoice'])->name('rekapinvoice');
    Route::get('exportrekapinvoice/{tgl_awal}/{tgl_akhir}', [ExportController::class,'exportrekapinvoice'])->name('exportrekapinvoice');
    Route::get('exportrekapinvoiceretail/{tgl_awal}/{tgl_akhir}', [ExportController::class,'exportrekapinvoiceretail'])->name('exportrekapinvoiceretail');
    Route::get('rekapinvoiceretail/{tgl_awal}/{tgl_akhir}', [LaporanController::class,'rekapinvoiceretail'])->name('rekapinvoiceretail');
    Route::get('rekappengeluaranbiaya/{tgl_awal}/{tgl_akhir}', [LaporanController::class,'rekappengeluaranbiaya'])->name('rekappengeluaranbiaya');
    Route::get('laporanjurnalpengeluaranbiaya/{tgl_awal}/{tgl_akhir}', [LaporanController::class,'laporanjurnalpengeluaranbiaya'])->name('laporanjurnalpengeluaranbiaya');
    Route::get('laporanjtkendaraan/{kriteria}', [LaporanController::class,'laporanjtkendaraan'])->name('laporanjtkendaraan');
    Route::get('laporanpiutangall/{tgl_awal}/{tgl_akhir}', [LaporanAccountingController::class,'piutang'])->name('laporanpiutangall');
    Route::get('laporanpiutangkaryawan/{tgl_awal}/{tgl_akhir}', [LaporanAccountingController::class,'piutangkaryawan'])->name('laporanpiutangkaryawan');
    Route::get('laporanhutangall/{tgl_awal}/{tgl_akhir}', [LaporanAccountingController::class,'hutang'])->name('laporanhutangall');
    Route::get('laporanrekaphutangpajak/{tgl_awal}/{tgl_akhir}', [LaporanPajakController::class,'laporanhutangpajak'])->name('laporanrekaphutangpajak');
    Route::get('laporanrekapuangmukapajak/{tgl_awal}/{tgl_akhir}', [LaporanPajakController::class,'laporanuangmukapajak'])->name('laporanrekapuangmukapajak');
    Route::get('laporantrialbalance/{tahun}/{bulan}', [LaporanAccountingController::class,'trialbalance'])->name('laporantrialbalance');
    Route::get('laporanclosing/{tahun}/{bulan}', [LaporanAccountingController::class,'laporanclosing'])->name('laporanclosing');
    Route::get('laporanneraca/{tanggal}', [LaporanAccountingController::class,'neraca'])->name('laporanneraca');
    Route::get('laporanlabarugi/{tgl_awal}/{tgl_akhir}', [LaporanAccountingController::class,'labarugi'])->name('laporanlabarugi');
    Route::get('laporanjurnaltanggal/{tgl_awal}/{tgl_akhir}', [LaporanAccountingController::class,'laporanjurnaltanggal'])->name('laporanjurnaltanggal');
    Route::get('laporansaldopersediaan/{tgl_awal}/{tgl_akhir}', [LaporanPersediaanController::class,'laporansaldopersediaan'])->name('laporansaldopersediaan');
    Route::get('laporanrekapbiaya/{tgl_awal}/{tgl_akhir}', [LaporanFinanceController::class,'laporanrekapbiaya'])->name('laporanrekapbiaya');
    

    //Export
    Route::get('exportjurnaltanggal/{tgl_awal}/{tgl_akhir}', [ExportController::class,'exportjurnaltanggal'])->name('exportjurnaltanggal');
    Route::get('exportrekappengeluaranbiaya/{tgl_awal}/{tgl_akhir}', [ExportController::class,'exportrekappengeluaranbiaya'])->name('exportrekappengeluaranbiaya');
    Route::get('exportjurnalpengeluaranbiaya/{tgl_awal}/{tgl_akhir}', [ExportController::class,'exportjurnalpengeluaranbiaya'])->name('exportjurnalpengeluaranbiaya');
    Route::get('exportsaldorekening/{tgl_awal}/{tgl_akhir}/{rekening_id}', [ExportController::class,'exportsaldorekening'])->name('exportsaldorekening');
    Route::get('exportrekapsaldokasbank/{tgl_awal}/{tgl_akhir}', [ExportController::class,'exportrekapsaldokasbank'])->name('exportrekapsaldokasbank');
    Route::get('exportrekappiutang/{tgl_awal}/{tgl_akhir}', [ExportController::class,'exportrekappiutang'])->name('exportrekappiutang');
    Route::get('exportrekappiutangkaryawan/{tgl_awal}/{tgl_akhir}', [ExportController::class,'exportrekappiutangkaryawan'])->name('exportrekappiutangkaryawan');
    Route::get('exportrekaphutang/{tgl_awal}/{tgl_akhir}', [ExportController::class,'exportrekaphutang'])->name('exportrekaphutang');
    Route::get('exportrekapbiaya/{tgl_awal}/{tgl_akhir}', [ExportController::class,'exportrekapbiaya'])->name('exportrekapbiaya');
    Route::get('exportwarkatmasuk/{tgl_awal}/{tgl_akhir}', [ExportController::class,'exportwarkatmasuk'])->name('exportwarkatmasuk');
    Route::get('exportwarkatkeluar/{tgl_awal}/{tgl_akhir}', [ExportController::class,'exportwarkatkeluar'])->name('exportwarkatkeluar');

    Route::get('exportrekapuangmukapajak/{tgl_awal}/{tgl_akhir}', [ExportController::class,'exportrekapuangmukapajak'])->name('exportrekapuangmukapajak');
    Route::get('exportrekaphutangpajak/{tgl_awal}/{tgl_akhir}', [ExportController::class,'exportrekaphutangpajak'])->name('exportrekaphutangpajak');
    Route::get('exporttrialbalance/{tahun}/{bulan}', [ExportController::class,'exporttrialbalance'])->name('exporttrialbalance');
    Route::get('exportneraca/{tanggal}', [ExportController::class,'exportneraca'])->name('exportneraca');
    Route::get('exportlabarugi/{tgl_awal}/{tgl_akhir}', [ExportController::class,'exportlabarugi'])->name('exportlabarugi');
});
