<a  
    {{ $attributes->merge([
        'class' => 'px-4 py-2 mb-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-purple'
        ])
    }}
>
    {{ $slot }}
</a>