<div>
    <x-header-modal>
        Input Pembayaran Pembelian
    </x-header-modal>

    <x-form-group caption="Supplier">
        <livewire:supplier.supplier-select :deskripsi="$supplier"/>
        @error('supplier_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Tanggal bayar">
        <x-datepicker
            wire:model="tgl_bayar"
        />
        @error('tgl_bayar')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Tipe">
        <x-combobox
            wire:model="tipe_pembayaran"
        >
            <option value="">-- Isi Tipe Pembayaran --</option>
            <option value="cash">Cash</option>
            <option value="transfer">Transfer</option>
            <option value="cheque">Cheque</option>
            <option value="giro">Giro</option>
        </x-combobox>
        @error('tipe_pembayaran')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Tanggal Jatuh Tempo">
        <x-datepicker
            wire:model="jatuh_tempo"
        />
        @error('jatuh_tempo')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="No Cheque / Giro">
        <x-textbox
            wire:model="nowarkat"
        />
        @error('nowarkat')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Rekening Asal">
        <livewire:bank.rekening-select :deskripsi="$rekening"/>
        @error('rekening_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jumlah Intax">
        <x-number-text
            wire:model="jumlah"
        />
        @error('jumlah')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Keterangan">
        <x-textbox
            wire:model="keterangan"
        />
        @error('keterangan')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Tutup</x-secondary-button>
        <x-button
            wire:click="save">
            Save
        </x-button>
    </x-footer-modal>
    
</div>
