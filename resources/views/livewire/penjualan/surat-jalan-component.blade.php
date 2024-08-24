<div class="w-full">
    <x-header-modal>
        Rekap Surat Jalan {{ $mpenjualan->nopenjualan }}
    </x-header-modal>

    <x-button
        wire:click.prevent="$emit('openModal', 'penjualan.surat-jalan-modal',{{ json_encode(['m_penjualan_id' => $m_penjualan_id]) }})">
        Tambah Surat Jalan
    </x-button>

    <livewire:penjualan.surat-jalan-table m_penjualan_id="{{ $m_penjualan_id }}"/>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >cancel</x-secondary-button>
    </x-footer-modal>

</div>
