<div class="w-full">
    <x-container title="Pembayaran Pembelian">
        <x-button
            wire:click.prevent="$emit('openModal', 'pembayaran.pembayaran-pembelian-modal')">
            Tambah Pembayaran
        </x-button>

        <livewire:pembayaran.pembayaran-pembelian-table/>
    </x-container>
</div>
