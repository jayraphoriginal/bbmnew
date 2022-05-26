<div class="w-full">
    <x-container title="Supplier">
        <x-button
            wire:click.prevent="$emit('openModal', 'supplier.supplier-modal')">
            Tambah Supplier
        </x-button>

        <livewire:supplier.supplier-table/>

    </x-container>
</div>
