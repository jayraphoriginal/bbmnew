<div class="w-full">
    <x-container title="Driver">
        <x-button
            wire:click.prevent="$emit('openModal', 'driver.driver-modal')">
            Tambah Driver
        </x-button>

        <livewire:driver.driver-table/>

    </x-container>
</div>
