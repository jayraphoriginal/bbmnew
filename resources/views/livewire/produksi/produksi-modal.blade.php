<div>
    <x-header-modal>
        Input Produksi
    </x-header-modal>

    <x-form-group caption="Barang Jadi">
        <livewire:barang.barang-select :deskripsi="$barang" />
        @error('produksi.barang_id')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jumlah">
        <x-number-text
            wire:model="produksi.jumlah"/>
        @error('produksi.jumlah')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Satuan">
        <x-textbox
            readonly
            wire:model="satuan"
        />
        @error('produksi.satuan_id')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Biaya">
        <x-number-text
            wire:model="produksi.biaya"
        />
        @error('produksi.biaya')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Driver">
        <livewire:driver.driver-select :deskripsi="$driver" />
        @error('produksi.driver_id')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Keterangan">
        <x-textbox
            wire:model="produksi.keterangan"
        />
        @error('produksi.keterangan')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-button
        class="mt-2"
        wire:click.prevent="$emit('openModal', 'penjualan.penjualan-detail-modal')">
        Tambah Detail
    </x-button>

    @if($view_mode=='view')
        <livewire:produksi.produksi-detail-table produksi_id={{$produksi_id}}/>  
    @else
        <livewire:produksi.tmp-produksi-table/>      
    @endif

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Cancel</x-secondary-button>
        <x-button
            wire:click="save">
            Save
         </x-button>
    </x-footer-modal>
</div>
