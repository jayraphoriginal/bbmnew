<div x-data="{search : false}">
    <input
       readonly
       x-on:click="search = !search; $focus.within($refs.query).first()"
       wire:click="resetdata"
       wire:model="noinvoice"
       class="block w-full mt-1 border border-gray-300 p-2 rounded-md focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
       placeholder="Input Invoice - {{ $customer_id }}">
    <div
        x-show="search"
        class="w-max absolute mt-0 border border-gray-700 z-100 rounded-md bg-white dark:bg-gray-800 dark:text-gray-300 p-1"
        >
        <div class="flex" x-ref="query">
            <input
                wire:model="search"
                type="text"
                class="block w-full mt-1 border border-gray-300 p-2 rounded-md focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            >
        </div>
        <div class="flex flex-col w-full mt-1 mb-1 space-y-2">
            @if(!empty($search))
                @if(!empty($invoices))
                    @foreach ($invoices as $item)
                        <div
                            wire:click="selectdata({{ $item->id }})" @click.away="search = false" class="flex items-center text-sm justify-between hover:bg-purple-700 p-2 hover:text-white">
                            {{ $item->noinvoice }}
                        </div>
                    @endforeach
                @else
                    <div class="flex items-center text-sm justify-between hover:bg-purple-700 p-2 hover:text-white">
                        Tidak ada data
                    </div>
                @endif
            @endif
        </div>
    </div>

</div>
