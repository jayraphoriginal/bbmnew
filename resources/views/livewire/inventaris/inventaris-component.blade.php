<div class="w-full">
    <x-container title="Inventaris">
        <x-button
            wire:click.prevent="$emit('openModal', 'inventaris.inventaris-modal')">
            Tambah Inventaris
        </x-button>

        <livewire:inventaris.inventaris-table/>

    </x-container>
</div>