
@extends('layouts.app')

@section('title', 'Upravljanje terminima | MAKEDONCE')

@section('content')

@php
    $reservedCount = $slots->filter(fn ($slot) => $slot->is_reserved)->count();
    $closedCount = $slots->filter(fn ($slot) => !$slot->is_open && !$slot->is_reserved)->count();
    $availableCount = $slots->count() - $reservedCount - $closedCount;
@endphp

<section class="relative overflow-hidden border-b border-white/10 bg-[#111214]">
    <div class="absolute right-0 top-0 h-72 w-72 rounded-full bg-amber-500/10 blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl px-6 py-16 lg:px-10 lg:py-20">
        <div class="mb-5 flex items-center gap-3">
            <span class="h-px w-8 bg-amber-400"></span>
            <span class="text-xs font-bold uppercase tracking-[0.3em] text-amber-400">
                Makedonce / Administration
            </span>
        </div>

        <div class="flex flex-col justify-between gap-6 lg:flex-row lg:items-end">
            <div>
                <h1 class="text-4xl font-black uppercase tracking-tight text-white sm:text-5xl">
                    Upravljanje <span class="text-amber-400">terminima.</span>
                </h1>

                <p class="mt-5 max-w-xl leading-7 text-stone-400">
                    Objavljuj slobodne termine, prati rezervacije i upravljaj dostupnošću salona.
                </p>
            </div>

            <a
                href="{{ route('admin.bookings.index') }}"
                class="inline-flex items-center justify-center rounded-xl border border-amber-500/30 px-6 py-4 text-sm font-bold text-amber-400 transition hover:bg-amber-500/10"
            >
                Pregled svih rezervacija →
            </a>
        </div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-6 py-12 lg:px-10 lg:py-16">

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

    @if ($errors->any())
        <div role="alert" class="mb-8 rounded-xl border border-red-500/30 bg-red-500/10 p-5">
            <p class="mb-3 font-bold text-red-300">Proveri podatke:</p>

            <ul class="list-inside list-disc space-y-2 text-sm text-red-200">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-10 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

        <div class="rounded-2xl border border-white/10 bg-[#17181b] p-6">
            <p class="text-sm text-stone-400">Ukupno termina</p>
            <p class="mt-4 text-4xl font-black text-white">
                {{ $slots->count() }}
            </p>
        </div>

        <div class="rounded-2xl border border-emerald-500/20 bg-[#17181b] p-6">
            <p class="text-sm text-stone-400">Slobodni</p>
            <p class="mt-4 text-4xl font-black text-emerald-400">
                {{ $availableCount }}
            </p>
        </div>

        <div class="rounded-2xl border border-amber-500/20 bg-[#17181b] p-6">
            <p class="text-sm text-stone-400">Rezervisani</p>
            <p class="mt-4 text-4xl font-black text-amber-400">
                {{ $reservedCount }}
            </p>
        </div>

        <div class="rounded-2xl border border-red-500/20 bg-[#17181b] p-6">
            <p class="text-sm text-stone-400">Zatvoreni</p>
            <p class="mt-4 text-4xl font-black text-red-400">
                {{ $closedCount }}
            </p>
        </div>

    </div>

    <div class="grid items-start gap-8 lg:grid-cols-[380px_minmax(0,1fr)]">

        <div class="rounded-2xl border border-white/10 bg-[#17181b] p-6 lg:sticky lg:top-28">

            <div class="mb-7 flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-500/10 text-2xl font-bold text-amber-400">
                    +
                </div>

                <div>
                    <h2 class="text-xl font-bold text-white">
                        Objavi termine
                    </h2>

                    <p class="mt-1 text-sm text-stone-400">
                        Dodaj slobodne termine za odabrani dan.
                    </p>
                </div>
            </div>

            <form action="{{ route('admin.slots.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="date" class="mb-3 block text-sm font-semibold text-stone-200">
                        Datum
                    </label>

                    <input
                        type="date"
                        id="date"
                        name="date"
                        value="{{ old('date', now()->format('Y-m-d')) }}"
                        min="{{ now()->format('Y-m-d') }}"
                        required
                        class="w-full rounded-xl border border-white/10 bg-[#202124] px-4 py-4 text-white outline-none transition focus:border-amber-400 [color-scheme:dark]"
                    >
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="start_time" class="mb-3 block text-sm font-semibold text-stone-200">
                            Od
                        </label>

                        <input
                            type="time"
                            id="start_time"
                            name="start_time"
                            value="{{ old('start_time', '09:00') }}"
                            step="1800"
                            required
                            class="w-full rounded-xl border border-white/10 bg-[#202124] px-3 py-4 text-white outline-none transition focus:border-amber-400 [color-scheme:dark]"
                        >
                    </div>

                    <div>
                        <label for="end_time" class="mb-3 block text-sm font-semibold text-stone-200">
                            Do
                        </label>

                        <input
                            type="time"
                            id="end_time"
                            name="end_time"
                            value="{{ old('end_time', '17:00') }}"
                            step="1800"
                            required
                            class="w-full rounded-xl border border-white/10 bg-[#202124] px-3 py-4 text-white outline-none transition focus:border-amber-400 [color-scheme:dark]"
                        >
                    </div>
                </div>

                <div class="rounded-xl border border-amber-500/15 bg-amber-500/5 p-5">
                    <p class="text-sm font-bold text-amber-400">
                        Automatsko kreiranje
                    </p>

                    <p class="mt-3 text-xs leading-6 text-stone-400">
                        Sistem kreira termine u intervalima od 30 minuta.
                        Postojeće rezervacije neće biti prebrisane.
                    </p>
                </div>

                <button
                    type="submit"
                    class="w-full cursor-pointer rounded-xl bg-amber-500 px-6 py-4 text-sm font-black uppercase tracking-wide text-neutral-950 transition hover:bg-amber-400"
                >
                    + Objavi slobodne termine
                </button>
            </form>
        </div>

        <div class="rounded-2xl border border-white/10 bg-[#17181b] p-6 sm:p-8">

            <div class="mb-8">
                <p class="text-xs font-bold uppercase tracking-[0.25em] text-amber-400">
                    Appointment Schedule
                </p>

                <h2 class="mt-3 text-2xl font-bold text-white">
                    Raspored termina
                </h2>

                <p class="mt-2 text-sm text-stone-400">
                    Pregled budućih termina i njihove dostupnosti.
                </p>
            </div>

            @forelse ($slots->groupBy(fn ($slot) => $slot->start_at->format('Y-m-d')) as $date => $daySlots)

                <div class="mb-9 last:mb-0">

                    <div class="mb-5 flex items-center gap-4">
                        <h3 class="shrink-0 text-sm font-bold text-amber-400">
                            {{ $daySlots->first()->start_at->format('d.m.Y.') }}
                        </h3>

                        <div class="h-px flex-1 bg-white/10"></div>

                        <span class="text-xs text-stone-500">
                            {{ $daySlots->count() }} termina
                        </span>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2">

                        @foreach ($daySlots as $slot)
                            <div class="rounded-xl border border-white/10 bg-[#202124] p-5">

                                <div class="mb-5 flex items-center justify-between gap-3">
                                    <div>
                                        <p class="text-xs text-stone-500">
                                            Vreme
                                        </p>

                                        <p class="mt-2 text-xl font-black text-white">
                                            {{ $slot->start_at->format('H:i') }}
                                            <span class="text-sm font-medium text-stone-500">
                                                –
                                                {{ $slot->start_at->copy()->addMinutes(30)->format('H:i') }}
                                            </span>
                                        </p>
                                    </div>

                                    @if ($slot->is_reserved)
                                        <span class="rounded-full border border-amber-500/30 bg-amber-500/10 px-3 py-2 text-xs font-bold text-amber-400">
                                            Rezervisan
                                        </span>
                                    @elseif ($slot->is_open)
                                        <span class="rounded-full border border-emerald-500/30 bg-emerald-500/10 px-3 py-2 text-xs font-bold text-emerald-400">
                                            Slobodan
                                        </span>
                                    @else
                                        <span class="rounded-full border border-red-500/30 bg-red-500/10 px-3 py-2 text-xs font-bold text-red-400">
                                            Zatvoren
                                        </span>
                                    @endif
                                </div>

                                @if ($slot->is_open && !$slot->is_reserved)
                                    <form
                                        action="{{ route('admin.slots.close', $slot) }}"
                                        method="POST"
                                        onsubmit="return confirm('Da li želiš da zatvoriš ovaj termin?')"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="w-full cursor-pointer rounded-lg border border-red-500/30 px-4 py-3 text-xs font-bold text-red-400 transition hover:bg-red-500/10"
                                        >
                                            Zatvori termin
                                        </button>
                                    </form>
                                @else
                                    <div class="rounded-lg border border-white/5 bg-white/[0.02] px-4 py-3 text-center text-xs text-stone-500">
                                        {{ $slot->is_reserved ? 'Termin je zauzet' : 'Termin nije dostupan' }}
                                    </div>
                                @endif

                            </div>
                        @endforeach

                    </div>
                </div>

            @empty
                <div class="rounded-xl border border-dashed border-white/15 p-12 text-center">
                    <div class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-xl bg-amber-500/10 text-2xl text-amber-400">
                        ◷
                    </div>

                    <h3 class="text-lg font-bold text-white">
                        Još nema objavljenih termina
                    </h3>

                    <p class="mt-3 text-sm leading-7 text-stone-400">
                        Izaberi datum i radno vreme da napraviš prve slobodne termine.
                    </p>
                </div>
            @endforelse

        </div>
    </div>

</section>

@endsection
