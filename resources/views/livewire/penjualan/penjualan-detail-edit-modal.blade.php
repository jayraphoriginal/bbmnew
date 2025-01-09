<div>
    <x-header-modal>
        Input Detail Penjualan  {{ $dpenjualan->m_penjualan_id }}
    </x-header-modal>

   
    <x-form-group caption="Barang">
        <livewire:barang.barang-select :deskripsi="$barang" />
        @error('dpenjualan.barang_id')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jumlah">
        <x-number-text
            wire:model="dpenjualan.jumlah"/>
        @error('dpenjualan.jumlah')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Harga Intax">
        <x-number-text
            wire:model="dpenjualan.harga_intax"/>
        @error('dpenjualan.harga_intax')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Satuan">
        <x-textbox
            readonly
            wire:model="satuan"
        />
        @error('dpenjualan.satuan_id')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')">
            Cancel
        </x-secondary-button>
        <x-button
            wire:loading.attr="disabled"
            wire:click="save">
            Save
        </x-button>
    </x-footer-modal>
</div>

