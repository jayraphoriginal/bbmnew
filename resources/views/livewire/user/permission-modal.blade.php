<div>
    <x-header-modal>
        Input Permission
    </x-header-modal>

    <x-form-group caption="Nama">
        <x-textbox
            wire:model="name"
        />
        @error('name')
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
