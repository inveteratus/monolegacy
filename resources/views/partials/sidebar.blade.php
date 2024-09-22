<div class="aspect-square bg-white shadow rounded-lg">
    &nbsp;
</div>

<p class="text-sm flex justify-center space-x-1">
    <x-currency :amount="auth()->user()->cash" />
    <span>/</span>
    <x-alt-currency :amount="auth()->user()->tokens" />
</p>

<div class="flex flex-col space-y-1">
    <x-bar label="Energy" :width="(auth()->user()->energy * 100) / auth()->user()->max_energy" color="bg-red-500">
        {{ number_format((auth()->user()->energy * 100) / auth()->user()->max_energy, 1) }} %
    </x-bar>
    <x-bar label="Nerve" :width="(floor(auth()->user()->nerve) * 100) / auth()->user()->max_nerve" color="bg-amber-500">
        {{ number_format(floor(auth()->user()->nerve)) }} / {{ number_format(auth()->user()->max_nerve) }}
    </x-bar>
    <x-bar label="Health" :width="(auth()->user()->health * 100) / auth()->user()->max_health" color="bg-green-500">
        {{ number_format((auth()->user()->health * 100) / auth()->user()->max_health, 1) }} %
    </x-bar>
    <x-bar label="Power" :width="(auth()->user()->power * 100) / auth()->user()->property->capacity" color="bg-cyan-500">
        {{ number_format((auth()->user()->power * 100) / auth()->user()->property->capacity, 1) }} %
    </x-bar>
</div>
