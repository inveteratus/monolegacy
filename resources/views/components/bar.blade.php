@props(['label', 'width', 'color'])

<div class="flex flex-col space-y-0.5">
    <div class="bg-white h-3 shadow-sm rounded-full overflow-hidden">
        <div class="{{ $color }} h-3" style="width:{{ $width }}%"></div>
    </div>
    <p class="text-slate-700 text-sm flex items-center justify-between">
        <span>{{ $label }}</span>
        <span>{{ $slot }}</span>
    </p>
</div>
