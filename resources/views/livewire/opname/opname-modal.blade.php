<div>
    <x-header-modal>
        Input Stok Opname
    </x-header-modal>

    <x-form-group caption="Tanggal Opname">
        <x-datepicker
            wire:model="MOpname.tgl_opname"
        />
        @error('MOpname.tgl_opname')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Tipe">
        <x-combobox
            wire:model="MOpname.tipe"
        >
            <option value="">-- Isi Tipe --</option>
            <option value="Pengurangan">Pengurangan</option>
            <option value="Penambahan">Penambahan</option>
        </x-combobox>
        @error('MOpname.tipe')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Keterangan">
        <x-textbox
            wire:model="MOpname.keterangan"
        />
        @error('MOpname.keterangan')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-button
    class="mt-2"
    wire:click.prevent="$emit('openModal', 'opname.opname-detail-modal')"
    >Tambah Detail</x-button>


    <livewire:opname.opname-detail-table/>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Tutup</x-secondary-button>
        <x-button
            wire:click="save">
            Save
        </x-button>
    </x-footer-modal>
    
</div>
