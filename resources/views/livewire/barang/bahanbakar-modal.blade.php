<div>
    <x-header-modal>
        Input Bahan Bakar
    </x-header-modal>

    <x-form-group caption="Bahan Bakar">
        <x-textbox
            wire:model="bahanBakar.bahan_bakar"
        />
        @error('bahanBakar.bahan_bakar')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Harga Beli">
        <x-number-text
            wire:model="bahanBakar.harga_beli"
        />
        @error('bahanBakar.harga_beli')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Harga Claim">
        <x-number-text
            wire:model="bahanBakar.harga_claim"
        />
        @error('bahanBakar.harga_claim')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Satuan">
        <livewire:satuan.satuan-select :deskripsi="$satuan"/>
        @error('bahanBakar.satuan_id')
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
