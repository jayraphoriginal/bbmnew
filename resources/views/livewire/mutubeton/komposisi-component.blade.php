<div class="w-full">
    <x-container title="Komposisi {{ $kode_mutu }}">
        <x-button
            wire:click="add">
            Tambah Komposisi
        </x-button>

        <livewire:mutubeton.komposisi-table mutubeton_id="{{$mutubeton_id}}"/>

        <x-footer-modal>
            <x-secondary-button
                wire:click="$emit('closeModal')"
            >Tutup</x-secondary-button>
        </x-footer-modal>
    </x-container>
</div>

