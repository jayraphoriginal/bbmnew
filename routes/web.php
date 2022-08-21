<?php

use App\Http\Controllers\CreateCoaCustomerSupplier;
use App\Http\Controllers\PrintController;
use Illuminate\Support\Facades\Route;

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
    Route::view('/dashboard','dashboard');
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
    Route::get('migrasicoa', [CreateCoaCustomerSupplier::class,'index'])->name('migrasicoa');

    //Print
    Route::get('printso/{id}', [\App\Http\Controllers\PrintController::class,'so'])->name('printso');
    Route::get('printsosewa/{id}', [\App\Http\Controllers\PrintController::class,'sosewa'])->name('printsosewa');
    Route::get('printticket/{id}', [\App\Http\Controllers\PrintController::class,'ticket'])->name('printticket');
    Route::get('printpo/{id}', [\App\Http\Controllers\PrintController::class,'po'])->name('printpo');
    Route::get('printinvoice/{id}', [\App\Http\Controllers\PrintController::class,'invoice'])->name('printinvoice');
    Route::get('printkwitansi/{id}', [\App\Http\Controllers\PrintController::class,'kwitansi'])->name('printkwitansi');
    Route::get('printconcretepump/{id}', [\App\Http\Controllers\PrintController::class,'concretepump'])->name('printconcretepump');
    Route::get('laporanrekapgaji/{tgl_awal}/{tgl_akhir}', [PrintController::class,'gaji'])->name('rekapgaji');
});
