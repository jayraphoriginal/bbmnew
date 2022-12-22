<div>
    <x-header-modal>
        Batal Invoice
    </x-header-modal>   

    <x-form-group caption="No Invoice / Customer ">
        <livewire:batal.invoice-select :deskripsi="$detailinvoice"/>
        @error('invoice_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Total">
        <x-number-text
            readonly
            wire:model="total"
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
