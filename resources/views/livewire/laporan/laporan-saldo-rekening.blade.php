<div>
    <x-header-modal>
       Laporan Saldo Kas/Bank
    </x-header-modal>

    <x-form-group caption="Tanggal Awal">
        <x-datepicker
            wire:model="tgl_awal"
        />
    </x-form-group>

    <x-form-group caption="Tanggal Akhir">
        <x-datepicker
            wire:model="tgl_akhir"
        />
    </x-form-group>

    <x-form-group caption="Rekening">
        <livewire:bank.rekening-select :deskripsi="$rekening"/>
        @error('rekening_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Cancel</x-secondary-button>
        <x-link-button
            href="/laporansaldorekening/{{$tgl_awal}}/{{$tgl_akhir}}/{{$rekening_id}}" target="__blank"
            >Print</x-link-button>
    </x-footer-modal>
</div>
