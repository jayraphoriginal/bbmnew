<div class="w-full">
    <x-container title="Satuan">
        <x-button
            wire:click.prevent="$emit('openModal', 'satuan.satuan-modal')">
            Tambah Satuan
        </x-button>

        <livewire:satuan.satuan-table/>

    </x-container>
</div>
