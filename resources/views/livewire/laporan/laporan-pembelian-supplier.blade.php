<div>
    <x-header-modal>
        Laporan Pembelian Supplier
    </x-header-modal>

    <x-form-group caption="Supplier">
        <livewire:supplier.supplier-select :deskripsi="$supplier"/>
        @error('id_supplier')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

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
            href="/laporanpembeliansupplier/{{$tgl_awal}}/{{$tgl_akhir}}/{{$id_supplier}}" target="__blank"
            >Print</x-link-button>
    </x-footer-modal>
</div>
