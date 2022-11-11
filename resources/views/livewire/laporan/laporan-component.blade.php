<div class="w-full">
    <x-container title="Laporan">
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
                        <x-datarowtable title="Laporan Penjualan per Mutubeton">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.penjualan-mutubeton')">
                                Cetak
                            </x-print-button>
                        </x-datarowtable>
                        <x-datarowtable title="Laporan Rekap Ticket">
                            <x-print-button
                                wire:click.prevent="$emit('openModal', 'laporan.rekap-ticket-tanggal')">
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
                    </tbody>
                </table>
            </div>
        </div>
    </x-container>
</div>

