@extends('layouts.app')

@section('title', 'Naše usluge | MAKEDONCE')

@section('content')

<section class="relative overflow-hidden border-b border-white/10 bg-[#111214]">
    <div class="pointer-events-none absolute right-0 top-0 h-72 w-72 rounded-full bg-amber-500/10 blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl px-6 py-16 lg:px-10 lg:py-24">
        <div class="mb-6 flex items-center gap-3">
            <span class="h-px w-10 bg-amber-400"></span>
            <span class="text-xs font-bold uppercase tracking-[0.3em] text-amber-400">
                Makedonce / Our Services
            </span>
        </div>

        <div class="flex flex-col justify-between gap-8 lg:flex-row lg:items-end">
            <div>
                <h1 class="text-4xl font-black uppercase tracking-tight sm:text-6xl">
                    Naše <span class="text-amber-400">usluge.</span>
                </h1>

                <p class="mt-6 max-w-xl text-base leading-8 text-stone-400">
                    Svaki detalj je važan. Izaberi profesionalne barber usluge
                    koje odgovaraju tvom stilu i rezerviši termin online.
                </p>
            </div>

            @can('manage-services')
                <a
                    href="{{ route('services.create') }}"
                    class="inline-flex items-center justify-center rounded-xl bg-amber-500 px-7 py-4 text-sm font-bold text-neutral-950 transition hover:bg-amber-400"
                >
                    + Dodaj novu uslugu
                </a>
            @endcan
        </div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-6 py-12 lg:px-10 lg:py-20">

    @if (session('success'))
        <div role="status" class="mb-8 rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-5 text-sm text-emerald-300">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div role="alert" class="mb-8 rounded-xl border border-red-500/30 bg-red-500/10 p-5 text-sm text-red-300">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-10 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.25em] text-amber-400">
                Premium Experience
            </p>

            <h2 class="mt-3 text-2xl font-bold text-white">
                Izaberi svoj stil
            </h2>
        </div>

        <div class="w-fit rounded-full border border-white/10 bg-white/5 px-5 py-2 text-sm text-stone-400">
            {{ $services->count() }}
            {{ $services->count() === 1 ? 'usluga' : 'usluga' }}
        </div>
    </div>

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">

        @forelse ($services as $service)
            <article class="group flex flex-col overflow-hidden rounded-2xl border border-white/10 bg-[#17181b] transition duration-300 hover:-translate-y-1 hover:border-amber-500/40 hover:shadow-xl hover:shadow-amber-500/5">

                <div class="relative border-b border-white/10 bg-gradient-to-br from-[#30291f] via-[#212123] to-[#17181b] p-8">
                    <div class="flex items-start justify-between">
                        <div class="flex h-14 w-14 items-center justify-center rounded-xl border border-amber-500/20 bg-amber-500/10 text-3xl text-amber-400">
                            ✦
                        </div>

                        <span class="rounded-full border border-amber-500/20 bg-amber-500/10 px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-amber-400">
                            Barber Service
                        </span>
                    </div>

                    <div class="mt-16">
                        <p class="mb-3 text-xs font-semibold uppercase tracking-[0.25em] text-amber-400">
                            Makedonce Studio
                        </p>

                        <h3 class="text-2xl font-black text-white">
                            {{ $service->name }}
                        </h3>
                    </div>
                </div>

                <div class="flex flex-1 flex-col p-7">

                    <p class="min-h-16 text-sm leading-7 text-stone-400">
                        {{ $service->description ?: 'Profesionalna usluga prilagođena tvom stilu i željama.' }}
                    </p>

                    <div class="mt-7 flex items-center justify-between border-t border-white/10 pt-6">
                        <div>
                            <p class="text-xs uppercase tracking-widest text-stone-500">
                                Cena usluge
                            </p>

                            <p class="mt-2 text-3xl font-black text-amber-400">
                                {{ number_format($service->price, 0, ',', '.') }}
                                <span class="text-sm font-semibold">RSD</span>
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="text-xs text-stone-500">
                                Zakazivanje
                            </p>

                            <p class="mt-2 text-sm font-semibold text-white">
                                Online
                            </p>
                        </div>
                    </div>

                    <a
                        href="{{ route('bookings.create') }}"
                        class="mt-7 flex items-center justify-center rounded-xl bg-amber-500 px-6 py-4 text-sm font-bold text-neutral-950 transition hover:bg-amber-400"
                    >
                        Zakaži termin
                        <span class="ml-2">→</span>
                    </a>

                    @can('manage-services')
                        <div class="mt-5 flex flex-wrap items-center justify-between gap-3 border-t border-white/10 pt-5">

                            <a
                                href="{{ route('services.edit', $service) }}"
                                class="rounded-lg border border-white/15 px-5 py-3 text-sm font-semibold text-stone-300 transition hover:border-amber-400 hover:text-amber-400"
                            >
                                Izmeni
                            </a>

                            <form
                                action="{{ route('services.destroy', $service) }}"
                                method="POST"
                                onsubmit="return confirm('Da li sigurno želiš da obrišeš ovu uslugu?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="cursor-pointer rounded-lg border border-red-500/30 px-5 py-3 text-sm font-semibold text-red-400 transition hover:border-red-500 hover:bg-red-500/10"
                                >
                                    Obriši
                                </button>
                            </form>
                        </div>
                    @endcan

                </div>
            </article>

        @empty
            <div class="rounded-2xl border border-dashed border-white/15 bg-[#17181b] px-6 py-20 text-center md:col-span-2 xl:col-span-3">
                <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-amber-500/10 text-3xl text-amber-400">
                    ✦
                </div>

                <h3 class="text-2xl font-bold text-white">
                    Trenutno nema dostupnih usluga
                </h3>

                <p class="mx-auto mt-4 max-w-md text-sm leading-7 text-stone-400">
                    Naš katalog usluga trenutno nije dostupan.
                    Poseti nas ponovo uskoro.
                </p>

                @can('manage-services')
                    <a
                        href="{{ route('services.create') }}"
                        class="mt-8 inline-flex rounded-xl bg-amber-500 px-7 py-4 text-sm font-bold text-neutral-950 transition hover:bg-amber-400"
                    >
                        Dodaj prvu uslugu
                    </a>
                @endcan
            </div>
        @endforelse
    </div>

</section>

<section class="border-t border-white/10 bg-[#141518]">
    <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-8 px-6 py-16 lg:flex-row lg:items-center lg:px-10">

        <div>
            <p class="mb-3 text-xs font-bold uppercase tracking-[0.3em] text-amber-400">
                Your Next Appointment
            </p>

            <h2 class="text-3xl font-black uppercase text-white sm:text-4xl">
                Spreman za novi izgled?
            </h2>

            <p class="mt-4 max-w-lg leading-7 text-stone-400">
                Izaberi usluge, pronađi slobodan termin i rezerviši svoj dolazak.
            </p>
        </div>

        <a
            href="{{ route('bookings.create') }}"
            class="inline-flex shrink-0 rounded-xl bg-amber-500 px-8 py-4 text-sm font-bold text-neutral-950 transition hover:bg-amber-400"
        >
            Rezerviši sada →
        </a>

    </div>
</section>

@endsection
