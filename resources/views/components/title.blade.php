@props(['label', 'sub' => null, 'links' => []])

<div class="flex items-baseline justify-between border-b border-slate-300">
    <h2 class="text-4xl font-light text-slate-700">
        <span>{{ $label }}</span>
        @if ($sub)
            <span class="text-3xl text-slate-600">{{ $sub }}</span>
        @endif
    </h2>

    @if ($links)
        <div class="flex text-sm space-x-1 text-slate-400">
            @foreach ($links as $label => $href)
                @if (!$loop->first)
                    <span>/</span>
               @endif
                <a href="{{ $href }}" class="text-blue-500 hover:text-blue-600 focus:underline focus:outline-none">{{ $label }}</a>
            @endforeach
        </div>
    @endif
</div>
