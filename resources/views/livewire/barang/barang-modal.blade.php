<div>
    <x-header-modal>
        Input Barang
    </x-header-modal>

    <x-form-group caption="Nama Barang">
        <x-textbox
            wire:model="barang.nama_barang"
        />
        @error('barang.nama_barang')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Kategori">
        <livewire:barang.kategori-select :deskripsi="$kategori"/>
        @error('barang.kategori_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Merk">
        <x-textbox
            wire:model="barang.merk"
        />
        @error('barang.merk')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Satuan">
        <livewire:satuan.satuan-select :deskripsi="$satuan"/>
        @error('barang.satuan_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Stok Minimum">
        <x-number-text
            wire:model="barang.stok_minimum"
        />
        @error('barang.stok_minimum')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Cancel</x-secondary-button>
        <x-button
            wire:click="save">Save</x-button>
    </x-footer-modal>
</div>
