<div>
    <x-header-modal>
        Input Komposisi {{ $kode_mutu }}
    </x-header-modal>

    <x-form-group caption="Barang">
        <livewire:barang.barang-select :deskripsi="$barang" />
        @error('komposisi.barang_id')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jumlah">
        <x-textbox
            wire:model="komposisi.jumlah"/>
        @error('komposisi.jumlah')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jumlah">
        <x-combobox
            wire:model="komposisi.tipe">
            <option>-- Pilih Tipe --</option>
            <option value="mengurangi stok">Mengurangi stok</option>
            <option value="tidak mengurangi stok">Tidak mengurangi stok</option>
        </x-combobox>
        @error('komposisi.tipe')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Satuan">
        <x-textbox
            readonly
            wire:model="satuan"
        />
        @error('komposisi.satuan_id')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')">
            Tutup
        </x-secondary-button>
        <x-button
            class="mt-3"
            wire:click="save">
            Save
        </x-button>
    </x-footer-modal>
</div>
