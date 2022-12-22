<div class="w-full">
    <x-container title="Pemakaian Barang">
        <x-button
            wire:click.prevent="$emit('openModal', 'pemakaian-barang.pemakaian-barang-modal')">
            Tambah Pemakaian Barang
        </x-button>
        <livewire:pemakaian-barang.pemakaian-barang-table/>
    </x-container>
</div>
