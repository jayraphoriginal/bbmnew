<div>
    <x-header-modal>
        Input Item Sewa
    </x-header-modal>

    <x-form-group caption="Nama Item">
        <x-textbox
            wire:model="itemsewa.nama_item"
        />
        @error('itemsewa.nama_item')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Tipe">
        <x-combobox
            wire:model="itemsewa.tipe"
        >
            <option value="">-- Isi Tipe --</option>
            <option value="Jam">Jam</option>
            <option value="HM">HM</option>
            <option value="None">None</option>
        </x-combobox>
        @error('itemsewa.nama_item')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Harga Intax">
        <x-number-text
            wire:model="itemsewa.harga_intax"
        />
        @error('itemsewa.harga_intax')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Satuan">
        <livewire:satuan.satuan-select :deskripsi="$satuan"/>
        @error('itemsewa.satuan_id')
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
