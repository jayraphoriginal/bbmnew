<div class="w-full">
    <x-header-modal>
        Rekap Ticket {{ $this->noso }}
    </x-header-modal>

    <x-button
        wire:click.prevent="$emit('openModal', 'penjualan.ticket-modal',{{ json_encode(['m_salesorder_id' => $m_salesorder_id, 'mutubeton_id' => $mutubeton_id]) }})">
        Tambah Ticket
    </x-button>

    <livewire:penjualan.ticket-table m_salesorder_id="{{ $m_salesorder_id }}"/>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >cancel</x-secondary-button>
    </x-footer-modal>

</div>
