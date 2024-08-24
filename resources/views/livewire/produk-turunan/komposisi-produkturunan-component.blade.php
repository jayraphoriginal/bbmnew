<div class="w-full">
    <x-container title="Komposisi {{ $deskripsi }}">
        <x-button
            wire:click="add">
            Tambah Komposisi
        </x-button>

        <livewire:produk-turunan.komposisi-produkturunan-table produkturunan_id="{{$produkturunan_id}}"/>

        <x-footer-modal>
            <x-secondary-button
                wire:click="$emit('closeModal')"
            >Tutup</x-secondary-button>
        </x-footer-modal>
    </x-container>
</div>

