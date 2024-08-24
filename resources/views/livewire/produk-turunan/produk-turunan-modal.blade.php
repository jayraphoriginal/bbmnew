<div>
    <x-header-modal>
        Input Produk Turunan
    </x-header-modal>

    <x-form-group caption="Barang">
        <livewire:barang.barang-select :deskripsi="$barang" />
        @error('produkturunan.barang_id')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Deskripsi">
        <x-textbox
            wire:model="produkturunan.deskripsi"
        />
        @error('produkturunan.deskripsi')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jumlah">
        <x-number-text
            wire:model="produkturunan.jumlah"/>
        @error('produkturunan.jumlah')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Satuan">
        <x-textbox
            readonly
            wire:model="satuan"
        />
    </x-form-group>

    <x-form-group caption="Status">
        <x-combobox
            wire:model="produkturunan.status">
            <option value="">-- Pilih Status --</option>
            <option value="aktif">Aktif</option>
            <option value="non aktif">Non Aktif</option>
        </x-combobox>
        @error('produkturunan.status')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Tanggal Berlaku">
        <x-datepicker
            wire:model="produkturunan.tgl_berlaku"
        />
        @error('produkturunan.tgl_berlaku')
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
