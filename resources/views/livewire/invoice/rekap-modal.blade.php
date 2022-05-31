<div>
    <x-header-modal>
        Daftar Sales Order
    </x-header-modal>

   
    <x-form-group caption="Sales Order">
        <x-combobox
            wire:model="tipe"
        >
            <option value="">-- Isi Tipe --</option>
            <option value="Ready Mix">Ready Mix</option>
            <option value="Sewa">Sewa</option>
        </x-combobox>
    </x-form-group>

    @if($tipe=='Sewa')
        <livewire:sewa.salesorder-sewa-table/>
    @else
        <livewire:penjualan.salesorder-table/> 
    @endif

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Cancel</x-secondary-button>
    </x-footer-modal>

</div>

