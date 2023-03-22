<div class="w-full">
    <x-container title="Opname Stok">
        <x-button
            wire:click.prevent="$emit('openModal', 'opname.opname-modal')">
            Input Opname
        </x-button>

        <livewire:opname.opname-table/>

    </x-container>
</div>
