<div class="w-full">
    <x-container title="Golongan">
        <x-button
            wire:click.prevent="$emit('openModal', 'inventaris.golongan-modal')">
            Tambah Golongan
        </x-button>

        <livewire:inventaris.golongan-table/>

    </x-container>
</div>
