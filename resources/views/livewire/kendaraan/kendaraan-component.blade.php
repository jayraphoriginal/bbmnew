<div class="w-full">
    <x-container title="Kendaraan">
        <x-button
            wire:click.prevent="$emit('openModal', 'kendaraan.kendaraan-modal')">
            Tambah Kendaraan
        </x-button>

        <livewire:kendaraan.kendaraan-table/>

    </x-container>
</div>
