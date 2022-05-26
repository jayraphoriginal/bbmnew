<div class="w-full">
    <x-container title="Bahan Bakar">
        <x-button
            wire:click.prevent="$emit('openModal', 'barang.bahanbakar-modal')">
            Tambah Bahan Bakar
        </x-button>

        <livewire:barang.bahanbakar-table/>

    </x-container>
</div>
