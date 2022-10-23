<div>
    <x-header-modal>
        Input Detail SO Sewa
    </x-header-modal>

    <x-form-group caption="Item">
        <livewire:sewa.itemsewa-select :deskripsi="$itemsewa" />
        @error('DSalesorder.itemsewa_id')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Harga Intax">
        <x-number-text
            wire:model="DSalesorder.harga_intax"
        />
        @error('DSalesorder.harga_intax')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Lama">
        <x-number-text
            wire:model="DSalesorder.lama"/>
        @error('DSalesorder.lama')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Satuan">
        <x-textbox
            readonly
            wire:model="satuan"
        />
        @error('DSalesorder.satuan_id')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Tanggal Awal">
        <x-datepicker
            wire:model="DSalesorder.tgl_awal"
        />
        @error('DSalesorder.tgl_awal')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Tanggal Akhir">
        <x-datepicker
            wire:model="DSalesorder.tgl_akhir"
        />
        @error('DSalesorder.tgl_akhir')
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
