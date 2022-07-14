<div>
    <x-header-modal>
        Input Rekening
    </x-header-modal>

    <x-form-group caption="Bank">
        <livewire:bank.bank-select :deskripsi="$bank"/>
        @error('rekening.bank_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Nomor Rekening">
        <x-textbox
            wire:model="rekening.norek"
        />
        @error('rekening.norek')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Atas Nama">
        <x-textbox
            wire:model="rekening.atas_nama"
        />
        @error('rekening.atas_nama')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jenis Biaya">
        <x-combobox
            wire:model="header_coa"
        >
            <option value="">-- Isi COA Biaya --</option>
            @foreach ($coa as $item)
                <option value="{{ $item->kode_akun }}">{{ $item->kode_akun.' - '.$item->nama_akun }}</option>
            @endforeach
        </x-combobox>
        @error('header_coa')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Cancel</x-secondary-button>
        <x-button
            wire:click="save">Save</x-button>
    </x-footer-modal>
</div>
