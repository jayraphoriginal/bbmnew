<div class="w-full">
    <x-container title="Penjualan Barang">
        <x-button
            wire:click.prevent="$emit('openModal', 'penjualan.penjualan-modal')">
            Tambah Penjualan
        </x-button>

        <livewire:penjualan.penjualan-table/>

    </x-container>
</div>