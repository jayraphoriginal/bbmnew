<?php

use App\Http\Controllers\CreateCoaCustomerSupplier;
use App\Http\Controllers\PrintController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackupController;
use App\Http\Livewire\DashboardComponent;
use App\Http\Livewire\Jurnal\JurnalManualComponent;
use App\Http\Livewire\Laporan\BukuBesarHutang;
use App\Http\Livewire\Pembayaran\PembayaranPembelianComponent;
use App\Http\Livewire\User\PermissionComponent;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

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
    Route::get('dashboard', DashboardComponent::class)->name('dashboard');
    Route::get('register', [RegisteredUserController::class,'create'])->name('register');
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
    Route::get('timesheet', \App\Http\Livewire\Sewa\SalesorderSewaTimesheetComponent::class)->name('timesheet');
    Route::get('penjualanretail', \App\Http\Livewire\Penjualan\PenjualanRetailComponent::class)->name('penjualanretail');
    Route::get('invoice', \App\Http\Livewire\Invoice\InvoiceComponent::class)->name('invoice');
    Route::get('coa',  \App\Http\Livewire\Coa\CoaComponent::class)->name('coa');
    Route::get('kategori',  \App\Http\Livewire\Barang\KategoriComponent::class)->name('kategori');
    Route::get('produksi',  \App\Http\Livewire\Produksi\ProduksiComponent::class)->name('produksi'); 
    Route::get('penjualan',  \App\Http\Livewire\Penjualan\PenjualanComponent::class)->name('penjualan');
    Route::get('pengisianbbm',  \App\Http\Livewire\Bbm\PengisianBbmComponent::class)->name('pengisianbbm');
    Route::get('tambahanbbm',  \App\Http\Livewire\Bbm\PenambahanBbmComponent::class)->name('tambahanbbm');
    Route::get('biaya',  \App\Http\Livewire\Biaya\BiayaComponent::class)->name('biaya');
    Route::get('pengeluaranbiaya', \App\Http\Livewire\PengeluaranBiaya\PengeluaranBiayaComponent::class)->name('pengeluaranbiaya');
    Route::get('pemakaianbarang', \App\Http\Livewire\PemakaianBarang\PemakaianBarangComponent::class)->name('pemakaianbarang');
    Route::get('golongan', \App\Http\Livewire\Inventaris\GolonganComponent::class)->name('golongan');
    Route::get('inventaris', \App\Http\Livewire\Inventaris\InventarisComponent::class)->name('inventaris');
    //Route::get('migrasicoa', [CreateCoaCustomerSupplier::class,'index'])->name('migrasicoa');
    Route::get('jurnalmanual', JurnalManualComponent::class)->name('jurnalmanual');
    Route::get('pembayaranpembelian', PembayaranPembelianComponent::class)->name('pembayaranpembelian');
    Route::get('permission', PermissionComponent::class)->name('permission');


    //Print
    Route::get('printso/{id}', [\App\Http\Controllers\PrintController::class,'so'])->name('printso');
    Route::get('printsosewa/{id}', [\App\Http\Controllers\PrintController::class,'sosewa'])->name('printsosewa');
    Route::get('printticket/{id}', [\App\Http\Controllers\PrintController::class,'ticket'])->name('printticket');
    Route::get('printpo/{id}', [\App\Http\Controllers\PrintController::class,'po'])->name('printpo');
    Route::get('printinvoice/{id}', [\App\Http\Controllers\PrintController::class,'invoice'])->name('printinvoice');
    Route::get('printkwitansi/{id}', [\App\Http\Controllers\PrintController::class,'kwitansi'])->name('printkwitansi');
    Route::get('printconcretepump/{id}', [\App\Http\Controllers\PrintController::class,'concretepump'])->name('printconcretepump');
    Route::get('laporanrekapgaji/{tgl_awal}/{tgl_akhir}', [PrintController::class,'gaji'])->name('rekapgaji');
    Route::get('laporanrekapgajidriver/{tgl_awal}/{tgl_akhir}/{driver_id}', [PrintController::class,'gajidriver'])->name('rekapgajidriver');
    
    Route::get('rekapticket/{soid}', [PrintController::class,'rekapticket'])->name('rekapticket');
    Route::get('rekaptickettanggal/{tgl_awal}/{tgl_akhir}', [PrintController::class,'rekaptickettanggal'])->name('rekaptickettanggal');
    Route::get('rekapconcretepump/{soid}', [PrintController::class,'rekapconcretepump'])->name('rekapconcretepump');
    Route::get('laporanhutang/{tgl_awal}/{tgl_akhir}', [PrintController::class,'rekaphutang'])->name('rekaphutang');
    Route::get('laporanpenjualanbeton/{tgl_awal}/{tgl_akhir}', [PrintController::class,'penjualanbeton'])->name('laporanpenjualanbeton');
    Route::get('penjualanmutubeton/{tgl_awal}/{tgl_akhir}', [PrintController::class,'penjualanmutubeton'])->name('penjualanmutubeton');
    Route::get('laporanpajakmasukan/{tgl_awal}/{tgl_akhir}', [PrintController::class,'pajakmasukan'])->name('pajakmasukan');
    Route::get('laporanpembelian/{tgl_awal}/{tgl_akhir}', [PrintController::class,'laporanpembelian'])->name('laporanpembelian');
    Route::get('laporanpembeliansupplier/{tgl_awal}/{tgl_akhir}/{id_supplier}', [PrintController::class,'laporanpembeliansupplier'])->name('laporanpembeliansupplier');
    Route::get('laporanbukubesarhutang/{id_supplier}/{tgl_awal}/{tgl_akhir}', [PrintController::class,'bukubesarhutang'])->name('laporanbukubesarhutang');
    Route::get('backup', [BackupController::class,'index'])->name('backup');
});
