<div>
    <x-header-modal>
       Laporan Neraca
    </x-header-modal>

    <x-form-group caption="Tanggal">
        <x-datepicker
            wire:model="tanggal"
        />
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Cancel</x-secondary-button>
        <x-link-button
            href="/laporanneraca/{{$tanggal}}" target="__blank"
            >Print</x-link-button>

        <x-link-button-export
            href="/exportneraca/{{$tanggal}}" target="__blank"
            >Export</x-link-button-export>
    </x-footer-modal>
</div>
