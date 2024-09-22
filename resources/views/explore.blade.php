<x-layouts.app>

    <x-title label="Explore" :sub="auth()->user()->city->name" />

    <main class="explore">
        <div>
            <h3>West End</h3>
            <div>
                <a href="#">Shopping Mall</a><br />
                <a href="#">Market Stalls</a><br />
                <a href="#">Diamond Exchange</a><br />
                <a href="#">Auction Rooms</a><br />
            </div>
        </div>

        <div>
            <h3>City Center</h3>
            <div>
                <a href="{{ route('bank') }}">National Bank</a><br />
                <a href="#">Stock Exchange</a><br />
                <a href="{{ route('realtor') }}">Realtor</a><br />
                <a href="{{ route('travel') }}">Travel Agency</a><br />
            </div>
        </div>

        <div>
            <h3>North Side</h3>
            <div>
                <a href="#">Magnum Casino</a><br />
                <a href="#">Glass Tower</a><br />
                <a href="#">Street Sweeper</a><br />
                <a href="#">High School</a><br />
            </div>
        </div>

        <div>
            <h3>South Side</h3>
            <div>
                <a href="#">County Hospital</a><br />
                <a href="#">State Penitentiary</a><br />
                <a href="#">Gymnasium</a><br />
                <a href="#">Employment Agency</a><br />
            </div>
        </div>

        <div>
            <h3>Tourist Information</h3>
            <div>
                <a href="{{ route('players') }}">Player List</a><br />
                <a href="{{ route('staff') }}">Staff List</a><br />
                <a href="#">Hall of Records</a><br />
                <a href="#">City Hall</a><br />
            </div>
        </div>

        <div>
            <h3>East End</h3>
            <div>
                <a href="#">Organised Crimes</a><br />
                <a href="#">Criminal Underground</a><br />
                <a href="#">Chapter House</a><br />
                <a href="#">Guild Recruiters</a><br />
            </div>
        </div>
    </main>
</x-layouts.app>

