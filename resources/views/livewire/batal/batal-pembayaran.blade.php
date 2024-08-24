<div>
    <x-header-modal>
        Batal Pembayaran
    </x-header-modal>   

    <x-form-group caption="No Pembayaran / Keterangan">
        <livewire:batal.pembayaran-select :deskripsi="$detailpembayaran"/>
        @error('pembayaran_id')
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
