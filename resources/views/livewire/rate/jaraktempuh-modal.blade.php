<div>
    <x-header-modal>
        Input Jarak Tempuh
    </x-header-modal>

    <x-form-group caption="Awal">
        <x-number-text
            wire:model="jarakTempuh.awal"
        />
        @error('jaraktempuh.awal')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Akhir">
        <x-number-text
            wire:model="jarakTempuh.akhir"
        />
        @error('jaraktempuh.akhir')
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
