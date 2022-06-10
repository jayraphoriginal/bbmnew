<div>
    <x-header-modal>
        Input Detail Penjualan
    </x-header-modal>

    <x-form-group caption="Item">
        <livewire:barang.barang-select :deskripsi="$barang" />
        @error('penjualanretail.barang_id')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jumlah">
        <x-number-text
            wire:model="penjualanretail.jumlah"/>
        @error('penjualanretail.jumlah')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Satuan">
        <x-textbox
            readonly
            wire:model="satuan"
        />
        @error('penjualanretail.satuan_id')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Harga">
        <x-number-text
            wire:model="penjualanretail.harga"
        />
        @error('penjualanretail.harga')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')">
            Cancel
        </x-secondary-button>
        <x-button
            wire:click="save">
            Save
        </x-button>
    </x-footer-modal>
</div>
