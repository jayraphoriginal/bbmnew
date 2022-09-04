<div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
    <div>
        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
            {{ $slot }}
            {{ $title }}
        </p>
        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
            {{ $value  }}
            <br/>
            <a class="text-sm underline underline-offset-1 text-gray-700 font-underlined" href="{{ $link }}">Detail</a>
        </p>
    </div>
</div>