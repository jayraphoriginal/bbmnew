<div class="w-full">
    <x-container title="Penerimaan Pembayaran">
        <x-button
            wire:click.prevent="$emit('openModal', 'penerimaan.penerimaan-modal')">
            Tambah Penerimaan
        </x-button>

       <livewire:penerimaan.penerimaan-table/>
    </x-container>
</div>
