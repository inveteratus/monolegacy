<?php

namespace App\Http\Controllers;

use App\Http\Requests\BankRequest;
use Illuminate\Http\RedirectResponse;

class BankController extends Controller
{
    public function __invoke(BankRequest $request): RedirectResponse
    {
        $user = $request->user();
        $cash = $user->cash;
        $bank = $user->bank;

        if ($request->deposit && ($cash >= $request->deposit)) {
            $user->cash -= $request->deposit;
            $user->bank += $request->deposit;
            $user->save();
        }

        if ($request->withdraw && ($bank >= $request->withdraw)) {
            $user->cash += $request->withdraw;
            $user->bank -= $request->withdraw;
            $user->save();
        }

        return to_route('bank');
    }
}
