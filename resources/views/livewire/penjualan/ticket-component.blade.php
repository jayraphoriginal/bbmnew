<div class="w-full">
    <x-container title="Ticket Material">
        <x-link-button
            target="__blank"
            href="/printticketkosong"
        >
            Print Ticket Kosong
        </x-link-button>
        <label class="block my-5"><x-checkbox wire:model="status"/>Show Finish SO</label>
       
        @if($status)
            <livewire:penjualan.salesorder-full-table/>
        @else
            <livewire:penjualan.salesorder-open-table/>
        @endif
    </x-container>
</div>