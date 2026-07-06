<div class="w-full">
    <x-container title="Perhitungan HPP Mutu Beton - Kendaraan">
        <x-button
            wire:click.prevent="$emit('openModal', 'mutubeton.perhitungan-hpp-modal')">
            Tambah Komponen Perhitungan HPP
        </x-button>

        <livewire:mutubeton.perhitungan-hpp-table/>

    </x-container>
</div>