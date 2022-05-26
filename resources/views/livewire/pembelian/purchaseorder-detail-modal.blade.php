<div>
    <x-header-modal>
        Input Detail PO
    </x-header-modal>

    <x-form-group caption="Item">
        <livewire:barang.barang-select :deskripsi="$barang" />
        @error('DPurchaseorder.barang_id')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jumlah">
        <x-number-text
            wire:model="DPurchaseorder.jumlah"/>
        @error('DPurchaseorder.jumlah')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Satuan">
        <x-textbox
            readonly
            wire:model="satuan"
        />
        @error('DPurchaseorder.satuan_id')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Harga Intax">
        <x-number-text
            wire:model="DPurchaseorder.harga"
        />
        @error('DPurchaseorder.harga')
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
