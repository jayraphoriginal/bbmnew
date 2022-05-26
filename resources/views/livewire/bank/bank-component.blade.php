<div class="w-full">
    <x-container title="Bank">
        <x-button
            wire:click.prevent="$emit('openModal', 'bank.bank-modal')">
            Tambah Bank
        </x-button>

        <livewire:bank.bank-table/>

    </x-container>
</div>
