<div>
    <x-header-modal>
        Input Pemakaian Barang
    </x-header-modal>

    <x-form-group caption="Biaya">
        <x-combobox
            wire:model="pemakaian.m_biaya_id"
        >
            <option value="">-- Isi Biaya --</option>
            @foreach ($biaya as $item)
                <option value="{{ $item->id }}">{{ $item->nama_biaya }}</option>
            @endforeach
        </x-combobox>
        @error('pemakaian.m_biaya_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Barang">
        <livewire:barang.barang-select :deskripsi="$barang" />
        @error('pemakaian.barang_id')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jumlah">
        <x-number-text
            wire:model="pemakaian.jumlah"
        />
        @error('pemakaian.jumlah')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    @if($pemakaian->m_biaya_id == 2)
    <x-form-group caption="Kendaraan">
            <livewire:kendaraan.kendaraan-select :deskripsi="$kendaraan"/>
            @error('pemakaian.keterangan_id')
            <x-error-form>{{ $message }}</x-error-form>
            @enderror
    </x-form-group>
    @elseif($pemakaian->m_biaya_id == 1)
    <x-form-group caption="Alat">
            <livewire:alat.alat-select :deskripsi="$alat"/>
            @error('pemakaian.keterangan_id')
            <x-error-form>{{ $message }}</x-error-form>
            @enderror
    </x-form-group>
    @endif

    <x-form-group caption="Keterangan">
        <x-textbox
            wire:model="pemakaian.keterangan"
        />
        @error('pemakaian.keterangan')
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