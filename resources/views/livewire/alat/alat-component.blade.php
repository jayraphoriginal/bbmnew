<div class="w-full">
    <x-container title="Alat">
        <x-button
            wire:click.prevent="$emit('openModal', 'alat.alat-modal')">
            Tambah Alat
        </x-button>

        <livewire:alat.alat-table/>

    </x-container>
</div>
