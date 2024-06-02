@props(['active' => false, "type" => "a"])

@switch($type)
    @case("bttton")
        <button 
            type="button" 
            class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
            {{ $slot }}
        </button>
        @break
    @default
        <a 
        class="
            {{ $active ? "bg-gray-900 text-white" : "text-gray-300 hover:bg-gray-700 hover:text-white" }}
            rounded-md px-3 py-2 text-sm font-medium" aria-current="page"
            aria-current="{{ $active ? "Page" : "false" }}"
            {{ $attributes }}
        >{{ $slot }}</a>
@endswitch



{{-- <a
    {{ $attributes->class([
        'default classes',
        'active' => url()->current() === $attributes->get('href')
    ]) }}
>
    {{ $slot }}
</a> --}}