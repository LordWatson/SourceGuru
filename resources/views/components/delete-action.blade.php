<button {{ $attributes->merge(['class' => 'text-red-900 cursor-pointer hover:text-red-900 pl-1']) }}>
    {{ $slot }}
</button>
