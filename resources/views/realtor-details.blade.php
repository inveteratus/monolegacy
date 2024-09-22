<x-layouts.app>

    <x-title :label="$city->name" :links="[
        'Realtor' => route('realtor'),
        'Explore' => route('explore'),
    ]"/>

    <main class="realtor-details grid grid-cols-2 gap-4">
        <div class="flex flex-col flex-grow">
            <p class="flex flex-grow leading-relaxed text-justify">{{ $property->description }}</p>
            @if (auth()->user()->property->id == $property->id)
                <div class="flex justify-end">
                    <x-acme.button.cancel :href="route('realtor')" label="Back" />
                </div>
            @else
                <x-acme.form class="flex justify-between">
                    <div class="flex space-x-4 items-center">
                        <x-acme.button.submit label="Purchase" />
                        <span class="text-slate-500 text-sm">(<x-currency :amount="$property->cost" />)</span>
                    </div>
                    <x-acme.button.cancel :href="route('realtor')" label="Back" />
                </x-acme.form>
            @endif
        </div>
        <div>
            <img src="/storage/{{ $property->image }}" class="object-contain border-8 border-white shadow-lg">
        </div>
    </main>

</x-layouts.app>

