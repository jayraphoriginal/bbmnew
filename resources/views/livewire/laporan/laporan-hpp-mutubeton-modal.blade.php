<div>
    <x-header-modal>
       Laporan Hpp Mutu Beton
    </x-header-modal>

    <x-form-group caption="Tanggal Berlaku">
        <x-datepicker
            wire:model="tgl_berlaku"
        />
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Cancel</x-secondary-button>
        <x-link-button
        href="/laporanhppmutubeton/{{$tgl_berlaku}}" target="__blank"
        >Print</x-link-button>
       
    </x-footer-modal>
</div>
