<div class="w-full">
    <x-container title="Biaya">
        <x-button
            wire:click.prevent="$emit('openModal', 'biaya.biaya-modal')">
            Tambah Biaya
        </x-button>

        <livewire:biaya.biaya-table/>

    </x-container>
</div>
