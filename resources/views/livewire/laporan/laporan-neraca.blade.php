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
    </x-footer-modal>
</div>
