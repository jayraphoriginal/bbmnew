<div>
    <x-header-modal>
        Input Bank
    </x-header-modal>

    <x-form-group caption="Kode Bank">
        <x-textbox
            wire:model="bank.kode_bank"
        />
        @error('bank.kode_bank')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Nama Bank">
        <x-textbox
            wire:model="bank.nama_bank"
        />
        @error('bank.nama_bank')
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
