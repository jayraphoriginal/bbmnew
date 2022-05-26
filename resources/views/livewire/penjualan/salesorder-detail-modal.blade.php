<div>
    <x-header-modal>
        Input Detail SO
    </x-header-modal>

    <x-form-group caption="Jarak Tempuh">
        <x-combobox
            wire:model="DSalesorder.jarak_tempuh_id"
        >
            <option value="">-- Isi Jarak Tempuh --</option>
            @foreach($jaraktempuh as $opt)
                <option value="{{$opt->id}}">{{$opt->awal.' - '.$opt->akhir}}</option>
            @endforeach
        </x-combobox>
        @error('DSalesorder.jarak_tempuh_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Rate">
        <livewire:rate.rate-select :deskripsi="$rate"/>
        @error('DSalesorder.rate_id')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Kode Mutu">
        <livewire:mutubeton.mutubeton-select :deskripsi="$mutubeton" />
        @error('DSalesorder.mutubeton_id')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Harga Intax">
        <x-number-text
            wire:model="DSalesorder.harga_intax"
        />
        @error('DSalesorder.harga_intax')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jumlah">
        <x-number-text
            wire:model="DSalesorder.jumlah"/>
        @error('DSalesorder.jumlah')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Satuan">
        <x-textbox
            readonly
            wire:model="satuan"
        />
        @error('DSalesorder.satuan_id')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Tanggal Awal">
        <x-datepicker
            wire:model="DSalesorder.tgl_awal"
        />
        @error('DSalesorder.tgl_awal')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Tanggal Akhir">
        <x-datepicker
            wire:model="DSalesorder.tgl_akhir"
        />
        @error('DSalesorder.tgl_akhir')
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
