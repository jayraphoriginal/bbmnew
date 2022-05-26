<div class="w-full">
    <x-container title="Rekening">
        <x-button
            wire:click.prevent="$emit('openModal', 'bank.rekening-modal')">
            Tambah Rekening
        </x-button>

        <livewire:bank.rekening-table/>

    </x-container>
</div>
