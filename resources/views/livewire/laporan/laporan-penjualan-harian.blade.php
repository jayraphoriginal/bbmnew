<div>
    <x-header-modal>
       Laporan Penjualan Beton Harian
    </x-header-modal>

    <x-form-group caption="Tanggal">
        <x-datepicker
            wire:model="tgl"
        />
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Cancel</x-secondary-button>
        <x-link-button
            href="/laporanpenjualanbetonharian/{{$tgl}}" target="__blank"
            >Print</x-link-button>
    </x-footer-modal>
</div>
