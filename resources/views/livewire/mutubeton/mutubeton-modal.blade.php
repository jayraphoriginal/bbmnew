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

    <x-form-group caption="Deskripsi">
        <x-textbox
            wire:model="mutubeton.deskripsi"
        />
        @error('mutubeton.deskripsi')
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

    <x-form-group caption="Status">
        <x-combobox
            wire:model="mutubeton.status">
            <option value="">-- Pilih Status --</option>
            <option value="aktif">Aktif</option>
            <option value="non aktif">Non Aktif</option>
        </x-combobox>
        @error('mutubeton.status')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Tanggal Berlaku">
        <x-datepicker
            wire:model="mutubeton.tgl_berlaku"
        />
        @error('mutubeton.tgl_berlaku')
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
