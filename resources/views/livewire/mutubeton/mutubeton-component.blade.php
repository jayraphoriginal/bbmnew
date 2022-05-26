<div class="w-full">
    <x-container title="Mutu Beton">
        <x-button
            wire:click.prevent="$emit('openModal', 'mutubeton.mutubeton-modal')">
            Tambah Mutubeton
        </x-button>

        <livewire:mutubeton.mutubeton-table/>

    </x-container>
</div>
