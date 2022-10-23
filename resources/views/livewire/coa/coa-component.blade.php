<div class="w-full">
    <x-container title="Chart Of Account">
        <x-button
            wire:click.prevent="$emit('openModal', 'coa.coa-modal')">
            Tambah Coa
        </x-button>

        <livewire:coa.coa-table/>

    </x-container>
</div>
