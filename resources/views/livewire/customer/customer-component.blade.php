<div class="w-full">
    <x-container title="Customer">
        <x-button
            wire:click.prevent="$emit('openModal', 'customer.customer-modal')">
            Tambah Customer
        </x-button>

        <livewire:customer.customer-table/>

    </x-container>
</div>
