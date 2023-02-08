<div>
    <x-header-modal>
        Batal Jurnal Manual
    </x-header-modal>   

    <x-form-group caption="Keterangan">
        <x-textbox
            readonly
            wire:model="keterangan"
        />
        @error('manual_journal_id')
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
