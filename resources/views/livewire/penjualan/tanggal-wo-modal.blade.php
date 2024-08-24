<div>
    <x-header-modal>
       Tanggal Work Order
    </x-header-modal>

    <x-form-group caption="Tanggal">
        <x-datepicker
            wire:model="tgl"
        />
    </x-form-group>

    <x-footer-modal>
        <x-secondary-button
            wire:click="$emit('closeModal')"
        >Cancel</x-secondary-button>
        <x-link-button href="/printwo/{{$so_id}}/{{$tgl}}" target="__blank">
            Print
        </x-link-button>
    </x-footer-modal>
</div>
