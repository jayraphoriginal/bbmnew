<div>
    <x-header-modal>
        Rekalkulasi Per Barang
    </x-header-modal>

    <x-form-group caption="Item">
        <livewire:barang.barang-select :deskripsi="$barang" />
        @error('barang_id')
            <x-error-form>{{ $message }}</x-error-form>
        @enderror
    </x-form-group>
{{ $barang_id }}
      <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')">
            Cancel
        </x-secondary-button>
        <x-button
            wire:click="save">
            Rekalkulasi
        </x-button>
    </x-footer-modal>
</div>
