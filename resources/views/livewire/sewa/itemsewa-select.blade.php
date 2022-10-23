<div x-data="{search : false}">
    <input
       readonly
       x-on:click="search = !search; $focus.within($refs.query).first()"
       wire:click="resetdata"
       wire:model="deskripsi"
       class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
       placeholder="Input Item Sewa">
    <div
        x-show="search"
        class="w-max absolute mt-0 border border-gray-700 z-40 rounded-md bg-white dark:bg-gray-800 dark:text-gray-300 p-1"
        >
        <div class="flex" x-ref="query">
            <input
                wire:model="search"
                type="text"
                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            >
        </div>
        <div class="flex flex-col w-full mt-1 mb-1 space-y-2">
            @if(!empty($search))
                @if(!empty($itemsewa))
                    @foreach ($itemsewa as $item)
                        <div
                            wire:click.prevent="selectdata({{ $item->id }})" @click="search = false" class="flex items-center text-sm justify-between hover:bg-purple-700 p-2 hover:text-white">
                            {{ $item->nama_item }}
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
