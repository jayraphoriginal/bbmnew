<div>
    <x-header-modal>
        Input Pengeluaran Biaya
    </x-header-modal>

    <x-form-group caption="Supplier">
        <livewire:supplier.supplier-select :deskripsi="$supplier"/>
        @error('pengeluaran.supplier_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Biaya">
        <x-combobox
            wire:model="pengeluaran.m_biaya_id"
        >
            <option value="">-- Isi Biaya --</option>
            @foreach ($biaya as $item)
                <option value="{{ $item->id }}">{{ $item->nama_biaya }}</option>
            @endforeach
        </x-combobox>
        @error('pengeluaran.m_biaya_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Tipe Pembayaran">
        <x-combobox
            wire:model="pengeluaran.tipe_pembayaran"
        >
            <option value="">-- Isi Tipe Pembayaran --</option>
            <option value="Cash">Cash</option>
            <option value="Kredit">Kredit</option>
        </x-combobox>
        @error('pengeluaran.tipe_pembayaran')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="PPN">
        <x-combobox
            wire:model="pengeluaran.ppn_id"
        >
            <option value="">-- Isi PPN --</option>
            @foreach ($pajakppn as $item)
                <option value="{{ $item->id }}">{{ $item->jenis_pajak }}</option>
            @endforeach
            <option value="0">Non PPN</option>
        </x-combobox>
        @error('pengeluaran.ppn_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Pajak Lain">
        <x-combobox
            wire:model="pengeluaran.pajaklain_id"
        >
            <option value="">-- Isi Pajak Lain --</option>
            @foreach ($pajakpph as $item)
                <option value="{{ $item->id }}">{{ $item->jenis_pajak }}</option>
            @endforeach
            <option value="0">Non Pajak</option>
        </x-combobox>
        @error('pengeluaran.pajaklain_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Rekening">
        <x-combobox
            wire:model="pengeluaran.rekening_id"
        >
            <option value="">-- Isi Rekening --</option>
            @foreach ($rekening as $item)
                <option value="{{ $item->id }}">{{ $item->kode_bank.' - '.$item->norek }}</option>
            @endforeach
        </x-combobox>
        @error('pengeluaran.rekening_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jumlah Intax">
        <x-number-text
            wire:model="pengeluaran.total"
        />
        @error('pengeluaran.total')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Keterangan">
        <x-textbox
            wire:model="pengeluaran.keterangan"
        />
        @error('pengeluaran.keterangan')
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