<div class="w-full">
    <x-container title="Jarak Tempuh">
        <x-button
            wire:click.prevent="$emit('openModal', 'rate.jaraktempuh-modal')">
            Tambah Jarak Tempuh
        </x-button>

        <livewire:rate.jaraktempuh-table/>

    </x-container>
</div>
