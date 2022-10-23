<div>
    <x-header-modal>
        Input Pajak
    </x-header-modal>

    <x-form-group caption="Pajak">
        <x-textbox
            wire:model="mpajak.jenis_pajak"
        />
        @error('mpajak.jenis_pajak')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Persen Pajak">
        <x-textbox
            wire:model="mpajak.persen"
        />
        @error('mpajak.persen')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jenis Pajak">
        <x-combobox
            wire:model="tipe"
        >
            <option value="">-- Isi Jenis Pajak --</option>
            <option value="PPN">PPN</option>
            <option value="PPH">PPH</option>
        </x-combobox>
        @error('tipe')
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
