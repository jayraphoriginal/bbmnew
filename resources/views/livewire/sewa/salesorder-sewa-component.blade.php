<div class="w-full">
    <x-container title="Sales Order Sewa">
        <x-button
            wire:click.prevent="$emit('openModal', 'sewa.salesorder-sewa-modal')">
            Tambah Sales Order Sewa
        </x-button>

        <livewire:sewa.salesorder-sewa-table/>

    </x-container>
</div>
