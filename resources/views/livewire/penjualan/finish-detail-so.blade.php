<div class="p-3 ">
    <div class="font-semibold font-gray-700 text-lg">Finish SO</div>

    <div class="py-2">
        <div class="font-normal text-gray-600">Apakah Anda ingin Finish SO ini ?</div>
        <x-footer-modal>
            <x-secondary-button wire:click="cancel">
                Cancel
            </x-secondary-button>
            <x-button wire:click="confirm">
                Confirm
            </x-button>
        </x-footer-modal>
    </div>

</div>