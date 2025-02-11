<div>
    <x-header-modal>
       Laporan Trial Balance
    </x-header-modal>

    <x-form-group caption="Tahun">
        <x-combobox wire:model="tahun">
            <option value="">-- Tahun --</option>
            @for($i=2022;$i<=date("Y")+1;$i++)
            <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </x-combobox>
    </x-form-group>
    
    <x-form-group caption="Bulan">
        <x-combobox wire:model="bulan">
            <option value="">-- Bulan --</option>
            @for($x=1;$x<=12;$x++)
            <option value="{{ $x }}">{{ $x }}</option>
            @endfor
        </x-combobox>
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Cancel</x-secondary-button>
        <x-link-button
            href="/laporantrialbalance/{{$tahun}}/{{$bulan}}" target="__blank"
            >Print</x-link-button>
        <x-link-button-export
            href="/exporttrialbalance/{{$tahun}}/{{$bulan}}" target="__blank"
            >Export</x-link-button-export>
    </x-footer-modal>
</div>