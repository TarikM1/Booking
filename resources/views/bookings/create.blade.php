
@extends('layouts.app')

@section('title', 'Zakaži termin | MAKEDONCE')

@section('content')

<section class="relative overflow-hidden border-b border-white/10 bg-[#111214]">
    <div class="absolute right-0 top-0 h-64 w-64 rounded-full bg-amber-500/10 blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl px-6 py-16 lg:px-10 lg:py-20">
        <div class="mb-5 flex items-center gap-3">
            <span class="h-px w-8 bg-amber-400"></span>
            <span class="text-xs font-bold uppercase tracking-[0.3em] text-amber-400">
                Online Booking
            </span>
        </div>

        <h1 class="text-4xl font-black uppercase tracking-tight sm:text-6xl">
            Zakaži svoj <span class="text-amber-400">termin.</span>
        </h1>

        <p class="mt-5 max-w-2xl text-base leading-7 text-stone-400">
            Izaberi usluge koje želiš, pronađi slobodan termin i potvrdi rezervaciju za nekoliko trenutaka.
        </p>
    </div>
</section>

<section class="mx-auto max-w-7xl px-6 py-12 lg:px-10 lg:py-16">

    @if ($errors->any())
        <div role="alert" class="mb-8 rounded-xl border border-red-500/30 bg-red-500/10 p-5 text-red-200">
            <p class="mb-3 font-bold">Proveri sledeće podatke:</p>

            <ul class="list-inside list-disc space-y-2 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('bookings.store') }}"
        method="POST"
        id="booking-form"
        class="grid items-start gap-8 lg:grid-cols-[minmax(0,1fr)_360px]"
    >
        @csrf

        <div class="space-y-8">

            <div class="rounded-2xl border border-white/10 bg-[#17181b] p-6 sm:p-8">
                <div class="mb-8 flex items-start gap-4">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-500 font-black text-neutral-950">
                        01
                    </div>

                    <div>
                        <h2 class="text-2xl font-bold">
                            Izaberi usluge
                        </h2>

                        <p class="mt-2 text-sm text-stone-400">
                            Možeš izabrati jednu ili više usluga.
                        </p>
                    </div>
                </div>

                <fieldset>
                    <legend class="sr-only">Dostupne usluge</legend>

                    <div class="grid gap-4">
                        @forelse ($services as $service)
                            <label class="flex cursor-pointer items-center gap-4 rounded-xl border border-white/10 bg-[#202124] p-5 transition hover:border-amber-500/50 has-checked:border-amber-400 has-checked:bg-amber-500/10">

                                <input
                                    type="checkbox"
                                    name="service_ids[]"
                                    value="{{ $service->id }}"
                                    data-service-option
                                    data-price="{{ $service->price }}"
                                    data-name="{{ $service->name }}"
                                    class="h-5 w-5 shrink-0 cursor-pointer accent-amber-500"
                                    @checked(in_array($service->id, old('service_ids', [])))
                                >

                                <span class="min-w-0 flex-1">
                                    <span class="block text-base font-bold text-white">
                                        {{ $service->name }}
                                    </span>

                                    <span class="mt-2 block text-sm leading-6 text-stone-400">
                                        {{ $service->description ?: 'Profesionalna barber usluga.' }}
                                    </span>
                                </span>

                                <span class="shrink-0 text-right">
                                    <span class="block text-lg font-bold text-amber-400">
                                        {{ number_format($service->price, 0, ',', '.') }}
                                    </span>

                                    <span class="text-xs text-stone-500">
                                        RSD
                                    </span>
                                </span>
                            </label>
                        @empty
                            <div class="rounded-xl border border-white/10 p-6 text-stone-400">
                                Trenutno nema dostupnih usluga.
                            </div>
                        @endforelse
                    </div>
                </fieldset>
            </div>

            <div class="rounded-2xl border border-white/10 bg-[#17181b] p-6 sm:p-8">
                <div class="mb-8 flex items-start gap-4">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-500 font-black text-neutral-950">
                        02
                    </div>

                    <div>
                        <h2 class="text-2xl font-bold">
                            Izaberi termin
                        </h2>

                        <p class="mt-2 text-sm text-stone-400">
                            Prikazani su samo trenutno slobodni termini.
                        </p>
                    </div>
                </div>

                @if ($slots->isNotEmpty())
                    <fieldset>
                        <legend class="sr-only">Slobodni termini</legend>

                        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 xl:grid-cols-4">
                            @foreach ($slots as $slot)
                                <label class="block cursor-pointer">
                                    <input
                                        type="radio"
                                        name="start_at"
                                        value="{{ $slot->start_at->format('Y-m-d H:i:s') }}"
                                        data-slot-option
                                        data-label="{{ $slot->start_at->format('d.m.Y. H:i') }}"
                                        class="peer sr-only"
                                        required
                                        @checked(old('start_at') === $slot->start_at->format('Y-m-d H:i:s'))
                                    >

                                    <span class="block rounded-xl border border-white/10 bg-[#202124] px-3 py-5 text-center transition hover:border-amber-500/50 peer-checked:border-amber-400 peer-checked:bg-amber-500 peer-checked:text-neutral-950 peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-amber-400">
                                        <span class="block text-xs opacity-75">
                                            {{ $slot->start_at->format('d.m.Y.') }}
                                        </span>

                                        <span class="mt-2 block text-xl font-bold">
                                            {{ $slot->start_at->format('H:i') }}
                                        </span>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>
                @else
                    <div class="rounded-xl border border-amber-500/20 bg-amber-500/5 p-8 text-center">
                        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-amber-500/10 text-2xl text-amber-400">
                            ◷
                        </div>

                        <h3 class="text-lg font-bold">
                            Trenutno nema slobodnih termina
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-stone-400">
                            Novi termini biće dostupni kada ih salon objavi.
                            Proveri ponovo kasnije.
                        </p>
                    </div>
                @endif
            </div>

        </div>

        <aside class="lg:sticky lg:top-28">
            <div class="overflow-hidden rounded-2xl border border-amber-500/20 bg-[#191a1d]">

                <div class="border-b border-white/10 bg-gradient-to-r from-amber-500/10 to-transparent p-6">
                    <p class="text-xs font-bold uppercase tracking-[0.25em] text-amber-400">
                        MAKEDONCE
                    </p>

                    <h2 class="mt-3 text-2xl font-bold">
                        Tvoja rezervacija
                    </h2>

                    <p class="mt-2 text-sm text-stone-400">
                        Pregled pre potvrde
                    </p>
                </div>

                <div class="space-y-7 p-6">

                    <div>
                        <div class="mb-3 flex items-center justify-between">
                            <h3 class="text-sm font-bold text-stone-200">
                                Izabrane usluge
                            </h3>

                            <span
                                id="selected-count"
                                class="rounded-full bg-white/10 px-3 py-1 text-xs text-stone-300"
                            >
                                0
                            </span>
                        </div>

                        <div
                            id="selected-services"
                            class="space-y-3 text-sm text-stone-400"
                            aria-live="polite"
                        >
                            Još nisi izabrao usluge.
                        </div>
                    </div>

                    <div class="border-t border-white/10 pt-6">
                        <p class="mb-3 text-sm font-bold text-stone-200">
                            Datum i vreme
                        </p>

                        <p
                            id="selected-slot"
                            class="text-sm text-stone-400"
                            aria-live="polite"
                        >
                            Termin nije izabran.
                        </p>
                    </div>

                    <div class="border-t border-white/10 pt-6">
                        <p class="mb-2 text-sm text-stone-400">
                            Trajanje termina
                        </p>

                        <p class="text-lg font-bold">
                            30 minuta
                        </p>
                    </div>

                    <div class="border-t border-white/10 pt-6">
                        <div class="flex items-center justify-between gap-3">
                            <span class="font-semibold text-stone-300">
                                Ukupna cena
                            </span>

                            <span
                                id="total-price"
                                class="text-3xl font-black text-amber-400"
                                aria-live="polite"
                            >
                                0 RSD
                            </span>
                        </div>
                    </div>

                    <button
                        type="submit"
                        id="submit-booking"
                        class="w-full cursor-pointer rounded-xl bg-amber-500 px-5 py-4 text-sm font-black uppercase tracking-wider text-neutral-950 transition hover:bg-amber-400 disabled:cursor-not-allowed disabled:opacity-40"
                        disabled
                    >
                        Potvrdi rezervaciju
                    </button>

                    <p class="text-center text-xs leading-6 text-stone-500">
                        Rezervacija se potvrđuje nakon provere dostupnosti termina.
                    </p>
                </div>
            </div>

            <a
                href="{{ route('services.index') }}"
                class="mt-5 block text-center text-sm font-medium text-stone-400 transition hover:text-amber-400"
            >
                ← Nazad na usluge
            </a>
        </aside>

    </form>
</section>

<script>
    const bookingForm = document.getElementById('booking-form');

    const serviceInputs = Array.from(
        document.querySelectorAll('[data-service-option]')
    );

    const slotInputs = Array.from(
        document.querySelectorAll('[data-slot-option]')
    );

    const selectedServices = document.getElementById('selected-services');
    const selectedCount = document.getElementById('selected-count');
    const selectedSlot = document.getElementById('selected-slot');
    const totalPrice = document.getElementById('total-price');
    const submitButton = document.getElementById('submit-booking');

    const priceFormatter = new Intl.NumberFormat('sr-RS', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 2
    });

    function updateBookingSummary() {
        const chosenServices = serviceInputs.filter(input => input.checked);
        const chosenSlot = slotInputs.find(input => input.checked);

        const total = chosenServices.reduce((sum, input) => {
            return sum + Number(input.dataset.price);
        }, 0);

        selectedCount.textContent = chosenServices.length;

        selectedServices.replaceChildren();

        if (chosenServices.length === 0) {
            selectedServices.textContent = 'Još nisi izabrao usluge.';
        } else {
            chosenServices.forEach(input => {
                const row = document.createElement('div');
                row.className = 'flex items-center justify-between gap-3';

                const name = document.createElement('span');
                name.className = 'text-stone-300';
                name.textContent = input.dataset.name;

                const price = document.createElement('span');
                price.className = 'shrink-0 text-amber-400';
                price.textContent = priceFormatter.format(
                    Number(input.dataset.price)
                ) + ' RSD';

                row.append(name, price);
                selectedServices.appendChild(row);
            });
        }

        selectedSlot.textContent = chosenSlot
            ? chosenSlot.dataset.label
            : 'Termin nije izabran.';

        totalPrice.textContent = priceFormatter.format(total) + ' RSD';

        submitButton.disabled = chosenServices.length === 0 || !chosenSlot;
    }

    serviceInputs.forEach(input => {
        input.addEventListener('change', updateBookingSummary);
    });

    slotInputs.forEach(input => {
        input.addEventListener('change', updateBookingSummary);
    });

    bookingForm.addEventListener('submit', () => {
        submitButton.disabled = true;
        submitButton.textContent = 'Potvrđivanje...';
    });

    updateBookingSummary();
</script>

@endsection
