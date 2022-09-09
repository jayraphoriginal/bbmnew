<div>
    <x-header-modal>
        Input Timesheet
    </x-header-modal>

    <x-form-group caption="Tanggal">
        <x-datepicker
            wire:model="timesheet.tanggal"
        />
        @error('timesheet.tanggal')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Driver">
        <livewire:driver.driver-select :deskripsi="$driver"/>
        @error('timesheet.driver_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    @if($timesheet->tipe == 'include mixer' || $timesheet->tipe == 'Jam')
    <x-form-group caption="Jam Awal">
        <x-datetime-picker
            wire:model="timesheet.jam_awal"
        />
        @error('timesheet.jam_awal')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jam Akhir">
        <x-datetime-picker
            wire:model="timesheet.jam_akhir"
        />
        @error('timesheet.jam_akhir')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>
    @else

        <x-form-group caption="HM Awal">
            <x-number-text
                wire:model="timesheet.hm_awal"
            />
            @error('timesheet.hm_awal')
                <x-error-form>{{ $message }}</x-error-form>
            @enderror
        </x-form-group>

        <x-form-group caption="HM Akhir">
            <x-number-text
                wire:model="timesheet.hm_akhir"
            />
            @error('timesheet.hm_akhir')
                <x-error-form>{{ $message }}</x-error-form>
            @enderror
        </x-form-group>
    
    @endif

    <x-form-group caption="Istirahat">
        <x-number-text
            wire:model="timesheet.istirahat"
        />
        @error('timesheet.istirahat')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Volume">
        <x-number-text
            wire:model="timesheet.volume"
        />
        @error('timesheet.volume')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Keterangan">
        <x-textbox
            wire:model="timesheet.keterangan"
        />
        @error('timesheet.keterangan')
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
