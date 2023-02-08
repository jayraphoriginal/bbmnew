<div>
    <x-header-modal>
       Laporan Rekap Invoice
    </x-header-modal>

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

    <x-form-group caption="Tanggal Akhir">
        <x-combobox
            wire:model="tipe"
        >
            <option value="">-- Isi Tipe --</option>
            <option value="reg">Regular</option>
            <option value="retail">Retail</option>
        </x-combobox>
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Cancel</x-secondary-button>
        @if ($tipe == 'retail')
            <x-link-button
            href="/rekapinvoiceretail/{{$tgl_awal}}/{{$tgl_akhir}}" target="__blank"
            >Print</x-link-button>
        @else
            <x-link-button
            href="/rekapinvoice/{{$tgl_awal}}/{{$tgl_akhir}}" target="__blank"
            >Print</x-link-button>
        @endif
        @if ($tipe == 'retail')
            <x-link-button-export
            href="/exportrekapinvoiceretail/{{$tgl_awal}}/{{$tgl_akhir}}" target="__blank"
            >Export</x-link-button-export>
        @else
            <x-link-button-export
            href="/exportrekapinvoice/{{$tgl_awal}}/{{$tgl_akhir}}" target="__blank"
            >Export</x-link-button-export>
        @endif
    </x-footer-modal>
</div>