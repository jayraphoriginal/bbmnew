<div>
    <x-header-modal>
        Input Pengisian Bahan Bakar
    </x-header-modal>

    <x-form-group caption="Tanggal Pengisian">
       <x-datepicker 
            wire:model="pengisian.tanggal_pengisian"
       />
        @error('pengisian.tanggal_pengisian')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Supplier">
        <livewire:supplier.supplier-select :deskripsi="$supplier"/>
        @error('pengisian.supplier_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Kendaraan">
        <livewire:kendaraan.kendaraan-select :deskripsi="$kendaraan"/>
        @error('pengisian.kendaraan_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Driver">
        <livewire:driver.driver-select :deskripsi="$driver"/>
        @error('pengisian.driver_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Bahan Bakar">
        <livewire:barang.bahan-bakar-select :deskripsi="$bahanbakar"/>
        @error('pengisian.bahan_bakar_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jumlah">
        <x-number-text
            wire:model="pengisian.jumlah"
        />
        @error('pengisian.jumlah')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Harga">
        <x-number-text
            wire:model="pengisian.harga"
        />
        @error('pengisian.harga')
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
