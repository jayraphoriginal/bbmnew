<div>
    <x-header-modal>
       Laporan Pemakaian Barang per Beban
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

    <x-form-group caption="Jenis Pembebanan">
        <x-combobox 
            wire:model="tipe"
            >
            <option value=""> -- Isi Jenis Pembebanan --</option>
            <option value="Beban Alat">Beban Alat</option>
            <option value="Beban Kendaraan">Beban Kendaraan</option>
            @error('tipe')
            <x-error-form>{{ $message }}</x-error-form>
            @enderror
        </x-combobox>
    </x-form-group>

    @if($tipe =='Beban Kendaraan')
        <x-form-group caption="Kendaraan">
            <livewire:kendaraan.kendaraan-select :deskripsi="$kendaraan"/>
            @error('beban_id')
            <x-error-form>{{ $message }}</x-error-form>
            @enderror
        </x-form-group>
    @elseif($tipe =='Beban Alat')
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

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Cancel</x-secondary-button>
        <x-link-button
            href="/laporanpemakaianperbarang/{{$tgl_awal}}/{{$tgl_akhir}}/{{$tipe}}/{{$beban_id}}/{{$barang_id}}" target="__blank"
            >Print</x-link-button>
    </x-footer-modal>
</div>