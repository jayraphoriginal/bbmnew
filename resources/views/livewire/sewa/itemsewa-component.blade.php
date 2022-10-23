<div class="w-full">
    <x-container title="Item Sewa">
        <x-button
            wire:click.prevent="$emit('openModal', 'sewa.itemsewa-modal')">
            Tambah Item
        </x-button>

        <livewire:sewa.itemsewa-table/>

    </x-container>
</div>
