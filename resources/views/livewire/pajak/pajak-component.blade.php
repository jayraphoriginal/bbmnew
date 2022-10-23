<div class="w-full">
    <x-container title="Pajak">
        <x-button
            wire:click.prevent="$emit('openModal', 'pajak.pajak-modal')">
            Tambah Pajak
        </x-button>

        <livewire:pajak.pajak-table/>

    </x-container>
</div>
