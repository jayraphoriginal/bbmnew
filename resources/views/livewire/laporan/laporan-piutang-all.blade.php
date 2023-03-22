<div>
    <x-header-modal>
       Laporan Saldo Piutang
    </x-header-modal>

    <x-form-group caption="Per Tanggal">
        <x-datepicker
            wire:model="tanggal"
        />
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Cancel</x-secondary-button>
        <x-link-button
            href="/laporanpiutangall/{{$tanggal}}" target="__blank"
            >Print</x-link-button>
    </x-footer-modal>
</div>