<div>
    <x-header-modal>
        Input Customer
    </x-header-modal>

    <x-form-group caption="Nama Customer">
        <x-textbox
            wire:model="customer.nama_customer"
        />
        @error('customer.nama_customer')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="NPWP">
        <x-textbox
            x-mask="99.999.999.9-999.999"
            wire:model="customer.npwp"/>
        @error('customer.npwp')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Alamat">
        <x-textbox
            wire:model="customer.alamat"/>
        @error('customer.alamat')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="No Telp">
        <x-textbox
            wire:model="customer.notelp"/>
        @error('customer.notelp')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="No Fax">
        <x-textbox
            wire:model="customer.nofax"/>
        @error('customer.nofax')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Nama Pemilik">
        <x-textbox
            wire:model="customer.nama_pemilik"/>
        @error('customer.nama_pemilik')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jenis Usaha">
        <x-textbox
            wire:model="customer.jenis_usaha"/>
        @error('customer.jenis_usaha')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Penyetoran PPN">
        <x-combobox
            wire:model="customer.penyetoran_ppn">
            <option value="">-- Isi Penyetoran PPN --</option>
            <option value="disetorkan">Disetorkan</option>
            <option value="setor sendiri">Setor Sendiri</option>
        </x-combobox>
        @error('customer.penyetoran_ppn')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Penyetoran PPH">
        <x-combobox
            wire:model="customer.penyetoran_pph">
            <option value="">-- Isi Penyetoran PPH --</option>
            <option value="disetorkan">Disetorkan</option>
            <option value="setor sendiri">Setor Sendiri</option>
        </x-combobox>
        @error('customer.penyetoran_pph')
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
