<div>
    <x-header-modal>
        Closing (Tutup Buku)
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
        <x-button
            wire:click="save">Save</x-button>
    </x-footer-modal>

</div>
