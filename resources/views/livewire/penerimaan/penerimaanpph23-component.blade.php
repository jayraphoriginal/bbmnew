<div class="w-full">
    <x-container title="Penerimaan Pembayaran">
        <x-button
            wire:click.prevent="$emit('openModal', 'penerimaan.penerimaan-pph23-modal')">
            Tambah Penerimaan Bupot PPh 23
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


       <livewire:penerimaan.penerimaan-pph23-table/>
    </x-container>
</div>
