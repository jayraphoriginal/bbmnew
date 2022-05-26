<div>
    <x-header-modal>
        Input Rate
    </x-header-modal>

    <x-form-group caption="Jarak Tempuh">
        <x-combobox
            wire:model="rate.jarak_tempuh_id"
        >
            <option value="">-- Isi Jarak Tempuh --</option>
            @foreach($jaraktempuh as $opt)
                <option value="{{$opt->id}}">{{$opt->awal.' - '.$opt->akhir}}</option>
            @endforeach
        </x-combobox>
        @error('rate.jarak_tempuh_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Lokasi Awal">
        <x-textbox
            wire:model="rate.lokasi_awal"
        />
        @error('rate.lokasi_awal')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Tujuan">
        <x-textbox
            wire:model="rate.tujuan"
        />
        @error('rate.tujuan')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Estimasi Jarak">
        <x-number-text
            wire:model="rate.estimasi_jarak"
        />
        @error('rate.estimasi_jarak')
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
