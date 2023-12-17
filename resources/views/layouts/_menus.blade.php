<div class="py-4 text-gray-500 dark:text-gray-400" x-data={persediaan:false,master:false,penjualan:false,sewa:false,pembelian:false,laporan:false,finance:false,accounting:false,bbm:false,batal:false,usermenu:false}>
    <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="/dashboard">
        {{ config('app.name') }}
    </a>
    <ul class="mt-6">
        <li class="relative px-2 py-3">
            <a @click="persediaan = !persediaan, master = false, penjualan = false, sewa=false, pembelian = false, laporan = false, finance = false, accounting = false, bbm = false, batal=false, usermenu=false" class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                <svg class="h-7 w-7"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" /></svg>
                <span class="ml-4 w-full">Persediaan</span>
                <svg class="h-7 w-7"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <polyline points="7 7 12 12 17 7" />  <polyline points="7 13 12 18 17 13" /></svg>
            </a>
        </li>
        <div x-show="persediaan">
            @can('Satuan')
                <x-menu-item route="satuan">Satuan</x-menu-item>
            @endcan
            @can('Mutubeton')
                <x-menu-item route="mutubeton">Mutu Beton</x-menu-item>
            @endcan
            @can('Kategori')
                <x-menu-item route="kategori">Kategori</x-menu-item>
            @endcan
            @can('Barang')
            <x-menu-item route="barang">Barang</x-menu-item>
            @endcan
            @can('Pemakaian Barang')
            <x-menu-item route="pemakaianbarang">Pemakaian Barang</x-menu-item>
            @endcan
            @can('Opname')
            <x-menu-item route="opname">Opname Stok</x-menu-item>
            @endcan
        </div>
        <li class="relative px-2 py-3">
            <a @click="persediaan = false, master = !master, penjualan = false, sewa=false, pembelian = false, laporan = false, finance = false, accounting = false, bbm = false, batal=false, usermenu=false" class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                <svg class="h-7 w-7"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" /></svg>
                <span class="ml-4 w-full">Alken</span>
                <svg class="h-7 w-7"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <polyline points="7 7 12 12 17 7" />  <polyline points="7 13 12 18 17 13" /></svg>
            </a>
        </li>
        <div x-show="master">
            @can('Driver')
                <x-menu-item route="driver">Driver</x-menu-item>
            @endcan
            @can('Kendaraan')
                <x-menu-item route="kendaraan">Kendaraan</x-menu-item>
            @endcan
            @can('Jarak Tempuh')
                <x-menu-item route="jaraktempuh">Jarak Tempuh</x-menu-item>
            @endcan
            @can('Rate')
                <x-menu-item route="rate">Rate</x-menu-item>
            @endcan
            @can('Alat')
                <x-menu-item route="alat">Alat</x-menu-item>
            @endcan
        </div>
        <li class="relative px-2 py-3">
            <a @click=" master = false, penjualan = !penjualan, sewa=false, pembelian = false, laporan = false, finance = false, accounting = false, bbm = false, batal=false, usermenu=false" class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                <svg class="h-7 w-7"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" /></svg>
                <span class="ml-4 w-full">Penjualan</span>
                <svg class="h-7 w-7"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <polyline points="7 7 12 12 17 7" />  <polyline points="7 13 12 18 17 13" /></svg>
            </a>
        </li>
        <div x-show="penjualan">
            @can('Customer')
            <x-menu-item route="customer">Customer</x-menu-item>
            @endcan
            @can('PO Customer')
            <x-menu-item route="salesorder">Sales Order</x-menu-item>
            @endcan
            @can('Ticket')
            <x-menu-item route="ticketmaterial">Ticket</x-menu-item>
            @endcan
            @can('Penjualan Retail')
            <x-menu-item route="penjualanretail">Penjualan Retail</x-menu-item>
            @endcan
            @can('Penjualan Barang')
            <x-menu-item route="penjualan">Penjualan Barang</x-menu-item>
            @endcan
            @can('Ticket Produksi')
            <x-menu-item route="ticketproduksi">Ticket Produksi</x-menu-item>
            @endcan
            @can('Produksi')
            <x-menu-item route="produksi">Produksi</x-menu-item>
            @endcan
        </div>
        <li class="relative px-2 py-3">
            <a @click=" master = false, penjualan = false, sewa = !sewa, pembelian = false, laporan = false, finance = false, accounting = false, bbm = false, batal=false, usermenu=false" class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                <svg class="h-7 w-7"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" /></svg>
                <span class="ml-4 w-full">Sewa</span>
                <svg class="h-7 w-7"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <polyline points="7 7 12 12 17 7" />  <polyline points="7 13 12 18 17 13" /></svg>
            </a>
        </li>
        <div x-show="sewa">
            @can('Item Sewa')
                <x-menu-item route="itemsewa">Item Sewa</x-menu-item>
            @endcan
            @can('Sales Order Sewa')
                <x-menu-item route="salesordersewa">Sales Order Sewa</x-menu-item>
            @endcan
            @can('Timesheet')
                <x-menu-item route="timesheet">Timesheet</x-menu-item>
            @endcan
        </div>
        <li class="relative px-2 py-3">
            <a @click=" master = false, penjualan = false, sewa=false, pembelian = !pembelian, laporan = false, finance = false, accounting = false, bbm = false, batal=false, usermenu=false" class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                <svg class="h-7 w-7"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" /></svg>
                <span class="ml-4 w-full">Pembelian</span>
                <svg class="h-7 w-7"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <polyline points="7 7 12 12 17 7" />  <polyline points="7 13 12 18 17 13" /></svg>
            </a>
        </li>
        <div x-show="pembelian">
            @can('Supplier')
                <x-menu-item route="supplier">Supplier</x-menu-item>
            @endcan
            @can('Purchase Order')
                <x-menu-item route="purchaseorder">Purchase Order</x-menu-item>
            @endcan
        </div>
        <li class="relative px-2 py-3">
            <a @click=" master = false, penjualan = false, sewa=false, pembelian = false, laporan = false, finance = !finance, accounting = false, bbm = false, batal=false, usermenu=false" class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                <svg class="h-7 w-7"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" /></svg>
                <span class="ml-4 w-full">Finance</span>
                <svg class="h-7 w-7"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <polyline points="7 7 12 12 17 7" />  <polyline points="7 13 12 18 17 13" /></svg>
            </a>
        </li>
        <div x-show="finance">
            @can('Bank')
                <x-menu-item route="bank">Bank</x-menu-item>
            @endcan
            @can('Rekening')
                <x-menu-item route="rekening">Rekening</x-menu-item>
            @endcan
            @can('Invoice')
                <x-menu-item route="invoice">Invoice</x-menu-item>
            @endcan
            @can('Biaya')
                <x-menu-item route="biaya">Biaya</x-menu-item>
            @endcan
            @can('Pengeluaran Biaya')
                <x-menu-item route="pengeluaranbiaya">Pengeluaran Biaya</x-menu-item>
            @endcan
            @can('Pembayaran Pembelian')
                <x-menu-item route="pembayaranpembelian">Pembayaran Pembelian</x-menu-item>
            @endcan
            @can('Pencairan Warkat Keluar')
                <x-menu-item route="pencairanwarkatkeluar">Pencairan Warkat Keluar</x-menu-item>
            @endcan
            @can('Penerimaan Pembayaran')
                <x-menu-item route="penerimaanpembayaran">Penerimaan Pembayaran</x-menu-item>
            @endcan
            @can('Pencairan Warkat Masuk')
                <x-menu-item route="pencairanwarkatmasuk">Pencairan Warkat Masuk</x-menu-item>
            @endcan
        </div>
        <li class="relative px-2 py-3">
            <a @click=" master = false, penjualan = false, sewa = false, pembelian = false, laporan = false, finance = false, accounting = false, bbm = !bbm, batal=false, usermenu=false" class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                <svg class="h-7 w-7"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" /></svg>
                <span class="ml-4 w-full">Bahan Bakar</span>
                <svg class="h-7 w-7"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <polyline points="7 7 12 12 17 7" />  <polyline points="7 13 12 18 17 13" /></svg>
            </a>
        </li>
        <div x-show="bbm">
            @can('Bahan Bakar')
                <x-menu-item route="bahanbakar">Bahan Bakar</x-menu-item>
            @endcan
            @can('Pengisian BBM')
                <x-menu-item route="pengisianbbm">Pengisian BBM</x-menu-item>
            @endcan
            @can('Pengisian Bbm Stok')
                <x-menu-item route="pengisianbbmstok">Pengisian BBM Stok</x-menu-item>
            @endcan
            @can('Tambahan BBM')
                <x-menu-item route="tambahanbbm">Tambahan BBM</x-menu-item>
            @endcan
        </div>
        <li class="relative px-2 py-3">
            <a @click=" master = false, penjualan = false, sewa = false, pembelian = false, laporan = false, finance = false, accounting = !accounting, bbm = false, batal=false, usermenu=false" class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                <svg class="h-7 w-7"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" /></svg>
                <span class="ml-4 w-full">Accounting</span>
                <svg class="h-7 w-7"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <polyline points="7 7 12 12 17 7" />  <polyline points="7 13 12 18 17 13" /></svg>
            </a>
        </li>
        <div x-show="accounting">
            @can('Pajak')
                <x-menu-item route="pajak">Pajak</x-menu-item>
            @endcan
            @can('COA')
                <x-menu-item route="coa">Coa</x-menu-item>
            @endcan
            @can('Golongan Inventaris')
                <x-menu-item route="golongan">Golongan Inventaris</x-menu-item>
            @endcan
            @can('Inventaris')
                <x-menu-item route="inventaris">Inventaris</x-menu-item>
            @endcan
            @can('Jurnal Manual')
                <x-menu-item route="jurnalmanual">Jurnal Manual</x-menu-item>
            @endcan
            @can('Closing Account')
                <li class="relative px-6 py-3 cursor-pointer">
                    <a
                        onclick="livewire.emit('openModal', 'closing-account')"
                        class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        <span class="ml-4">Closing Account</span>
                    </a>
                </li>
            @endcan
            @can('Open Closing')
            <li class="relative px-6 py-3 cursor-pointer">
                <a
                    onclick="livewire.emit('openModal', 'open-closing')"
                    class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    <span class="ml-4">Open Closing</span>
                </a>
            </li>
        @endcan
        </div>
        <li class="relative px-2 py-3">
            <a @click=" master = false, penjualan = false, sewa = false, pembelian = false, laporan = false, finance = false, accounting = false, bbm = false, batal=false, usermenu=!usermenu" class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                <svg class="h-7 w-7"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" /></svg>
                <span class="ml-4 w-full">User Menu</span>
                <svg class="h-7 w-7"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <polyline points="7 7 12 12 17 7" />  <polyline points="7 13 12 18 17 13" /></svg>
            </a>
        </li>
        <div x-show="usermenu">
            @can('Register')
                <x-menu-item route="register">Register</x-menu-item>
            @endcan
            @can('Access')
                <x-menu-item route="access">Access User</x-menu-item>
            @endcan
        </div>
        
        <li class="relative px-2 py-3">
            <a @click=" master = false, penjualan = false, sewa = false, pembelian = false, laporan = false, finance = false, accounting = false, bbm = false, batal = !batal" class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                <svg class="h-7 w-7"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" /></svg>
                <span class="ml-4 w-full">Batal</span>
                <svg class="h-7 w-7"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <polyline points="7 7 12 12 17 7" />  <polyline points="7 13 12 18 17 13" /></svg>
            </a>
        </li>
        <div x-show="batal">
            @can('Pembatalan Ticket')
                <li class="relative px-2 py-3">
                    <a 
                    onclick="livewire.emit('openModal', 'batal.batal-ticket-modal')"
                        class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        <span class="ml-4">Pembatalan Ticket</span>
                    </a>
                </li>
            @endcan
            @can('Pembatalan Pembelian')
                <li class="relative px-2 py-3">
                    <a 
                    onclick="livewire.emit('openModal', 'batal.batal-pembelian')"
                        class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        <span class="ml-4">Pembatalan Pembelian</span>
                    </a>
                </li>
            @endcan
            @can('Pembatalan Invoice')
                <li class="relative px-2 py-3">
                    <a 
                    onclick="livewire.emit('openModal', 'batal.batal-invoice-modal')"
                        class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        <span class="ml-4">Pembatalan Invoice</span>
                    </a>
                </li>
            @endcan
            @can('Batal Pengeluaran Biaya')
                <li class="relative px-2 py-3">
                    <a 
                    onclick="livewire.emit('openModal', 'batal.batal-pengeluaran-biaya')"
                        class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        <span class="ml-4">Pembatalan Pengeluaran Biaya</span>
                    </a>
                </li>
            @endcan
        </div>
        <li class="relative px-2 py-3">
            <a 
                href="{{route('laporan')}}"
                @click=" master = false, penjualan = false, sewa = false, pembelian = false, laporan = false, finance = false, accounting = false, bbm = false, batal = false" class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                <svg class="h-7 w-7"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" /></svg>
                <span class="ml-4 w-full">Laporan</span>
            </a>
        </li>
    </ul>
</div>
