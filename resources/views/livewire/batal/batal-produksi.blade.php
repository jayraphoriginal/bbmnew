<div>
    <x-header-modal>
        Batal Produksi
    </x-header-modal>   

    <x-form-group caption="No Produksi / Keterangan">
        <livewire:batal.produksi-select :deskripsi="$detailproduksi"/>
        @error('stokopname_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Nama Barang">
        <x-textbox
            readonly
            wire:model="nama_barang"
        />
    </x-form-group>

    <x-form-group caption="Jumlah">
        <x-number-text
            readonly
            wire:model="jumlah"
        />
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Cancel</x-secondary-button>
        <x-button
            wire:click="save">Submit</x-button>
    </x-footer-modal>
</div>
