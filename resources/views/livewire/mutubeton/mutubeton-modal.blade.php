<div>
    <x-header-modal>
        Input Mutu Beton
    </x-header-modal>

    <x-form-group caption="Kode Mutu">
        <x-textbox
            wire:model="mutubeton.kode_mutu"
        />
        @error('mutubeton.kode_mutu')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jumlah">
        <x-number-text
            wire:model="mutubeton.jumlah"/>
        @error('mutubeton.jumlah')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Satuan">
        <livewire:satuan.satuan-select :deskripsi="$satuan"/>
        @error('mutubeton.satuan_id')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Berat Jenis">
        <x-textbox
            wire:model="mutubeton.berat_jenis"
        />
        @error('mutubeton.berat_jenis')
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
