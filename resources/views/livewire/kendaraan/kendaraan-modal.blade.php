<div>
    <x-header-modal>
        Input Kendaraan
    </x-header-modal>

    <x-form-group caption="Nomor Polisi">
        <x-textbox
            wire:model="kendaraan.nopol"
        />
        @error('kendaraan.nopol')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Nama Pemilik">
        <x-textbox
            wire:model="kendaraan.nama_pemilik"
        />
        @error('kendaraan.nama_pemilik')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Alamat">
        <x-textbox
            wire:model="kendaraan.alamat"/>
        @error('kendaraan.alamat')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Tipe">
        <x-textbox
            wire:model="kendaraan.tipe"/>
        @error('kendaraan.tipe')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Model">
        <x-textbox
            wire:model="kendaraan.model"/>
        @error('kendaraan.model')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Tahun Pembuatan">
        <x-combobox
            wire:model="kendaraan.tahun_pembuatan"
        >
            @for($i=1995;$i<=date("Y");$i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </x-combobox>
        @error('kendaraan.tahun_pembuatan')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Warna KB">
        <x-textbox
            wire:model="kendaraan.warnakb"/>
        @error('kendaraan.warnakb')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Berlaku Sampai">
        <x-datepicker
            wire:model="kendaraan.berlaku_sampai"
        />
        @error('kendaraan.berlaku_sampai')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Berlaku Kir">
        <x-datepicker
            wire:model="kendaraan.berlaku_kir"
        />
        @error('kendaraan.berlaku_kir')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Tanggal Perolehan">
        <x-datepicker
            wire:model="kendaraan.tgl_perolehan"
        />
        @error('kendaraan.tgl_perolehan')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="SIU">
        <x-datepicker
            wire:model="kendaraan.siu"
        />
        @error('kendaraan.siu')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Muatan">
        <x-number-text
            wire:model="kendaraan.muatan"
        />
        @error('kendaraan.muatan')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Loading">
        <x-number-text
            wire:model="kendaraan.loading"
        />
        @error('kendaraan.loading')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Driver">
        <livewire:driver.driver-select :deskripsi="$driver"/>
        @error('kendaraan.driver_id')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')">
            Cancel
        </x-secondary-button>
        <x-button
            wire:click="save">
            Save
        </x-button>
    </x-footer-modal>
</div>
