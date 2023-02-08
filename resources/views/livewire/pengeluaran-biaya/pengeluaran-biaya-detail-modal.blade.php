<div>
    <x-header-modal>
        Input Detail Biaya
    </x-header-modal>

    <x-form-group caption="Biaya">
        <x-combobox
            wire:model="tmp.m_biaya_id"
        >
            <option value="">-- Isi Biaya --</option>
            @foreach ($biaya as $item)
                <option value="{{ $item->id }}">{{ $item->nama_biaya }}</option>
            @endforeach
        </x-combobox>
        @error('tmp.m_biaya_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Pembebanan">
        <x-combobox
            wire:model="tmp.jenis_pembebanan"
        >
            <option value="">-- Isi Pembebanan -- </option>
            <option value="Beban Alat">Beban Alat</option>
            <option value="Beban Kendaraan">Beban Kendaraan</option>
            <option value="-">Non Beban</option>
        </x-combobox>
        @error('tmp.jenis_pembebanan')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    @if($tmp->jenis_pembebanan =='Beban Kendaraan')
        <x-form-group caption="Kendaraan">
            <livewire:kendaraan.kendaraan-select :deskripsi="$kendaraan"/>
            @error('tmp.beban_id')
            <x-error-form>{{ $message }}</x-error-form>
            @enderror
        </x-form-group>
    @elseif($tmp->jenis_pembebanan =='Beban Alat')
        <x-form-group caption="Alat">
                <livewire:alat.alat-select :deskripsi="$alat"/>
                @error('tmp.beban_id')
                <x-error-form>{{ $message }}</x-error-form>
                @enderror
        </x-form-group>
    @endif

    <x-form-group caption="Jumlah Intax">
        <x-number-text
            wire:model="tmp.jumlah"
        />
        @error('tmp.jumlah')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

     <x-form-group caption="Keterangan">
        <x-textbox
            wire:model="tmp.keterangan"
        />
        @error('tmp.keterangan')
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
