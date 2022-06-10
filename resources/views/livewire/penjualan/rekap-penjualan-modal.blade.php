<div class="w-full">
    <x-header-modal>
        Rekap Penjualan {{ $this->noso }}
    </x-header-modal>

    <x-button
        wire:click.prevent="$emit('openModal', 'penjualan.penjualan-retail-modal',{{ json_encode(['m_salesorder_id' => $m_salesorder_id]) }})">
        Tambah Barang
    </x-button>

    <livewire:penjualan.penjualan-retail-table m_salesorder_id="{{ $m_salesorder_id }}"/>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >cancel</x-secondary-button>
    </x-footer-modal>

</div>
