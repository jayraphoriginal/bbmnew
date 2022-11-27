<div>
    <x-header-modal>
        Daftar SO
    </x-header-modal>

    <x-form-group caption="Tipe">
        <x-combobox wire:model="tipe">
            <option value=""></option>
            <option value="Ready Mix">Ready Mix</option>
            <option value="Sewa">Sewa</option>
        </x-combobox>
    </x-form-group>

    @if($tipe=='Sewa')
        <livewire:invoice.so-sewa-table/>
    @else
        <livewire:invoice.so-table/>
    @endif


    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Tutup</x-secondary-button>
    </x-footer-modal>

</div>
