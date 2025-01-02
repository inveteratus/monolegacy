@extends('layouts.guest')

@section('body')
    <form action="/register.php" method="post" class="bg-slate-100 rounded-md px-8 py-6 shadow border border-slate-300 max-w-md w-full flex flex-col space-y-3">
        <div class="flex flex-col">
            <label for="name" class="text-sm font-medium text-slate-600">Name</label>
            <input id="name" type="text" name="name" value="{{ $name }}" maxlength="25" autofocus autocomplete="name" required class="p-2 border border-slate-300 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:ring-offset-0 focus:border-blue-500 rounded" />
            @if (array_key_exists('name', $errors))
                <span class="text-sm text-red-500">{{ $errors['name'] }}</span>
            @endif
        </div>
        <div class="flex flex-col">
            <label for="email" class="text-sm font-medium text-slate-600">Email</label>
            <input id="email" type="email" name="email" value="{{ $email }}" maxlength="250" autocomplete="email" required class="p-2 border border-slate-300 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:ring-offset-0 focus:border-blue-500 rounded" />
            @if (array_key_exists('email', $errors))
                <span class="text-sm text-red-500">{{ $errors['email'] }}</span>
            @endif
        </div>
        <div class="flex flex-col">
            <label for="password" class="text-sm font-medium text-slate-600">Password</label>
            <input id="password" type="password" name="password" autocomplete="new-password" required class="p-2 border border-slate-300 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:ring-offset-0 focus:border-blue-500 rounded" />
            @if (array_key_exists('password', $errors))
                <span class="text-sm text-red-500">{{ $errors['password'] }}</span>
            @endif
        </div>
        <div class="flex pt-3">
            <button type="submit" class="bg-blue-500 text-white font-medium px-3 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-offset-slate-100 focus:ring-blue-500">Register</button>
        </div>
    </form>
    <p class="pt-2 text-center text-sm"><a href="/login.php" class="text-slate-700 hover:underline focus:underline focus:outline-none">Already got an account ?</a></p>
@endsection
