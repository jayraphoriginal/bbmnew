<div>
    <x-header-modal>
        Input Jurnal Manual
    </x-header-modal>

    <x-form-group caption="COA Debet">
        <x-combobox
            wire:model="jurnalmanual.coa_id_debet"
        >
            <option value="">-- Isi COA Debet --</option>
            @foreach ($coa as $item)
                <option value="{{ $item->id }}">{{ $item->kode_akun.' - '.$item->nama_akun }}</option>
            @endforeach
        </x-combobox>
        @error('mutubeton.kode_mutu')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="COA Kredit">
        <x-combobox
            wire:model="jurnalmanual.coa_id_kredit"
        >
            <option value="">-- Isi COA Kredit --</option>
            @foreach ($coa as $item)
                <option value="{{ $item->id }}">{{ $item->kode_akun.' - '.$item->nama_akun }}</option>
            @endforeach
        </x-combobox>
        @error('jurnalmanual.coa_id_kredit')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jumlah">
        <x-number-text
            wire:model="jurnalmanual.jumlah"/>
        @error('jurnalmanual.jumlah')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Keterangan">
        <x-textbox
            wire:model="jurnalmanual.keterangan"/>
        @error('jurnalmanual.keterangan')
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
