@extends('layouts.app')

@section('title', 'Moje rezervacije | MAKEDONCE')

@section('content')

<section class="border-b border-white/10 bg-[#111214]">
    <div class="mx-auto max-w-7xl px-6 py-16 lg:px-10 lg:py-20">

        <div class="mb-5 flex items-center gap-3">
            <span class="h-px w-8 bg-amber-400"></span>
            <span class="text-xs font-bold uppercase tracking-[0.3em] text-amber-400">
                My Appointments
            </span>
        </div>

        <div class="flex flex-col justify-between gap-8 md:flex-row md:items-end">
            <div>
                <h1 class="text-4xl font-black uppercase tracking-tight sm:text-6xl">
                    Moje <span class="text-amber-400">rezervacije.</span>
                </h1>

                <p class="mt-5 max-w-xl text-stone-400">
                    Pregledaj svoje termine, izabrane usluge i upravljaj rezervacijama.
                </p>
            </div>

            <a
                href="{{ route('bookings.create') }}"
                class="inline-flex items-center justify-center rounded-xl bg-amber-500 px-7 py-4 text-sm font-bold text-neutral-950 transition hover:bg-amber-400"
            >
                + Zakaži novi termin
            </a>
        </div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-6 py-12 lg:px-10 lg:py-16">

    @if (session('success'))
        <div
            role="status"
            class="mb-8 rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-5 text-sm text-emerald-300"
        >
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div
            role="alert"
            class="mb-8 rounded-xl border border-red-500/30 bg-red-500/10 p-5 text-sm text-red-300"
        >
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-10 grid gap-4 sm:grid-cols-2">
        <div class="rounded-2xl border border-white/10 bg-[#17181b] p-7">
            <p class="text-sm text-stone-400">
                Ukupno rezervacija
            </p>

            <p class="mt-4 text-4xl font-black text-white">
                {{ $bookings->count() }}
            </p>
        </div>

        <div class="rounded-2xl border border-amber-500/20 bg-[#17181b] p-7">
            <p class="text-sm text-stone-400">
                Potvrđene rezervacije
            </p>

            <p class="mt-4 text-4xl font-black text-amber-400">
                {{ $bookings->where('status', 'confirmed')->count() }}
            </p>
        </div>
    </div>

    <div class="mb-7 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-white">
            Istorija rezervacija
        </h2>
    </div>

    <div class="space-y-6">
        @forelse ($bookings as $booking)

            <article class="overflow-hidden rounded-2xl border border-white/10 bg-[#17181b] transition hover:border-white/20">

                <div class="flex flex-col justify-between gap-4 border-b border-white/10 p-6 sm:flex-row sm:items-center sm:p-8">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-stone-500">
                            MAKEDONCE BOOKING
                        </p>

                        <h3 class="mt-2 text-xl font-bold text-white">
                            Rezervacija #{{ $booking->id }}
                        </h3>
                    </div>

                    @if ($booking->status === 'confirmed')
                        <span class="inline-flex w-fit items-center gap-2 rounded-full border border-emerald-500/30 bg-emerald-500/10 px-4 py-2 text-xs font-bold text-emerald-400">
                            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                            Potvrđena
                        </span>
                    @elseif (in_array($booking->status, ['cancelled', 'canceled']))
                        <span class="inline-flex w-fit items-center gap-2 rounded-full border border-red-500/30 bg-red-500/10 px-4 py-2 text-xs font-bold text-red-400">
                            <span class="h-2 w-2 rounded-full bg-red-400"></span>
                            Otkazana
                        </span>
                    @else
                        <span class="inline-flex w-fit rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-bold text-stone-300">
                            {{ $booking->status }}
                        </span>
                    @endif

                </div>

                <div class="grid gap-8 p-6 sm:p-8 lg:grid-cols-2">

                    <div>
                        <p class="mb-5 text-xs font-bold uppercase tracking-[0.2em] text-amber-400">
                            Datum i vreme
                        </p>

                        <div class="rounded-xl border border-white/10 bg-[#202124] p-5">
                            <p class="text-sm text-stone-400">
                                Datum
                            </p>

                            <p class="mt-2 text-lg font-bold text-white">
                                {{ $booking->start_at->format('d.m.Y.') }}
                            </p>

                            <div class="my-5 border-t border-white/10"></div>

                            <p class="text-sm text-stone-400">
                                Vreme
                            </p>

                            <p class="mt-2 text-lg font-bold text-white">
                                {{ $booking->start_at->format('H:i') }}
                                –
                                {{ $booking->end_at->format('H:i') }}
                            </p>

                            <p class="mt-2 text-xs text-stone-500">
                                Trajanje: 30 minuta
                            </p>
                        </div>
                    </div>

                    <div>
                        <p class="mb-5 text-xs font-bold uppercase tracking-[0.2em] text-amber-400">
                            Izabrane usluge
                        </p>

                        <div class="space-y-4">
                            @forelse ($booking->services as $service)
                                <div class="flex items-start justify-between gap-4">
                                    <span class="text-sm text-stone-300">
                                        {{ $service->name }}
                                    </span>

                                    <span class="shrink-0 text-sm font-semibold text-white">
                                        {{ number_format($service->pivot->price_at_booking, 0, ',', '.') }} RSD
                                    </span>
                                </div>
                            @empty
                                <p class="text-sm text-stone-500">
                                    Nema povezanih usluga.
                                </p>
                            @endforelse
                        </div>

                        <div class="mt-7 flex items-center justify-between gap-4 border-t border-white/10 pt-6">
                            <span class="font-bold text-white">
                                Ukupna cena
                            </span>

                            <span class="text-2xl font-black text-amber-400">
                                {{ number_format($booking->services->sum(fn ($service) => (float) $service->pivot->price_at_booking), 0, ',', '.') }} RSD
                            </span>
                        </div>
                    </div>
                </div>

                @if ($booking->status === 'confirmed')
                    <div class="flex flex-col justify-between gap-4 border-t border-white/10 bg-white/[0.02] px-6 py-5 sm:flex-row sm:items-center sm:px-8">
                        <p class="text-xs text-stone-500">
                            Želiš da otkažeš svoju rezervaciju?
                        </p>

                        <form
                            action="{{ route('bookings.cancel', $booking) }}"
                            method="POST"
                            onsubmit="return confirm('Da li sigurno želiš da otkažeš rezervaciju?')"
                        >
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                class="w-full cursor-pointer rounded-lg border border-red-500/30 px-6 py-3 text-sm font-semibold text-red-400 transition hover:border-red-500 hover:bg-red-500/10 sm:w-auto"
                            >
                                Otkaži rezervaciju
                            </button>
                        </form>
                    </div>
                @endif

            </article>

        @empty

            <div class="rounded-2xl border border-dashed border-white/15 bg-[#17181b] px-6 py-20 text-center">
                <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-amber-500/10 text-3xl text-amber-400">
                    ✦
                </div>

                <h3 class="text-2xl font-bold text-white">
                    Još nemaš rezervacija
                </h3>

                <p class="mx-auto mt-4 max-w-md text-sm leading-7 text-stone-400">
                    Izaberi svoje omiljene usluge i zakaži prvi termin u MAKEDONCE studiju.
                </p>

                <a
                    href="{{ route('bookings.create') }}"
                    class="mt-8 inline-flex rounded-xl bg-amber-500 px-8 py-4 text-sm font-bold text-neutral-950 transition hover:bg-amber-400"
                >
                    Zakaži prvi termin
                </a>
            </div>

        @endforelse
    </div>

    <div class="mt-12">
        <a
            href="{{ route('services.index') }}"
            class="text-sm font-medium text-stone-400 transition hover:text-amber-400"
        >
            ← Nazad na usluge
        </a>
    </div>

</section>

@endsection
