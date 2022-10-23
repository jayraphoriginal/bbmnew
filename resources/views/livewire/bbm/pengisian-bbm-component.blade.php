<div class="w-full">
    <x-container title="Pengisian Bahan Bakar">
        <x-button
            wire:click.prevent="$emit('openModal', 'bbm.pengisian-bbm-modal')">
            Pengisian Bahan Bakar
        </x-button>

        <livewire:bbm.pengisian-bbm-table/>

    </x-container>
</div>
