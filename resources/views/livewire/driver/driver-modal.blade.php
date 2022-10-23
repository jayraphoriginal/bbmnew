<div>
    <x-header-modal>
        Input Driver
    </x-header-modal>

    <x-form-group caption="Nama Driver">
        <x-textbox
            wire:model="driver.nama_driver"
        />
        @error('driver.nama_driver')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Tempat Lahir">
        <x-textbox
            wire:model="driver.tmpt_lahir"
        />
        @error('driver.tmpt_lahir')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Tanggal Lahir">
        <x-datepicker
            wire:model="driver.tgl_lahir"
        />
        @error('driver.tgl_lahir')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Alamat">
        <x-textbox
            wire:model="driver.alamat"/>
        @error('driver.alamat')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Pendidikan Terakhir">
        <x-textbox
            wire:model="driver.pendidikan_terakhir"/>
        @error('driver.pendidikan_terakhir')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Tanggal Masuk">
        <x-datepicker
            wire:model="driver.tgl_masuk"
        />
        @error('driver.tgl_masuk')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Agama">
        <x-combobox
            wire:model="driver.agama">
            <option value="">-- Isi Agama --</option>
            <option value="Islam">Islam</option>
            <option value="Katolik">Katolik</option>
            <option value="Kristen">Kristen</option>
            <option value="Buddha">Buddha</option>
            <option value="Hindu">Hindu</option>
        </x-combobox>
        @error('driver.agama')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Status">
        <x-combobox
            wire:model="driver.status">
            <option value="">-- Isi Status --</option>
            <option value="Belum Menikah">Belum Menikah</option>
            <option value="Menikah">Menikah</option>
            <option value="Janda">Janda</option>
            <option value="Duda">Duda</option>
        </x-combobox>
        @error('driver.status')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Golongan Darah">
        <x-combobox
            wire:model="driver.gol_darah">
            <option value="">-- Isi Golongan Darah --</option>
            <option value="O">O</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="AB">AB</option>
        </x-combobox>
        @error('driver.gol_darah')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="No. BPJS Tenaga Kerja">
        <x-textbox
            wire:model="driver.nobpjstk"/>
        @error('driver.nobpjstk')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="No. BPJS Kesehatan">
        <x-textbox
            wire:model="driver.nobpjskes"/>
        @error('driver.nobpjskes')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="No Telp">
        <x-textbox
            wire:model="driver.notelp"/>
        @error('driver.notelp')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Status Kerja">
        <x-combobox
            wire:model="driver.status_kerja">
            <option value="">-- Isi Status Kerja --</option>
            <option value="Aktif">Aktif</option>
            <option value="Non Aktif">Non Aktif</option>
        </x-combobox>
        @error('driver.status_kerja')
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
