@props(['method' => 'post'])

<form {{ $attributes->merge(['method' => strcasecmp('get', $method) ? 'post' : 'get']) }}>
    {{ $slot }}
    @csrf
    @if (!preg_match('`^(get|post)$`i', $method))
        @method($method)
    @endif
</form>
