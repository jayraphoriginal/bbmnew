<div class="w-full">
    <x-container title="Pengurangan Bahan Bakar">
        <x-button
            wire:click.prevent="$emit('openModal', 'bbm.pengurangan-bbm-modal')">
            Pengurangan Bahan Bakar
        </x-button>

        <livewire:bbm.pengurangan-bbm-table/>

    </x-container>
</div>
