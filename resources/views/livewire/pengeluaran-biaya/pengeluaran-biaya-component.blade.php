<div class="w-full">
    <x-container title="Pengeluaran Biaya">
        <x-button
            wire:click.prevent="$emit('openModal', 'pengeluaran-biaya.pengeluaran-biaya-modal')">
            Tambah
        </x-button>

        <livewire:pengeluaran-biaya.pengeluaran-biaya-table/>

    </x-container>
</div>
