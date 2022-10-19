<div class="w-full">
    <x-container title="Permission">
        <x-button
            wire:click.prevent="$emit('openModal', 'user.permission-modal')">
            Tambah Permission
        </x-button>

        <livewire:user.permission-table/>

    </x-container>
</div>