<div>
    <x-header-modal>
        Input Mutu Beton
    </x-header-modal>

    <x-form-group caption="Komponen">
         <x-textbox
            wire:model="perhitunganHpp.komponen"
        />
        @error('perhitunganHpp.komponen')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Kriteria">
        <x-textbox
            wire:model="perhitunganHpp.kriteria"
        />
        @error('perhitunganHpp.kriteria')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Perhitungan">
        <x-combobox
            wire:model="perhitunganHpp.perhitungan">
            <option value="">-- Pilih Perhitungan --</option>
            <option value="non">Non Stok</option>
            <option value="bbm">BBM</option>
            <option value="stok">Stok</option>
            <option value="jasa">Jasa</option>
        </x-combobox>
        @error('perhitunganHpp.perhitungan')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Barang">
        <livewire:barang.barang-select :deskripsi="$barang"/>
        @error('perhitunganHpp.barang_id')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jumlah">
        <x-number-text
            wire:model="perhitunganHpp.jumlah"/>
        @error('perhitunganHpp.jumlah')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

   <x-form-group caption="Biaya Non">
        <x-number-text
            wire:model="perhitunganHpp.biaya_non"/>
        @error('perhitunganHpp.biaya_non')
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
