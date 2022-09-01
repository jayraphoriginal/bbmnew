<div class="w-full">
    <x-container title="Jurnal Manual">
        <x-button
            wire:click.prevent="$emit('openModal', 'jurnal.jurnal-manual-modal')">
            Tambah Jurnal
        </x-button>

        <livewire:jurnal.jurnal-manual-table/>

    </x-container>
</div>
