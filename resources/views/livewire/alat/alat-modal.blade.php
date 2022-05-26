<div>
    <x-header-modal>
        Input Alat
    </x-header-modal>

    <x-form-group caption="Alat">
        <x-textbox
            wire:model="alat.nama_alat"
        />
        @error('alat.nama_alat')
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
