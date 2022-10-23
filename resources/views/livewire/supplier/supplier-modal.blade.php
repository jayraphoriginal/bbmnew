<div>
    <x-header-modal>
        Input Supplier
    </x-header-modal>

    <x-form-group caption="Nama Supplier">
        <x-textbox
            wire:model="supplier.nama_supplier"
        />
        @error('supplier.nama_supplier')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="NPWP">
        <x-textbox
            x-mask="99.999.999.9-999.999"
            wire:model="supplier.npwp"/>
        @error('supplier.npwp')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Alamat">
        <x-textbox
            wire:model="supplier.alamat"/>
        @error('supplier.alamat')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="No Telp">
        <x-textbox
            wire:model="supplier.notelp"/>
        @error('supplier.notelp')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="No Fax">
        <x-textbox
            wire:model="supplier.nofax"/>
        @error('supplier.nofax')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Nama Pemilik">
        <x-textbox
            wire:model="supplier.nama_pemilik"/>
        @error('supplier.nama_pemilik')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Jenis Usaha">
        <x-textbox
            wire:model="supplier.jenis_usaha"/>
        @error('supplier.jenis_usaha')
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
