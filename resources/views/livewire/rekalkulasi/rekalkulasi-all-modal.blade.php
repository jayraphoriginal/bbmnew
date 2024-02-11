<div>
    <x-header-modal>
        Rekalkulasi All
    </x-header-modal>

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
