<div class="p-3 ">
    <div class="font-semibold font-gray-700 text-lg">Delete Concrete Pump</div>

    <div class="py-2">
        <div class="font-normal text-gray-600">Apakah anda yakin ingin menghapus ?</div>
        <x-footer-modal>
            <x-secondary-button wire:click="cancel">
                Cancel
            </x-secondary-button>
            <x-button wire:click="delete">
                Confirm
            </x-button>
        </x-footer-modal>
    </div>

</div>
