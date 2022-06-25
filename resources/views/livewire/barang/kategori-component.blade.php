<div class="w-full">
    <x-container title="Kategori">
        <x-button
            wire:click.prevent="$emit('openModal', 'barang.kategori-modal')">
            Tambah Kategori
        </x-button>

        <livewire:barang.kategori-table/>

    </x-container>
</div>