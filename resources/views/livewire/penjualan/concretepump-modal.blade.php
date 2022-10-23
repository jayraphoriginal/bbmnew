<div>
    <x-header-modal>
        Input Concrete Pump
    </x-header-modal>

    <x-form-group caption="Kendaraan">
        <livewire:kendaraan.kendaraan-select :deskripsi="$kendaraan"/>
        @error('concretepump.kendaraan_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Driver">
        <livewire:driver.driver-select :deskripsi="$driver"/>
        @error('concretepump.driver_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jarak Tempuh">
        <x-combobox
            wire:model="concretepump.jarak_tempuh_id"
        >
            <option value="">-- Isi Jarak Tempuh --</option>
            @foreach($jaraktempuh as $opt)
                <option value="{{$opt->id}}">{{$opt->awal.' - '.$opt->akhir}}</option>
            @endforeach
        </x-combobox>
        @error('concretepump.jarak_tempuh_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Rate">
        <livewire:rate.rate-select :deskripsi="$rate"/>
        @error('concretepump.rate_id')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Harga Sewa">
        <x-number-text
            wire:model="concretepump.harga_sewa"
        />
        @error('concretepump.harga_sewa')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Keterangan">
        <x-textbox
            wire:model="concretepump.keterangan"
        />
        @error('concretepump.keterangan')
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
