<div class="w-full">
    <x-container title="Laporan">
        <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
            Persediaan
        </h4>
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Laporan</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <x-datarowtable title="Laporan Stok Barang All">
                            <a href="/laporanstokall" target="_blank"
                                class='px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple'>
                                <span class="material-icons align-middle text-center">print</span>
                            </a>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Stok Barang per Tanggal">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.laporan-stok-tanggal')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Kartu Stok">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.laporan-kartustok')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Kartu Stok Harian">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.laporan-kartu-stok-harian')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Saldo Persediaan">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.laporan-saldo-persediaan')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                    </tbody>
                </table>
            </div>
        </div>
        <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
            Komposisi
        </h4>
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Laporan</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <x-datarowtable title="Laporan Komposisi">
                            <a href="/laporankomposisi" target="_blank"
                                class='px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple'>
                                <span class="material-icons align-middle text-center">print</span>
                            </a>
                        </x-datarowtable>
                    </tbody>
                </table>
            </div>
        </div>
        <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
            Pembelian
        </h4>
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Laporan</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <x-datarowtable title="Laporan Pembelian">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.laporan-pembelian-modal')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Pembelian per Supplier">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.laporan-pembelian-supplier')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Pembelian per Barang">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.laporan-pembelian-barang')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Pengisian BBM">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.laporan-pengisian-bbm-modal')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                    </tbody>
                </table>
            </div>
        </div>
        <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300 mt-2">
            Penjualan
        </h4>
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Laporan</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <x-datarowtable title="Laporan Penjualan Beton Harian">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.laporan-penjualan-harian')">
                                Cetak
                        </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Penjualan Beton">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.penjualan-beton')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Penjualan Beton Per Customer">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.laporan-penjualan-customer')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Penjualan Beton Per Mobil">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.laporan-penjualan-per-mobil')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Penjualan per Mutubeton">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.penjualan-mutubeton')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Pengiriman Beton">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.laporan-pengiriman-beton')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Produksi Beton Per Hari">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.laporan-produksi-beton-harian')">
                                Cetak
                        </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Produksi Customer">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.laporan-produksi-customer')">
                                Cetak
                        </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Rekap Ticket">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.rekap-ticket-tanggal')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Rekap Concrete Pump">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.rekap-concretepump')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                    </tbody>
                </table>
            </div>
        </div>
        <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300 mt-2">
            Gaji
        </h4>
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Laporan</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <x-datarowtable title="Laporan Gaji Driver">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.rekap-gaji-modal')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Gaji per Driver">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.rekap-gajiper-driver-modal')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="TT Driver">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.tt-driver')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                    </tbody>
                </table>
            </div>
        </div>
        <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300 mt-2">
            Finance
        </h4>
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Laporan</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <x-datarowtable title="Laporan Rekap Invoice">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.rekap-invoice')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Pengeluaran Biaya">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.rekap-pengeluaran-biaya')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Jurnal Pengeluaran Biaya">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.laporan-jurnal-pengeluaran-biaya')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Saldo Kas / Bank">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.laporan-saldo-rekening')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Rekap Saldo Kas/Bank">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.laporan-rekap-saldo-kasbank')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Rekap Piutang">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.laporan-piutang-all')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Rekap Piutang Karyawan">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.laporan-piutang-karyawan')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Rekap Hutang">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.laporan-hutang-all')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Rekap Biaya">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.laporan-rekap-biaya')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                    </tbody>
                </table>
            </div>
        </div>
        <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
            Accounting
        </h4>
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Laporan</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <x-datarowtable title="Laporan Rekap Uang Muka Pajak">
                                <x-print-button
                                    wire:click.prevent="$emit('openModal', 'laporan.laporan-uangmuka-pajak')">
                                    Cetak
                                </x-print-button>
                            </x-datarowtable>
                            <x-datarowtable title="Laporan Rekap Hutang Pajak">
                                <x-print-button
                                    wire:click.prevent="$emit('openModal', 'laporan.laporan-hutang-pajak')">
                                    Cetak
                                </x-print-button>
                            </x-datarowtable>
                        <x-datarowtable title="Laporan Jurnal Umum">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.jurnal-umum')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Jurnal per Tanggal">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.laporan-jurnal-tanggal')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Trial Balance">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.laporan-trial-balance')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Neraca">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.laporan-neraca')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Laba Rugi">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.laporan-laba-rugi')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                    </tbody>
                </table>
            </div>
        </div>    
    </x-container>
</div>

