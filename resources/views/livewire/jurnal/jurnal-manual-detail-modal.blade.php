<div>
    <x-header-modal>
        Input Detail Jurnal
    </x-header-modal>

    <x-form-group caption="COA">
        <livewire:coa.coa-select :deskripsi="$coa" />
        @error('tmp.coa_id')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="COA">
        <x-combobox wire:model="tipe">
            <option value="">-- Input Tipe --</option>
            <option value="debet">Debet</option>
            <option value="kredit">Kredit</option>
        </x-combobox>
        @error('tipe')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jumlah">
        <x-number-text
            wire:model="jumlah"/>
        @error('jumlah')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')">
            Cancel
        </x-secondary-button>
        <x-button
            wire:click="save">
            Save
        </x-button>
    </x-footer-modal>
</div>
