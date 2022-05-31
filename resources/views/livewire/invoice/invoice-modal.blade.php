<div>
    <x-header-modal>
        Input Invoice SO {{ $noso }}
    </x-header-modal>

    <x-form-group caption="Customer">
        <x-textbox
            readonly
            wire:model="customer"
        />
    </x-form-group>

    <x-form-group caption="Dari Tanggal">
        <x-datepicker
            wire:model="tgl_awal"
        />
    </x-form-group>

    <x-form-group caption="Sampai Tanggal">
        <x-datepicker
            wire:model="tgl_akhir"
        />
    </x-form-group>

    <x-form-group caption="Nilai Tagihan">
        <x-textbox
            readonly
            wire:model="jumlah_total"
        />
    </x-form-group>

    @if($dp == "DP")
    <x-form-group caption="Jumlah Invoice DP">
        <x-number-text
            wire:model="invoice.jumlah"
        />
    </x-form-group>
    @endif

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Cancel</x-secondary-button>
        <x-button
            wire:click="save">Save</x-button>
    </x-footer-modal>

</div>
