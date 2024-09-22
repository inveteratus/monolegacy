<x-layouts.app>

    <x-title label="Travel Agency" :links="[
        'Explore' => route('explore'),
    ]"/>

    <main class="travel">
        @foreach ($cities as $city)
            <a href="{{ route('travel.details', $city) }}">
                <img src="/storage/{{ $city->image }}" />
                <p>{{ $city->name }}</p>
            </a>
        @endforeach
    </main>

</x-layouts.app>

