<div class="w-full">
    <x-container title="Invoice">
        <x-button
            wire:click.prevent="$emit('openModal', 'invoice.so-modal')">
            Buat Invoice
        </x-button>

        <livewire:invoice.invoice-table/>

    </x-container>
</div>
