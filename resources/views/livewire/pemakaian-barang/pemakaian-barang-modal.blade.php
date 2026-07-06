<div>
    <x-header-modal>
        Input Pemakaian Barang
    </x-header-modal>

    <x-form-group caption="Tanggal">
        <x-datepicker
            wire:model="tgl_pemakaian"
        />
        @error('tgl_pemakaian')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Biaya">
        <x-combobox
            wire:model="m_biaya_id"
        >
            <option value="">-- Isi Biaya --</option>
            @foreach ($biaya as $item)
                <option value="{{ $item->id }}">{{ $item->nama_biaya }}</option>
            @endforeach
        </x-combobox>
        @error('m_biaya_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jenis Pembebanan">
        <x-combobox 
            wire:model="jenis_pembebanan"
            >
            <option value=""> -- Isi Jenis Pembebanan --</option>
            <option value="Beban Alat">Beban Alat</option>
            <option value="Beban Kendaraan">Beban Kendaraan</option>
            <option value="-">Non Beban</option>
            @error('jenis_pembebanan')
            <x-error-form>{{ $message }}</x-error-form>
            @enderror
        </x-combobox>
    </x-form-group>
    
    @if($jenis_pembebanan =='Beban Kendaraan')
        <x-form-group caption="Kendaraan">
            <livewire:kendaraan.kendaraan-select :deskripsi="$kendaraan"/>
            @error('beban_id')
            <x-error-form>{{ $message }}</x-error-form>
            @enderror
        </x-form-group>
    @elseif($jenis_pembebanan =='Beban Alat')
        <x-form-group caption="Alat">
                <livewire:alat.alat-select :deskripsi="$alat"/>
                @error('beban_id')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
        </x-form-group>
    @endif

    <x-form-group caption="Barang">
        <livewire:barang.barang-select :deskripsi="$barang" />
        @error('barang_id')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jumlah">
        <x-textbox
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
            wire:loading.attr="disabled"
            wire:click="save">
            Save
        </x-button>
    </x-footer-modal>
    
</div>