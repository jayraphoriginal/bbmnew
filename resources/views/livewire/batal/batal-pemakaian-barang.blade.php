<div>
    <x-header-modal>
        Batal Pemakaian Barang
    </x-header-modal>

    <x-form-group caption="ID">
        <x-combobox
            wire:model="pemakaian_barang_id"
            wire:change="selectPemakaianBarang"
            >
            <option value="">-- Select ID --</option>
            @foreach($pemakaianbarang as $data)
            <option value="{{ $data->id }}">{{$data->id}}</option>
            @endforeach
        </x-combobox>
    </x-form-group>

    <x-form-group caption="Tanggal">
        <x-datepicker
            readonly
            wire:model="tanggal"
        />
        @error('tanggal')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Alken">
        <x-textbox
            readonly
            wire:model="alken"
        />
        @error('alken')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Barang">
        <x-textbox
            readonly
            wire:model="nama_barang"
        />
        @error('nama_barang')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Keterangan">
        <x-textbox
            readonly
            wire:model="keterangan"
        />
        @error('keterangan')
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