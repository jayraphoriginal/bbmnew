<div class="w-full">
    <x-container title="Penerimaan Pembayaran">
        <x-button
            wire:click.prevent="$emit('openModal', 'penerimaan.penerimaan-modal')">
            Tambah Penerimaan
        </x-button>

        <x-button
            wire:click.prevent="$emit('openModal', 'penerimaan.penerimaan-invoice-modal')">
            Tambah Penerimaan Invoice
        </x-button>

        <div>
            <label>Tahun :</label>
            <x-combobox wire:model="tahun" class="w-1/4 mt-2 mb-4">
                <option value="">Pilih Tahun</option>
                @for($i = 2022; $i <= date('Y'); $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </x-combobox>
        </div>


       <livewire:penerimaan.penerimaan-table tahun="{{ $tahun }}" :wire:key="'penerimaan-table-'.$tahun" />
    </x-container>
</div>
