<div>
    <x-header-modal>
        Batal Ticket
    </x-header-modal>   

    <x-form-group caption="No Ticket">
        <livewire:batal.ticket-select :deskripsi="$detailticket"/>
        @error('ticket_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Kode Mutu">
        <x-textbox
            readonly
            wire:model="kode_mutu"
        />
    </x-form-group>

    <x-form-group caption="NoPol">
        <x-textbox
            readonly
            wire:model="nopol"
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
