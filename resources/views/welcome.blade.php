
@extends('layouts.app')

@section('title', 'MAKEDONCE | Premium Barber Studio')

@section('content')

<section class="relative overflow-hidden border-b border-white/10">
    <div class="pointer-events-none absolute -right-40 top-0 h-[600px] w-[600px] rounded-full bg-amber-600/10 blur-[130px]"></div>

    <div class="relative mx-auto grid min-h-[650px] max-w-7xl items-center gap-14 px-6 py-24 lg:grid-cols-2 lg:px-10">

        <div>
            <div class="mb-8 flex items-center gap-3">
                <span class="h-px w-10 bg-amber-400"></span>
                <span class="text-xs font-bold uppercase tracking-[0.35em] text-amber-400">
                    Premium Barber Experience
                </span>
            </div>

            <h1 class="max-w-2xl text-6xl font-black uppercase leading-[0.98] tracking-tight sm:text-7xl xl:text-8xl">
                YOUR CUT.
                <span class="mt-2 block text-amber-400">
                    YOUR STYLE.
                </span>
            </h1>

            <p class="mt-8 max-w-lg text-lg leading-8 text-stone-400">
                Precizno šišanje, pažljivo oblikovana brada i iskustvo koje se pamti.
                Izaberi svoje usluge, pronađi slobodan termin i rezerviši online.
            </p>

            <div class="mt-10 flex flex-wrap gap-4">
                <a href="{{ route('bookings.create') }}" class="rounded-lg bg-amber-500 px-8 py-4 text-sm font-bold text-neutral-950 transition hover:bg-amber-400">
                    Zakaži svoj termin
                </a>

                <a href="{{ route('services.index') }}" class="rounded-lg border border-white/20 px-8 py-4 text-sm font-bold transition hover:border-amber-400 hover:text-amber-400">
                    Pogledaj usluge
                </a>
            </div>

            <div class="mt-14 flex flex-wrap items-center gap-8 border-t border-white/10 pt-7">
                <div>
                    <span class="block text-2xl font-bold text-white">30 MIN</span>
                    <span class="text-xs uppercase tracking-widest text-stone-500">Termini</span>
                </div>

                <div class="h-10 w-px bg-white/10"></div>

                <div>
                    <span class="block text-2xl font-bold text-white">ONLINE</span>
                    <span class="text-xs uppercase tracking-widest text-stone-500">Rezervacije</span>
                </div>

                <div class="h-10 w-px bg-white/10"></div>

                <div>
                    <span class="block text-2xl font-bold text-white">YOUR WAY</span>
                    <span class="text-xs uppercase tracking-widest text-stone-500">Više usluga</span>
                </div>
            </div>
        </div>

        <div class="relative">
            <div class="absolute -inset-4 rounded-[2rem] border border-amber-500/10"></div>

            <div class="relative flex min-h-[480px] flex-col justify-between overflow-hidden rounded-2xl border border-amber-500/20 bg-gradient-to-br from-[#33302a] via-[#1b1b1b] to-[#0e0e0e] p-9 shadow-2xl sm:p-12">

                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-[0.3em] text-amber-400">
                        Est. 2026
                    </span>
                    <span class="rounded-full border border-white/15 px-4 py-2 text-[11px] uppercase tracking-widest text-stone-300">
                        Barber Studio
                    </span>
                </div>

                <div class="py-16">
                    <div class="mb-7 h-1 w-20 bg-amber-400"></div>

                    <p class="text-6xl font-black leading-none tracking-tighter text-white sm:text-8xl">
                        LOOK
                        <span class="block text-amber-400">SHARP.</span>
                    </p>

                    <p class="mt-7 max-w-xs text-sm leading-7 text-stone-400">
                        Great style starts with a great cut.
                    </p>
                </div>

                <div class="flex items-center justify-between border-t border-white/15 pt-6">
                    <span class="text-xs uppercase tracking-[0.3em] text-stone-400">
                        MAKEDONCE / STUDIO
                    </span>

                    <span class="text-2xl text-amber-400">✦</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-6 py-24 lg:px-10" id="services">
    <div class="mb-12 flex flex-col justify-between gap-6 md:flex-row md:items-end">
        <div>
            <p class="mb-4 text-xs font-bold uppercase tracking-[0.3em] text-amber-400">
                Our Services
            </p>

            <h2 class="text-4xl font-black uppercase tracking-tight sm:text-5xl">
                Usluge koje izdvajaju
            </h2>
        </div>

        <a href="{{ route('services.index') }}" class="text-sm font-semibold text-amber-400 hover:text-amber-300">
            Sve usluge →
        </a>
    </div>

    <div class="grid gap-5 md:grid-cols-3">
        @forelse ($services as $service)
            <article class="group flex min-h-64 flex-col justify-between rounded-xl border border-white/10 bg-[#17181b] p-7 transition hover:border-amber-500/50 hover:bg-[#1d1e21]">

                <div>
                    <div class="mb-8 flex h-11 w-11 items-center justify-center rounded-lg bg-amber-500/10 font-bold text-amber-400">
                        ✦
                    </div>

                    <h3 class="text-xl font-bold">
                        {{ $service->name }}
                    </h3>

                    <p class="mt-3 text-sm leading-7 text-stone-400">
                        {{ $service->description ?: 'Profesionalna usluga prilagođena tvom stilu.' }}
                    </p>
                </div>

                <div class="mt-8 flex items-end justify-between border-t border-white/10 pt-6">
                    <div>
                        <p class="text-xs uppercase tracking-widest text-stone-500">
                            Cena
                        </p>

                        <p class="mt-1 text-2xl font-bold text-amber-400">
                            {{ number_format($service->price, 0, ',', '.') }}
                            <span class="text-sm">RSD</span>
                        </p>
                    </div>

                    <a href="{{ route('bookings.create') }}" class="text-sm font-bold text-white transition group-hover:text-amber-400">
                        Zakaži →
                    </a>
                </div>
            </article>
        @empty
            <div class="rounded-xl border border-white/10 bg-[#17181b] p-8 text-stone-400 md:col-span-3">
                Usluge će uskoro biti dostupne.
            </div>
        @endforelse
    </div>
</section>

<section class="border-t border-white/10 bg-[#141518]">
    <div class="mx-auto max-w-7xl px-6 py-24 lg:px-10">

        <div class="mb-12 text-center">
            <p class="mb-4 text-xs font-bold uppercase tracking-[0.3em] text-amber-400">
                Simple Booking
            </p>

            <h2 class="text-4xl font-black uppercase tracking-tight">
                Tri koraka do termina
            </h2>
        </div>

        <div class="grid gap-5 md:grid-cols-3">
            <div class="rounded-xl border border-white/10 bg-[#1c1d20] p-8">
                <span class="text-4xl font-black text-amber-400">01</span>
                <h3 class="mt-7 text-xl font-bold">Izaberi usluge</h3>
                <p class="mt-3 text-sm leading-7 text-stone-400">
                    Odaberi jednu ili više usluga koje želiš.
                </p>
            </div>

            <div class="rounded-xl border border-white/10 bg-[#1c1d20] p-8">
                <span class="text-4xl font-black text-amber-400">02</span>
                <h3 class="mt-7 text-xl font-bold">Pronađi termin</h3>
                <p class="mt-3 text-sm leading-7 text-stone-400">
                    Izaberi jedan od dostupnih termina koje je salon otvorio.
                </p>
            </div>

            <div class="rounded-xl border border-white/10 bg-[#1c1d20] p-8">
                <span class="text-4xl font-black text-amber-400">03</span>
                <h3 class="mt-7 text-xl font-bold">Potvrdi rezervaciju</h3>
                <p class="mt-3 text-sm leading-7 text-stone-400">
                    Rezerviši online i pregledaj svoje termine u nalogu.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-6 py-24 text-center lg:px-10">
    <p class="mb-5 text-xs font-bold uppercase tracking-[0.35em] text-amber-400">
        Ready for a fresh look?
    </p>

    <h2 class="text-4xl font-black uppercase sm:text-6xl">
        Vreme je za novi stil.
    </h2>

    <p class="mx-auto mt-6 max-w-xl text-stone-400">
        Tvoj sledeći termin je na samo nekoliko klikova.
    </p>

    <a href="{{ route('bookings.create') }}" class="mt-9 inline-flex rounded-lg bg-amber-500 px-9 py-4 text-sm font-bold text-neutral-950 transition hover:bg-amber-400">
        Rezerviši sada
    </a>
</section>

@endsection
