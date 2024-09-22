<!DOCTYPE html>
<html lang="en" data-theme="night">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Platform</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-col min-h-screen font-poppins">

    <header class="flex justify-between items-center p-3 space-x-2 border-b sticky inset-0 z-50 backdrop-blur-md">
        <div>
            <a href="/" class="font-bold text-2xl">Blogs</a>
        </div>

        <nav>
            @guest
                <ul class="w-full h-full flex items-center space-x-4">
                    <li><a href="/login" class="hover:font-bold">Log In</a></li>
                    <li><a href="/register" class="hover:font-bold">Register</a></li>
                </ul>
            @endguest

            @auth
                <details class="dropdown dropdown-end">
                    <summary class="btn m-1">
                        <x-avatar class="w-12" name="{{ auth()->user()->name }}" />
                    </summary>
                    <ul class="menu dropdown-content bg-slate-600 rounded-box z-[1] w-52 p-2 shadow">
                        <li><a href="/">Home</a></li>
                        <li><a href="/profile">Profile</a></li>
                        <form method="POST" action="/logout">
                            @csrf
                            <li>
                                <input class="cursor-pointer" type="submit" value="Log Out">
                            </li>
                        </form>
                    </ul>
                </details>
            @endauth
        </nav>
    </header>

    <main class="flex-grow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>

    @if (session('type') && session('message'))
        <x-alert :type="session('type')" :message="session('message')" />
    @endif
</body>

</html>
