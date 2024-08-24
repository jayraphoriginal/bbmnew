<div>
    <x-header-modal>
        Batal Surat Jalan
    </x-header-modal>   

    <x-form-group caption="No Surat Jalan / Customer">
        <livewire:batal.suratjalan-select :deskripsi="$detailsj"/>
        @error('suratjalan_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="NoPol">
        <x-textbox
            readonly
            wire:model="nopol"
        />
    </x-form-group>

    <x-form-group caption="Driver">
        <x-textbox
            readonly
            wire:model="driver"
        />
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Cancel</x-secondary-button>
        <x-button
            wire:click="save">Submit</x-button>
    </x-footer-modal>
</div>
