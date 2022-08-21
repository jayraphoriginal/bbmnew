<div>
    <x-header-modal>
        Input Golongan
    </x-header-modal>

    <x-form-group caption="Kelompok">
        <x-textbox
            wire:model="golongan.kelompok"
        />
        @error('golongan.kelompok')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Masa Manfaat (Tahun)">
        <x-number-text
            wire:model="golongan.masa_manfaat"
        />
        @error('golongan.masa_manfaat')
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
