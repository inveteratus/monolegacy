<x-layouts.app>

    <x-title :label="$property->name" :links="[
        'Realtor' => route('realtor'),
        'Explore' => route('explore'),
    ]"/>

    <main class="realtor-details grid grid-cols-2 gap-4">
        <div class="flex flex-col flex-grow">
            <div class="flex flex-col flex-grow">
                <p class="leading-relaxed text-justify text-slate-700">{{ $property->description }}</p>

                {{-- Only show capacity if we've already purchased this property --}}
                @if ($property->cost <= auth()->user()->property->cost)
                    <p class="mt-2 text-slate-600">Capacity : {{ $property->capacity }}</p>
                @endif
            </div>
            @if ($property->cost <= auth()->user()->property->cost)
                {{-- we already own this property OR we are looking at a cheaper property --}}
                <div class="flex justify-end">
                    <x-acme.button.cancel :href="route('realtor')" label="Back" />
                </div>
            @else
                <x-acme.form class="flex justify-between">
                    <div class="flex space-x-4 items-center">
                        <x-acme.button.submit label="Purchase" />
                        <span class="text-slate-500 text-sm">(<x-currency :amount="$cost" />)</span>
                    </div>
                    <x-acme.button.cancel :href="route('realtor')" label="Back" />
                </x-acme.form>
            @endif
        </div>
        <div>
            <img src="/storage/{{ $property->image }}" class="object-contain border-8 border-white shadow-lg">
        </div>
        @if ($property->cost > auth()->user()->property->cost)
            <p class="col-span-2 bg-slate-200 rounded text-slate-500 border-slate-400 px-3 py-2 text-center">Purchase price takes into consideration the value of your current property less 10% for administration fees.</p>
        @endif
    </main>

</x-layouts.app>

