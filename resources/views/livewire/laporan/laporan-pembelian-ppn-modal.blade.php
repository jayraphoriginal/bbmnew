<div>
    <x-header-modal>
       Laporan Pembelian PPN
    </x-header-modal>

    <x-form-group caption="Tanggal Awal">
        <x-datepicker
            wire:model="tgl_awal"
        />
    </x-form-group>

    <x-form-group caption="Tanggal Akhir">
        <x-datepicker
            wire:model="tgl_akhir"
        />
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Cancel</x-secondary-button>
        <x-link-button
            href="/laporanpembelianppn/{{$tgl_awal}}/{{$tgl_akhir}}" target="__blank"
            >Print</x-link-button>
    </x-footer-modal>
</div>
