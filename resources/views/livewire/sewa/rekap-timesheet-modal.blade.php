<div class="w-full">
    <x-header-modal>
        Rekap Timesheet {{ $this->noso }}
    </x-header-modal>

    <x-button
        wire:click.prevent="$emit('openModal', 'sewa.timesheet-modal',{{ json_encode([
            'tipe' => $tipe,
            'd_so_id' => $d_salesorder_sewa_id
        ]) }})">
        Input Timesheet
    </x-button>

    <livewire:sewa.rekap-timesheet-table d_salesorder_sewa_id="{{ $d_salesorder_sewa_id }}"/>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >cancel</x-secondary-button>
    </x-footer-modal>

</div>
