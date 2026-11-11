
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MAKEDONCE | Barber Studio')</title>
    <meta name="description" content="MAKEDONCE Barber Studio. Zakazivanje termina, profesionalne usluge i moderan stil.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#0c0d0f] text-stone-100 antialiased">

    <header class="sticky top-0 z-50 border-b border-white/10 bg-[#0c0d0f]/95 backdrop-blur-xl">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-6 py-5 lg:px-10">

            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-lg border border-amber-500/40 bg-amber-500/10 text-xl font-black text-amber-400">
                    M
                </div>

                <div>
                    <span class="block text-lg font-black tracking-[0.16em]">
                        MAKEDONCE
                    </span>
                    <span class="block text-[10px] uppercase tracking-[0.35em] text-amber-400">
                        Barber Studio
                    </span>
                </div>
            </a>

            <nav class="hidden items-center gap-7 text-sm font-medium text-stone-300 md:flex">
                <a href="{{ url('/') }}" class="transition hover:text-amber-400">
                    Početna
                </a>

                <a href="{{ route('services.index') }}" class="transition hover:text-amber-400">
                    Usluge
                </a>

                @auth
                    <a href="{{ route('bookings.index') }}" class="transition hover:text-amber-400">
                        Moje rezervacije
                    </a>

                    @can('manage-services')
                        <a href="{{ route('admin.slots.index') }}" class="transition hover:text-amber-400">
                            Termini
                        </a>

                        <a href="{{ route('admin.bookings.index') }}" class="transition hover:text-amber-400">
                            Admin
                        </a>
                    @endcan
                @endauth
            </nav>

            <div class="hidden items-center gap-4 md:flex">
                @guest
                    <a href="{{ route('login') }}" class="text-sm text-stone-300 hover:text-white">
                        Prijava
                    </a>
                @else
                    <span class="max-w-28 truncate text-sm text-stone-400">
                        {{ auth()->user()->name }}
                    </span>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="cursor-pointer text-sm text-stone-300 hover:text-white">
                            Odjava
                        </button>
                    </form>
                @endguest

                <a href="{{ route('bookings.create') }}" class="rounded-lg bg-amber-500 px-5 py-3 text-sm font-bold text-neutral-950 transition hover:bg-amber-400">
                    Zakaži termin
                </a>
            </div>

            <details class="relative md:hidden">
                <summary class="cursor-pointer list-none rounded-lg border border-white/20 px-4 py-2 text-sm">
                    Meni
                </summary>

                <div class="absolute right-0 top-12 flex w-60 flex-col gap-4 rounded-xl border border-white/10 bg-[#191a1d] p-5 text-sm shadow-2xl">
                    <a href="{{ url('/') }}">Početna</a>
                    <a href="{{ route('services.index') }}">Usluge</a>
                    <a href="{{ route('bookings.create') }}">Zakaži termin</a>

                    @auth
                        <a href="{{ route('bookings.index') }}">Moje rezervacije</a>

                        @can('manage-services')
                            <a href="{{ route('admin.slots.index') }}">Upravljanje terminima</a>
                            <a href="{{ route('admin.bookings.index') }}">Admin rezervacije</a>
                        @endcan

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="cursor-pointer">Odjava</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}">Prijava</a>
                        <a href="{{ route('register') }}">Registracija</a>
                    @endauth
                </div>
            </details>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="border-t border-white/10 bg-[#090a0c]">
        <div class="mx-auto flex max-w-7xl flex-col justify-between gap-6 px-6 py-10 text-sm text-stone-500 md:flex-row lg:px-10">
            <div>
                <p class="font-bold tracking-widest text-stone-200">
                    MAKEDONCE
                </p>
                <p class="mt-2">Precision. Style. Confidence.</p>
            </div>

            <div class="flex flex-wrap items-center gap-6">
                <a href="{{ url('/') }}" class="hover:text-white">Početna</a>
                <a href="{{ route('services.index') }}" class="hover:text-white">Usluge</a>
                <a href="{{ route('bookings.create') }}" class="hover:text-white">Rezervacije</a>
            </div>

            <p>© {{ now()->year }} MAKEDONCE Barber Studio</p>
        </div>
    </footer>

</body>
</html>
