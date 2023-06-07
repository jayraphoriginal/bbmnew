<div>
    <x-header-modal>
        Input Pencairan Warkat
    </x-header-modal>

    <x-form-group caption="Tanggal Pencairan">
        <x-datepicker
            wire:model="tgl_cair"
        />
        @error('tgl_cair')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Tanggal Jatuh Tempo">
        <x-datepicker
            readonly
            wire:model="jatuh_tempo"
        />
    </x-form-group>

    <x-form-group caption="No Cheque / Giro">
        <x-textbox
            readonly
            wire:model="nowarkat"
        />
        @error('nowarkat')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Nama Supplier">
        <x-textbox
            readonly
            wire:model="nama_supplier"
        />
        @error('nama_supplier')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Rekening">
        <x-combobox
            wire:model="rekening_id"
        >
            <option value="">-- Isi Rekening --</option>
            @foreach ($rekening as $item)
                <option value="{{ $item->id }}">{{ $item->kode_bank.' - '.$item->norek }}</option>
            @endforeach
        </x-combobox>
        @error('rekening_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jumlah">
        <x-number-text
            readonly
            wire:model="jumlah"
        />
        @error('jumlah')
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
