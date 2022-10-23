<div class="w-full">
    <x-container title="Barang">
        <x-button
            wire:click.prevent="$emit('openModal', 'barang.barang-modal')">
            Tambah Barang
        </x-button>

        <livewire:barang.barang-table/>

    </x-container>
</div>
