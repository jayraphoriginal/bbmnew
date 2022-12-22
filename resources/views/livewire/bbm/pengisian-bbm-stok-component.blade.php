<div class="w-full">
    <x-container title="Pemakaian Barang">
        <x-button
            wire:click.prevent="$emit('openModal', 'bbm.pengisian-bbm-stok-modal')">
            Tambah Pengisian BBM
        </x-button>

        <livewire:bbm.pengisian-bbm-stok-table/>
    </x-container>
</div>