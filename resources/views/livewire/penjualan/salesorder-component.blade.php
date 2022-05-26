<div class="w-full">
    <x-container title="Sales Order">
        <x-button
            wire:click.prevent="$emit('openModal', 'penjualan.salesorder-modal')">
            Tambah Sales Order
        </x-button>

        <livewire:penjualan.salesorder-table/>

    </x-container>
</div>
