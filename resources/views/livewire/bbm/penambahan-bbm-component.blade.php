<div class="w-full">
    <x-container title="Tambahan Bahan Bakar">
        <x-button
            wire:click.prevent="$emit('openModal', 'bbm.penambahan-bbm-modal')">
            Tambahan Bahan Bakar
        </x-button>

        <livewire:bbm.penambahan-bbm-table/>

    </x-container>
</div>
