<div class="w-full">
    <x-container title="Purchase Order">
        <x-button
            wire:click.prevent="$emit('openModal', 'pembelian.purchaseorder-modal')">
            Tambah Purchase Order
        </x-button>

        <livewire:pembelian.purchaseorder-table/>

    </x-container>
</div>
