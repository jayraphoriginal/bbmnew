<div class="w-full">
    <x-container title="Produksi">
        <x-button
            wire:click.prevent="$emit('openModal', 'produksi.produksi-new-modal')">
            Tambah Produksi
        </x-button>

        <livewire:produksi.produksi-table/>

    </x-container>
</div>