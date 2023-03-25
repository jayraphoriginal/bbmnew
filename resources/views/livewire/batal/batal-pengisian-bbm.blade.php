<div>
    <x-header-modal>
        Batal Pengisian BBM
    </x-header-modal>   

    <x-form-group caption="Supplier">
        <x-textbox
            readonly
            wire:model="nama_supplier"
        />
    </x-form-group>

    <x-form-group caption="NoPol">
        <x-textbox
            readonly
            wire:model="nopol"
        />
    </x-form-group>

    <x-form-group caption="Nama Driver">
        <x-textbox
            readonly
            wire:model="nama_driver"
        />
    </x-form-group>


    <x-form-group caption="Jumlah">
        <x-number-text
            readonly
            wire:model="jumlah"
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
