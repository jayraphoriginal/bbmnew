<div class="w-full">
    <x-container title="Rate">
        <x-button
            wire:click.prevent="$emit('openModal', 'rate.rate-modal')">
            Tambah Rate
        </x-button>

        <livewire:rate.rate-table/>

    </x-container>
</div>
