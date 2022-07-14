<div>
    <x-header-modal>
        Input Tambahan Bahan Bakar
    </x-header-modal>

    <x-form-group caption="Tanggal">
       <x-datepicker 
            wire:model="penambahan.tanggal_penambahan"
       />
        @error('penambahan.tanggal_penambahan')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Kendaraan">
        <livewire:kendaraan.kendaraan-select :deskripsi="$kendaraan"/>
        @error('penambahan.kendaraan_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Driver">
        <livewire:driver.driver-select :deskripsi="$driver"/>
        @error('penambahan.driver_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Bahan Bakar">
        <livewire:barang.bahan-bakar-select :deskripsi="$bahanbakar"/>
        @error('penambahan.bahan_bakar_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jumlah">
        <x-number-text
            wire:model="penambahan.jumlah"
        />
        @error('penambahan.jumlah')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Keterangan">
        <x-textbox
            wire:model="penambahan.keterangan"
        />
        @error('penambahan.keterangan')
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
