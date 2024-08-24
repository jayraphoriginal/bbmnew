<label {{ $attributes->merge(['class' => 'flex items-center dark:text-gray-400']) }}>
    {{ $slot }}
    <span class="ml-2">
        {{ $caption }}
    </span>
</label>