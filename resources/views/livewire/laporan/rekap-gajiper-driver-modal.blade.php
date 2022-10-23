<div>
    <x-header-modal>
        Laporan Gaji per Driver
    </x-header-modal>

    <x-form-group caption="Driver">
        <livewire:driver.driver-select :deskripsi="$driver"/>
        @error('driver_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Tanggal Awal">
        <x-datepicker
            wire:model="tgl_awal"
        />
    </x-form-group>

    <x-form-group caption="Tanggal Akhir">
        <x-datepicker
            wire:model="tgl_akhir"
        />
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Cancel</x-secondary-button>
        <x-link-button
            href="/laporanrekapgajidriver/{{$tgl_awal}}/{{$tgl_akhir}}/{{$driver_id}}" target="__blank"
            >Print</x-link-button>
    </x-footer-modal>
</div>
