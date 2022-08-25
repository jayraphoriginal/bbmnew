<div class="w-full">
    <x-container title="PO Customer">
        <x-button
            wire:click.prevent="$emit('openModal', 'penjualan.salesorder-modal')">
            Tambah PO Customer
        </x-button>

        <livewire:penjualan.salesorder-table/>

    </x-container>
</div>
