<div>
    <x-header-modal>
        Input Invoice SO {{ $noso }}
    </x-header-modal>

    <x-form-group caption="Tanggal Cetak">
        <x-datepicker
            wire:model="tgl_cetak"
        />
        @error('tgl_cetak')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Customer">
        <x-textbox
            readonly
            wire:model="customer"
        />
    </x-form-group>

    @if($pembayaran <> 'Dimuka Full')
    <x-form-group caption="Dari Tanggal">
        <x-datepicker
            wire:model="tgl_awal"
            wire:change="selecttgl"
        />
        @error('tgl_awal')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Sampai Tanggal {{$jumlahtest}}">
        <x-datepicker
            wire:model="tgl_akhir"
            wire:change="selecttgl"
        />
        @error('tgl_akhir')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>
    @endif
    <x-form-group caption="Nilai Tagihan">
        <x-number-text
            readonly
            wire:model="jumlah_total"
        />
    </x-form-group>

    <x-form-group caption="Penjualan Retail">
        <x-number-text
            readonly
            wire:model="jumlah_penjualan_retail"
        />
    </x-form-group>

    @if($dp == "DP")
        <x-form-group caption="Jumlah Invoice DP">
            <x-number-text
                wire:model="jumlah_dp"
            />
        </x-form-group>
    @else
        <x-form-group caption="DP Sebelumnya">
            <x-number-text
                readonly
                wire:model="dp_sebelum"
            />
        </x-form-group>
    @endif

    <x-form-group caption="Rekening">
        <livewire:bank.rekening-select :deskripsi="$rekening"/>
        @error('rekening_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Tanda Tangan">
        <x-combobox wire:model="tanda_tangan">
            <option value="">-- Isi Tanda Tangan --</option>
            <option value="Ismail Yusup">Ismail Yusup</option>
            <option value="Devin Yuwenka">Devin Yuwenka</option>
            <option value="Sony Suherman">Sony Suherman</option>
            <option value="Tedi Suherman">Tedi Suherman</option>
        </x-combobox>
        @error('tanda_tangan')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Keterangan">
        <x-textbox
            wire:model="keterangan"
        />
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Cancel</x-secondary-button>
        <x-button
            wire:loading.attr="disabled"
            wire:click="save">Save</x-button>
    </x-footer-modal>

</div>
