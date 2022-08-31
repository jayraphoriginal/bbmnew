<div class="w-full">
    <x-container title="Jurnal Manual">
        <x-button
            wire:click.prevent="$emit('openModal', 'jurnal.jurnal-manual-modal')">
            Tambah Jurnal
        </x-button>

        <livewire:jurnal.purchaseorder-table/>

    </x-container>
</div>
