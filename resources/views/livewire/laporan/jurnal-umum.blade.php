<div>
    <x-header-modal>
       Laporan Saldo COA
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

    <x-form-group caption="COA">
         <livewire:coa.coa-select :deskripsi="$coa" />
        @error('coa_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Cancel</x-secondary-button>
        <x-link-button
            href="/laporanjurnalumum/{{$tgl_awal}}/{{$tgl_akhir}}/{{$coa_id}}" target="__blank"
            >Print</x-link-button>
            <x-link-button
            href="/exportjurnalumum/{{$tgl_awal}}/{{$tgl_akhir}}/{{$coa_id}}" target="__blank"
            >Export</x-link-button>
    </x-footer-modal>
</div>