<div>
    <x-header-modal>
        Batal Pengisian BBM Stok
    </x-header-modal>   

    <x-form-group caption="Pengisian BBM Stok">
        <livewire:batal.pengisian-bbm-stok-select :deskripsi="$keterangan"/>
        @error('pengisian_bbm_stok_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Cancel</x-secondary-button>
        <x-button
            wire:click="save">Submit</x-button>
    </x-footer-modal>
</div>
