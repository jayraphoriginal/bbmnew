<div class="w-full">
    <x-container title="Ticket Produksi">
        <x-button
            wire:click.prevent="$emit('openModal', 'produksi.ticket-produksi-modal')">
            Tambah Ticket
        </x-button>
        
        <livewire:produksi.ticket-produksi-table/>

    </x-container>
</div>