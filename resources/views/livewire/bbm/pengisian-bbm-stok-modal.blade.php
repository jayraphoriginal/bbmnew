<div>
    <x-header-modal>
        Input Pengisian Bbm Stok
    </x-header-modal>

    <x-form-group caption="Tanggal">
        <x-datepicker
            wire:model="pengisian.tgl_pengisian"
        />
        @error('pemakaian.tgl_pengisian')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>
    
  
    <x-form-group caption="Kendaraan">
        <livewire:kendaraan.kendaraan-select :deskripsi="$kendaraan"/>
        @error('pengisian.beban_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>
  

    <x-form-group caption="Barang">
        <livewire:barang.barang-select :deskripsi="$barang" />
        @error('pengisian.barang_id')
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

    <x-form-group caption="Keterangan">
        <x-textbox
            wire:model="pengisian.keterangan"
        />
        @error('pengisian.keterangan')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Tutup</x-secondary-button>
        <x-button
            wire:loading.attr="disabled"
            wire:click="save">
            Save
        </x-button>
    </x-footer-modal>
    
</div>