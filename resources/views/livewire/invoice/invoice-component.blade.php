<div class="w-full">
    <x-container title="Invoice">
        <x-button
            wire:click.prevent="$emit('openModal', 'invoice.so-modal')">
            Buat Invoice
        </x-button>

        <div>
            <select wire:model="tahun" wire:change="updateTable" class="w-1/4 mt-4 mb-4">
                <option value="">Pilih Tahun</option>
                @for($tahundata=2022; $tahundata<=date('Y'); $tahundata++)
                    <option value="{{ $tahundata }}">{{ $tahundata }}</option>
                @endfor
            </select>
        </div>


        <livewire:invoice.invoice-table tahun="{{ $tahun }}" :wire:key="'invoice-table-'.$tahun"/>

    </x-container>
</div>
