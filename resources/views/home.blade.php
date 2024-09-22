<x-layouts.app>

    <x-title label="Home" />

    <main class="home" x-data="{ tab: $persist(0) }">

        <nav class="tabs">
            <button type="button" :class="tab===0?'active':''" @click="tab=0">Overview</button>
            <button type="button" :class="tab===1?'active':''" @click="tab=1">Statistics</button>
        </nav>

        <div x-cloak x-show="tab===0">
            <dl>
                <dt>Name</dt>
                <dd>{{ auth()->user()->name }}</dd>

                <dt>Age</dt>
                <dd>{{ auth()->user()->created_at->diffForHumans(syntax:\Carbon\CarbonInterface::DIFF_ABSOLUTE, parts:2) }}</dd>

                <dt>Location</dt>
                <dd>{{ auth()->user()->city->name }}</dd>

                <dt>Cash</dt>
                <dd><x-currency :amount="auth()->user()->cash" /></dd>

                <dt>Banked</dt>
                <dd><x-currency :amount="auth()->user()->bank" /></dd>
            </dl>
            <dl>
                <dt>Property</dt>
                <dd>{{ auth()->user()->property->name }}</dd>

                <dt>Guild</dt>
                <dd>...</dd>

                <dt>Employment</dt>
                <dd>...</dd>

                <dt>Studying</dt>
                <dd>...</dd>

                <dt>Diamonds</dt>
                <dd><x-alt-currency :amount="auth()->user()->tokens" /></dd>
            </dl>
        </div>

        <table x-cloak x-show="tab===1">
            <thead>
                <tr>
                    <th>Skill</th>
                    <th>Experience</th>
                    <th>Level</th>
                    <th>Progress</th>
                    <th>Rank</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Strength</td>
                    <td>{{ number_format(auth()->user()->strength, 3) }}</td>
                    <td>{{ number_format(level(auth()->user()->strength)) }}</td>
                    <td>{{ number_format(progress(auth()->user()->strength), 2) }} %</td>
                    <td>TODO</td>
                </tr>
                <tr>
                    <td>Agility</td>
                    <td>{{ number_format(auth()->user()->agility, 3) }}</td>
                    <td>{{ number_format(level(auth()->user()->agility)) }}</td>
                    <td>{{ number_format(progress(auth()->user()->agility), 2) }} %</td>
                    <td>TODO</td>
                </tr>
                <tr>
                    <td>Defense</td>
                    <td>{{ number_format(auth()->user()->defense, 3) }}</td>
                    <td>{{ number_format(level(auth()->user()->defense)) }}</td>
                    <td>{{ number_format(progress(auth()->user()->defense), 2) }} %</td>
                    <td>TODO</td>
                </tr>
                <tr>
                    <td>Intelligence</td>
                    <td>{{ number_format(auth()->user()->intelligence, 3) }}</td>
                    <td>{{ number_format(level(auth()->user()->intelligence)) }}</td>
                    <td>{{ number_format(progress(auth()->user()->intelligence), 2) }} %</td>
                    <td>TODO</td>
                </tr>
                <tr>
                    <td>Endurance</td>
                    <td>{{ number_format(auth()->user()->endurance, 3) }}</td>
                    <td>{{ number_format(level(auth()->user()->endurance)) }}</td>
                    <td>{{ number_format(progress(auth()->user()->endurance), 2) }} %</td>
                    <td>TODO</td>
                </tr>
            </tbody>
        </table>

    </main>

</x-layouts.app>

