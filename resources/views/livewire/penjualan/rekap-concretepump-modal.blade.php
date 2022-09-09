<div class="w-full">
    <x-header-modal>
        Rekap Concrete Pump {{ $this->noso }}
    </x-header-modal>

    <x-button
        wire:click.prevent="$emit('openModal', 'penjualan.concretepump-modal',{{ json_encode(['m_salesorder_id' => $m_salesorder_id]) }})">
        Tambah Concrete Pump
    </x-button>

    <x-link-button
        href="rekapconcretepump/{{ $m_salesorder_id }}">
        Rekap Concrete Pump
    </x-link-button>

    <livewire:penjualan.rekap-concretepump-table m_salesorder_id="{{ $m_salesorder_id }}"/>

</div>
