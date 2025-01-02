<!DOCTYPE html>
<html lang="en-GB">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Monolegacy</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-200 flex flex-col items-center justify-center min-h-screen text-slate-700">
    <form action="/login.php" method="post" class="bg-slate-100 rounded-md px-8 py-6 shadow border border-slate-300 max-w-md w-full flex flex-col space-y-3">
        <div class="flex flex-col space-y-1">
            <label for="email" class="text-sm font-medium text-slate-600">Email</label>
            <input id="email" type="email" name="email" value="{{ $email }}" autofocus autocomplete="email" required class="p-2 border border-slate-300 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:ring-offset-0 focus:border-blue-500 rounded" />
            @if (array_key_exists('email', $errors))
                <span class="text-sm text-red-500">{{ $errors['email'] }}</span>
            @endif
        </div>
        <div class="flex flex-col space-y-1">
            <label for="password" class="text-sm font-medium text-slate-600">Password</label>
            <input id="password" type="password" name="password" autocomplete="current-password" required class="p-2 border border-slate-300 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:ring-offset-0 focus:border-blue-500 rounded" />
            @if (array_key_exists('password', $errors))
                <span class="text-sm text-red-500">{{ $errors['password'] }}</span>
            @endif
        </div>
        <div class="flex pt-3">
            <button type="submit" class="bg-blue-500 text-white font-medium px-3 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-offset-slate-100 focus:ring-blue-500">Login</button>
        </div>
    </form>
    <p class="pt-2 text-center text-sm"><a href="/register.php" class="text-slate-700 hover:underline focus:underline focus:outline-none">Not got an account yet ?</a></p>
</body>
</html>
