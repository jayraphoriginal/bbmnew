<div>
    <x-header-modal>
        Batal Pengeluaran Biaya
    </x-header-modal>   

    <x-form-group caption="Pengeluaran Biaya">
        <livewire:batal.pengeluaran-biaya-select :deskripsi="$keterangan"/>
        @error('pengeluaran_biaya_id')
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
