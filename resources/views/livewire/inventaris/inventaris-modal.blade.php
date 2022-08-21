<div>
    <x-header-modal>
        Input Inventaris
    </x-header-modal>

    <x-form-group caption="Nama Inventaris">
        <x-textbox
            wire:model="inventaris.nama_inventaris"
        />
        @error('inventaris.nama_inventaris')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Golongan">
        <x-combobox
            wire:model="inventaris.golongan_id"
        >
            <option value=""> -- Pilih Golongan Inventaris --</option>
            @foreach($golongan as $item)
                <option value="{{ $item->id }}">{{ $item->kelompok.' - '.$item->masa_manfaat }}</option>
            @endforeach
        </x-combobox>
        
        @error('inventaris.golongan_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Tanggal Perolehan">
        <x-datepicker
            wire:model="inventaris.tgl_perolehan"
        />
        @error('inventaris.tgl_perolehan')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Harga Perolehan">
        <x-number-text
            wire:model="inventaris.harga_perolehan"
        />
        @error('inventaris.harga_perolehan')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Cancel</x-secondary-button>
        <x-button
            wire:click="save">Save</x-button>
    </x-footer-modal>
</div>
