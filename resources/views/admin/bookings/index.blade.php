@extends('layouts.app')

@section('title', 'Dnevni raspored | MAKEDONCE')

@section('content')

<section class="relative overflow-hidden border-b border-white/10 bg-[#111214]">
    <div class="absolute right-0 top-0 h-72 w-72 rounded-full bg-amber-500/10 blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl px-6 py-14 lg:px-10 lg:py-20">

        <div class="mb-5 flex items-center gap-3">
            <span class="h-px w-8 bg-amber-400"></span>
            <span class="text-xs font-bold uppercase tracking-[0.3em] text-amber-400">
                Makedonce / Admin Schedule
            </span>
        </div>

        <div class="flex flex-col justify-between gap-6 lg:flex-row lg:items-end">

            <div>
                <h1 class="text-4xl font-black uppercase tracking-tight text-white sm:text-5xl">
                    Dnevni <span class="text-amber-400">raspored.</span>
                </h1>

                <p class="mt-5 max-w-xl leading-7 text-stone-400">
                    Pregledaj sve rezervacije po danima i satnici.
                    Klikni na rezervaciju da vidiš detalje klijenta i usluga.
                </p>
            </div>

            <a
                href="{{ route('admin.slots.index') }}"
                class="inline-flex items-center justify-center rounded-xl border border-amber-500/30 px-6 py-4 text-sm font-bold text-amber-400 transition hover:bg-amber-500/10"
            >
                Upravljanje terminima →
            </a>

        </div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-6 py-10 lg:px-10 lg:py-14">

    <div class="rounded-2xl border border-white/10 bg-[#17181b] p-5 sm:p-7">

        <div class="mb-7 flex flex-col justify-between gap-5 sm:flex-row sm:items-center">

            <div>
                <p class="text-xs font-bold uppercase tracking-[0.25em] text-amber-400">
                    Calendar
                </p>

                <h2 class="mt-2 text-xl font-bold text-white">
                    {{ $selectedDay->format('d.m.Y.') }}
                </h2>
            </div>

            <form
                action="{{ route('admin.bookings.index') }}"
                method="GET"
                class="flex flex-wrap items-center gap-3"
            >
                <input
                    type="date"
                    name="date"
                    value="{{ $selectedDay->format('Y-m-d') }}"
                    aria-label="Izaberi datum"
                    required
                    class="rounded-xl border border-white/10 bg-[#202124] px-4 py-3 text-sm text-white outline-none transition focus:border-amber-400 [color-scheme:dark]"
                >

                <button
                    type="submit"
                    class="cursor-pointer rounded-xl bg-amber-500 px-5 py-3 text-sm font-bold text-neutral-950 transition hover:bg-amber-400"
                >
                    Prikaži
                </button>
            </form>
        </div>

        <div class="mb-5 flex flex-wrap items-center justify-between gap-3">

            <a
                href="{{ route('admin.bookings.index', ['date' => $selectedDay->copy()->subWeek()->toDateString()]) }}"
                class="rounded-lg border border-white/10 px-4 py-2 text-xs font-semibold text-stone-300 transition hover:border-amber-400 hover:text-amber-400"
            >
                ← Prethodna nedelja
            </a>

            <a
                href="{{ route('admin.bookings.index') }}"
                class="rounded-lg border border-amber-500/30 bg-amber-500/10 px-4 py-2 text-xs font-bold text-amber-400 transition hover:bg-amber-500/20"
            >
                Danas
            </a>

            <a
                href="{{ route('admin.bookings.index', ['date' => $selectedDay->copy()->addWeek()->toDateString()]) }}"
                class="rounded-lg border border-white/10 px-4 py-2 text-xs font-semibold text-stone-300 transition hover:border-amber-400 hover:text-amber-400"
            >
                Sledeća nedelja →
            </a>

        </div>

        <div class="flex gap-2 overflow-x-auto pb-2">

            @foreach ($weekDays as $index => $day)

                <a
                    href="{{ route('admin.bookings.index', ['date' => $day->toDateString()]) }}"
                    class="flex min-w-[78px] flex-1 flex-col items-center rounded-xl border px-2 py-4 text-center transition {{ $day->isSameDay($selectedDay) ? 'border-amber-400 bg-amber-500/10 text-amber-400' : 'border-white/10 bg-[#202124] text-stone-300 hover:border-amber-500/40' }}"
                >

                    <span class="text-xs font-semibold uppercase">
                        {{ ['Pon', 'Uto', 'Sre', 'Čet', 'Pet', 'Sub', 'Ned'][$index] }}
                    </span>

                    <span class="mt-2 text-2xl font-black">
                        {{ $day->format('d') }}
                    </span>

                    <span class="mt-3 rounded-full bg-white/10 px-3 py-1 text-xs font-bold">
                        {{ $weekCounts->get($day->format('Y-m-d'), 0) }}
                    </span>

                </a>

            @endforeach

        </div>

    </div>

    <div class="mt-7 grid gap-4 sm:grid-cols-3">

        <div class="rounded-2xl border border-white/10 bg-[#17181b] p-6">
            <p class="text-sm text-stone-400">
                Ukupno za izabrani dan
            </p>

            <p class="mt-4 text-4xl font-black text-white">
                {{ $bookings->count() }}
            </p>
        </div>

        <div class="rounded-2xl border border-emerald-500/20 bg-[#17181b] p-6">
            <p class="text-sm text-stone-400">
                Potvrđene
            </p>

            <p class="mt-4 text-4xl font-black text-emerald-400">
                {{ $confirmedCount }}
            </p>
        </div>

        <div class="rounded-2xl border border-red-500/20 bg-[#17181b] p-6">
            <p class="text-sm text-stone-400">
                Otkazane
            </p>

            <p class="mt-4 text-4xl font-black text-red-400">
                {{ $cancelledCount }}
            </p>
        </div>

    </div>

    <div class="mt-12">

        <div class="mb-8 flex flex-col justify-between gap-3 sm:flex-row sm:items-end">

            <div>
                <p class="text-xs font-bold uppercase tracking-[0.25em] text-amber-400">
                    Appointments
                </p>

                <h2 class="mt-3 text-2xl font-bold text-white">
                    Rezervacije za {{ $selectedDay->format('d.m.Y.') }}
                </h2>
            </div>

            <p class="text-sm text-stone-500">
                Hronološki raspored
            </p>

        </div>

        @if ($bookings->isNotEmpty())

            <div class="ml-2 space-y-4 border-l border-white/10 pl-6 sm:pl-8">

                @foreach ($bookings as $booking)

                    @php
                        $total = $booking->services->sum(
                            fn ($service) => (float) $service->pivot->price_at_booking
                        );
                    @endphp

                    <div class="relative">

                        <span class="absolute -left-[31px] top-8 h-3 w-3 rounded-full border-2 border-amber-400 bg-[#17181b] sm:-left-[39px]"></span>

                        <details class="group overflow-hidden rounded-2xl border border-white/10 bg-[#17181b] transition hover:border-amber-500/30">

                            <summary class="flex cursor-pointer list-none flex-col gap-4 p-5 sm:flex-row sm:items-center sm:gap-6 sm:p-6 [&::-webkit-details-marker]:hidden">

                                <div class="shrink-0 sm:w-28">
                                    <p class="text-xl font-black text-amber-400">
                                        {{ $booking->start_at->format('H:i') }}
                                    </p>

                                    <p class="mt-1 text-xs text-stone-500">
                                        do {{ $booking->end_at->format('H:i') }}
                                    </p>
                                </div>

                                <div class="min-w-0 flex-1">

                                    <h3 class="text-base font-bold text-white">
                                        {{ $booking->user?->name ?? 'Nepoznat klijent' }}
                                    </h3>

                                    <p class="mt-2 text-sm leading-6 text-stone-400">
                                        {{ $booking->services->pluck('name')->implode(' · ') ?: 'Nema povezanih usluga' }}
                                    </p>

                                    <p class="mt-2 text-xs text-stone-500">
                                        Rezervacija #{{ $booking->id }}
                                    </p>

                                </div>

                                <div class="flex shrink-0 flex-wrap items-center gap-3 sm:justify-end">

                                    <span class="text-base font-bold text-amber-400">
                                        {{ number_format($total, 0, ',', '.') }} RSD
                                    </span>

                                    @if ($booking->status === 'confirmed')

                                        <span class="rounded-full border border-emerald-500/30 bg-emerald-500/10 px-3 py-2 text-xs font-bold text-emerald-400">
                                            Potvrđena
                                        </span>

                                    @elseif (in_array($booking->status, ['cancelled', 'canceled']))

                                        <span class="rounded-full border border-red-500/30 bg-red-500/10 px-3 py-2 text-xs font-bold text-red-400">
                                            Otkazana
                                        </span>

                                    @else

                                        <span class="rounded-full border border-white/10 bg-white/5 px-3 py-2 text-xs font-bold text-stone-300">
                                            {{ $booking->status }}
                                        </span>

                                    @endif

                                    <span class="text-xl text-stone-500 transition-transform group-open:rotate-180">
                                        ⌄
                                    </span>

                                </div>

                            </summary>

                            <div class="border-t border-white/10 bg-[#202124]/50 p-5 sm:p-6">

                                <div class="grid gap-8 md:grid-cols-2">

                                    <div>

                                        <p class="mb-5 text-xs font-bold uppercase tracking-[0.2em] text-amber-400">
                                            Informacije o klijentu
                                        </p>

                                        <div class="space-y-4">

                                            <div>
                                                <p class="text-xs text-stone-500">
                                                    Ime i prezime
                                                </p>

                                                <p class="mt-1 font-semibold text-white">
                                                    {{ $booking->user?->name ?? 'Nepoznat klijent' }}
                                                </p>
                                            </div>

                                            <div>
                                                <p class="text-xs text-stone-500">
                                                    Email adresa
                                                </p>

                                                <p class="mt-1 break-all text-sm text-stone-300">
                                                    {{ $booking->user?->email ?? 'Nije dostupno' }}
                                                </p>
                                            </div>

                                            <div>
                                                <p class="text-xs text-stone-500">
                                                    Datum i vreme
                                                </p>

                                                <p class="mt-1 text-sm font-semibold text-white">
                                                    {{ $booking->start_at->format('d.m.Y. H:i') }}
                                                    –
                                                    {{ $booking->end_at->format('H:i') }}
                                                </p>
                                            </div>

                                        </div>
                                    </div>

                                    <div>

                                        <p class="mb-5 text-xs font-bold uppercase tracking-[0.2em] text-amber-400">
                                            Detalji usluga
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

                                        <div class="mt-6 flex items-center justify-between border-t border-white/10 pt-5">

                                            <span class="font-bold text-white">
                                                Ukupna cena
                                            </span>

                                            <span class="text-xl font-black text-amber-400">
                                                {{ number_format($total, 0, ',', '.') }} RSD
                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </details>

                    </div>

                @endforeach

            </div>

        @else

            <div class="rounded-2xl border border-dashed border-white/15 bg-[#17181b] px-6 py-16 text-center">

                <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-amber-500/10 text-3xl text-amber-400">
                    ◷
                </div>

                <h3 class="text-xl font-bold text-white">
                    Nema rezervacija za ovaj dan
                </h3>

                <p class="mx-auto mt-4 max-w-md text-sm leading-7 text-stone-400">
                    Za izabrani datum nema evidentiranih rezervacija.
                    Izaberi drugi dan iz kalendara.
                </p>

            </div>

        @endif

    </div>

</section>

@endsection
