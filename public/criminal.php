<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/globals.php';

use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\ExpressionFunction;

class CrimeFunctions implements ExpressionFunctionProviderInterface
{
    public function getFunctions(): array
    {
        return [
            ExpressionFunction::fromPhp('abs'),
            ExpressionFunction::fromPhp('ceil'),
            ExpressionFunction::fromPhp('exp'),
            ExpressionFunction::fromPhp('floor'),
            ExpressionFunction::fromPhp('log'),
            ExpressionFunction::fromPhp('max'),
            ExpressionFunction::fromPhp('min'),
            ExpressionFunction::fromPhp('pi'),
            ExpressionFunction::fromPhp('pow'),
            ExpressionFunction::fromPhp('sqrt'),
        ];
    }
}

global $h, $ir, $db, $h, $userid;

$sql = <<<SQL
    SELECT crimeID AS id, crimeNAME AS name, crimeBRAVE AS nerve, crimePERCFORM AS formula, crimeSUCCESSMUNY AS cash,
           crimeSUCCESSCRYS AS diamonds, crimeSUCCESSITEM AS item, crimeITEXT AS introduction, crimeSTEXT AS success,
           crimeFTEXT AS failure, crimeJTEXT AS jail, crimeJAILTIME AS time, crimeJREASON AS reason, crimeXP AS
           experience
    FROM crimes
SQL;

$crimes = $db->execute($sql)->fetchAll();
$context = [
    'crime_experience' => $ir['crimexp'],
    'experience' => $ir['exp'],
    'level' => $ir['level'],
    'strength' => $ir['strength'],
    'agility' => $ir['agility'],
    'defence' => $ir['guard'],
    'endurance' => $ir['labour'],
    'intelligence' => $ir['IQ'],
];
$language = new ExpressionLanguage(null, [new CrimeFunctions()]);

array_walk($crimes, function (object &$crime) use ($language, $context, $ir) {
    $crime->chance = $language->evaluate($crime->formula, $context);
    $crime->enabled = $crime->nerve <= $ir['brave'] && $ir['hospital'] == 0 && $ir['jail'] == 0;
    return $crime;
});
unset($crime);

usort($crimes, fn(object $a, object $b) => $b->chance - $a->chance);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = array_key_exists('id', $_POST) && ctype_digit($_POST['id']) ? $_POST['id'] : 0;
    if (in_array($id, array_column($crimes, 'id'))) {
        $crime = array_values(array_filter($crimes, fn (object $crime) => $crime->id == $id))[0];
        if ($crime->enabled) {
            $rowCount = $db->execute('UPDATE users SET brave = brave - :nerve1 WHERE userid = :userid AND brave >= :nerve2', [
                    'nerve1' => $crime->nerve,
                    'nerve2' => $crime->nerve,
                    'userid' => $userid,
                ])->rowCount();
            if ($rowCount > 0) {
                $name = htmlentities($crime->name);
                $intro = htmlentities($crime->introduction);
                if (random_int(0, 100) < $crime->chance) {
                    $success = htmlentities($crime->success);
                    $gains = [];
                    if ($crime->cash) {
                        $cash = floor($crime->cash * random_int(90, 110) / 100);
                        $db->execute('UPDATE users SET money = money + :cash WHERE userid = :userid', ['cash' => $cash, 'userid' => $userid]);
                        $gains[] = number_format($cash) . ' Cr';
                    }
                    if ($crime->diamonds) {
                        $db->execute('UPDATE users SET crystals = crystals + :amount WHERE userid = :userid', ['amount' => $crime->diamonds, 'userid' => $userid]);
                        $gains[] = number_format($crime->diamonds) . ' diamond' . ($crime->diamond == 1 ? '' : 's');
                    }
                    if ($crime->item) {
                        // TODO add to inventory
                        $gains[] = 'a/an ' . htmlentities($db->execute('SELECT itmname FROM items WHERE itmid = :id', ['id' => $crime->item])->fetchColumn());
                    }
                    $gains = count($gains) ? ('Gains: ' . implode(', ', $gains)) : 'Nothing';
                    $db->execute('UPDATE users SET crimexp = crimexp + :xp1, exp = exp + :xp2 WHERE userid = :userid', ['xp1' => $crime->experience, 'xp2' => $crime->experience / 10, 'userid' => $userid]);
                    echo <<<HTML
                    <div class="text-left">
                        <h2 class="text-slate-600 font-medium text-2xl">{$name}</h2>
                        <p class="my-2 text-slate-700">{$intro}</p>
                        <hr />
                        <p class="my-2 text-green-600">{$success}</p>
                        <p class="text-slate-600 text-center">Gain: {$gains}</p>
                        <hr />
                        <form action="/criminal.php" method="post" class="justify-center mt-3 flex space-x-2">
                            <button type="submit" name="id" value="{$id}" class="bg-blue-500 text-white text-sm px-3 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 focus:ring-offset-slate-50 font-medium">Try Again</button>
                            <a href="/criminal.php" class="bg-slate-300 text-slate-700 text-sm px-3 py-2 rounded hover:bg-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-1 focus:ring-offset-slate-50 font-medium">Back</a>
                        </form>
                    </div>
                HTML;
                } else {
                    $failure = htmlentities($crime->failure);
                    $jail = htmlentities($crime->jail);
                    $db->execute('UPDATE users SET jail = :jail WHERE userid = :userid', ['jail' => $crime->time, 'userid' => $userid]);

                    echo <<<HTML
                    <div class="text-left">
                        <h2 class="text-slate-600 font-medium text-2xl">{$name}</h2>
                        <p class="my-2 text-slate-700">{$intro}</p>
                        <hr />
                        <p class="my-2 text-red-600">{$failure} {$jail}</p>
                        <hr />
                        <p class="text-center mt-3">
                            <a href="/criminal.php" class="bg-slate-300 text-slate-700 text-sm px-3 py-2 rounded hover:bg-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-1 focus:ring-offset-slate-50 font-medium">Back</a>
                        </p>
                    </div>
                HTML;
                }
            }

            $h->endpage();
            exit;
        }
    }
}

echo <<<HTML
    <form action="/criminal.php" method="post" class="text-left">
        <h2 class="text-slate-600 font-medium text-2xl">Crimes</h2>
        <table class="w-full bg-white">
            <thead class="bg-slate-200">
                <tr>
                    <th class="p-2 text-left font-medium">Crime</th>
                    <th class="p-2 text-left font-medium">Nerve</th>
                    <th class="p-2 text-left font-medium">Chance</th>
                    <th class="p-2 text-center font-medium">Commit</th>
                </tr>
            </thead>
            <tbody>
HTML;

foreach ($crimes as $crime) {
    $id = $crime->id;
    $name = htmlentities($crime->name);
    $nerve = number_format($crime->nerve);
    $chance = number_format(max(1, min($crime->chance, 99)), 2) . ' %';
    $disabled = $crime->enabled ? '' : 'disabled';

    echo <<<HTML
        <tr class="hover:bg-blue-50">
            <td class="p-2 text-left text-slate-700">{$name}</td>
            <td class="p-2 text-left text-slate-700">{$nerve}</td>
            <td class="p-2 text-left text-slate-700">{$chance}</td>
            <td class="p-0 text-center">
                <button type="submit" name="id" value="{$id}" $disabled class="text-slate-700 disabled:text-slate-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.864 4.243A7.5 7.5 0 0 1 19.5 10.5c0 2.92-.556 5.709-1.568 8.268M5.742 6.364A7.465 7.465 0 0 0 4.5 10.5a7.464 7.464 0 0 1-1.15 3.993m1.989 3.559A11.209 11.209 0 0 0 8.25 10.5a3.75 3.75 0 1 1 7.5 0c0 .527-.021 1.049-.064 1.565M12 10.5a14.94 14.94 0 0 1-3.6 9.75m6.633-4.596a18.666 18.666 0 0 1-2.485 5.33" />
                    </svg>
                </button>
            </td>
        </tr>
    HTML;
}
echo <<<HTML
            </tbody>
        </table>
    </div>
HTML;
