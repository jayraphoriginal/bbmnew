<div>
    <x-header-modal>
        Input Pengurangan Bahan Bakar
    </x-header-modal>

    <x-form-group caption="Tanggal">
       <x-datepicker 
            wire:model="pengurangan.tanggal_pengurangan"
       />
        @error('pengurangan.tanggal_pengurangan')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Kendaraan">
        <livewire:kendaraan.kendaraan-select :deskripsi="$kendaraan"/>
        @error('pengurangan.kendaraan_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Driver">
        <livewire:driver.driver-select :deskripsi="$driver"/>
        @error('pengurangan.driver_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Bahan Bakar">
        <livewire:barang.bahan-bakar-select :deskripsi="$bahanbakar"/>
        @error('pengurangan.bahan_bakar_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jumlah">
        <x-number-text
            wire:model="pengurangan.jumlah"
        />
        @error('pengurangan.jumlah')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Keterangan">
        <x-textbox
            wire:model="pengurangan.keterangan"
        />
        @error('pengurangan.keterangan')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')">
            Cancel
        </x-secondary-button>
        <x-button
            wire:loading.attr="disabled"
            wire:click="save">
            Save
        </x-button>
    </x-footer-modal>
</div>
