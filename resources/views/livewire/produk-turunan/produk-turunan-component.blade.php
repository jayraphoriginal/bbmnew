<div class="w-full">
    <x-container title="Produk Turunan">
        <x-button
            wire:click.prevent="$emit('openModal', 'produk-turunan.produk-turunan-modal')">
            Tambah Produk Turunan
        </x-button>

        <livewire:produk-turunan.produk-turunan-table/>

    </x-container>
</div>
