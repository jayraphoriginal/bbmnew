<div>
    <x-header-modal>
        Input Kategori
    </x-header-modal>

    <x-form-group caption="Kategori">
        <x-textbox
            wire:model="kategori.kategori"
        />
        @error('kategori.kategori')
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