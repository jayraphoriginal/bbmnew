<div>
    <x-header-modal>
        Input Kategori
    </x-header-modal>

    <x-form-group caption="Kategori">
        <x-textbox
            wire:model="kategori.kategori"
        />
        @error('kategori.kategori')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-form-group caption="Header Akun">
        <x-combobox
            wire:model="header_akun"
            >
            <option value="" selected>-- Pilih Header Akun --</option>
            @foreach ($header as $item)
            <option value="{{ $item->kode_akun }}">{{ $item->kode_akun }}</option>
            @endforeach
        </x-combobox>
        @error('header_akun')
        <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Cancel</x-secondary-button>
        <x-button
            wire:click="save">Save</x-button>
    </x-footer-modal>
</div>