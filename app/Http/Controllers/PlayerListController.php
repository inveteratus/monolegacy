<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlayerListController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('players', ['players' => User::query()->paginate()]);
    }
}
