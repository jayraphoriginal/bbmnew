<div class="container-fluid grid px-6 mx-auto">

    <h4 class="my-6 mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
        {{ $title }}
    </h4>

    <div class="w-full overflow-hidden rounded-lg shadow-xs p-3">
        <div class="w-full">
            {{ $slot }}
        </div>
    </div>

</div>
