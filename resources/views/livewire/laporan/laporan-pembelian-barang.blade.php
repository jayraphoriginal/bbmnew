<div>
    <x-header-modal>
        Laporan Pembelian Supplier
    </x-header-modal>

     <x-form-group caption="Barang">
        <livewire:barang.barang-select :deskripsi="$barang" />
        @error('barang_id')
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
            href="/laporanpembelianbarang/{{$tgl_awal}}/{{$tgl_akhir}}/{{$barang_id}}" target="__blank"
            >Print</x-link-button>
        <x-link-button
            href="/exportpembelianbarang/{{$tgl_awal}}/{{$tgl_akhir}}/{{$barang_id}}" target="__blank"
            >Export</x-link-button>
    </x-footer-modal>
</div>