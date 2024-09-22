<x-layouts.app>

    <x-title :label="$city->name" :links="[
        'Travel Agency' => route('travel'),
        'Explore' => route('explore'),
    ]"/>

    <main class="travel-details grid grid-cols-2 gap-4">
        <div class="flex flex-col flex-grow">
            <p class="flex flex-grow leading-relaxed text-justify">{{ $city->description }}</p>
            @if (auth()->user()->city->id == $city->id)
                <div class="flex justify-end">
                    <x-acme.button.cancel :href="route('travel')" label="Back" />
                </div>
            @else
                <x-acme.form class="flex justify-between">
                    <div class="flex space-x-4 items-center">
                        <x-acme.button.submit label="Travel" />
                        <span class="text-slate-500 text-sm">(<x-currency :amount="$city->cost" />)</span>
                    </div>
                    <x-acme.button.cancel :href="route('travel')" label="Back" />
                </x-acme.form>
            @endif
        </div>
        <div>
            <img src="/storage/{{ $city->image }}" class="object-contain border-8 border-white shadow-lg">
        </div>
    </main>

</x-layouts.app>

