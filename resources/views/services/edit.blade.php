
@extends('layouts.app')

@section('title', 'Izmena usluge | MAKEDONCE')

@section('content')

<section class="relative overflow-hidden border-b border-white/10 bg-[#111214]">
    <div class="absolute right-0 top-0 h-64 w-64 rounded-full bg-amber-500/10 blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl px-6 py-14 lg:px-10 lg:py-20">
        <a
            href="{{ route('services.index') }}"
            class="inline-flex items-center gap-2 text-sm text-stone-400 transition hover:text-amber-400"
        >
            <span>←</span>
            Nazad na usluge
        </a>

        <div class="mb-5 mt-10 flex items-center gap-3">
            <span class="h-px w-8 bg-amber-400"></span>
            <span class="text-xs font-bold uppercase tracking-[0.3em] text-amber-400">
                Makedonce / Administration
            </span>
        </div>

        <h1 class="text-4xl font-black uppercase tracking-tight text-white sm:text-5xl">
            Izmena <span class="text-amber-400">usluge.</span>
        </h1>

        <p class="mt-5 max-w-2xl text-base leading-7 text-stone-400">
            Ažuriraj informacije o postojećoj usluzi u MAKEDONCE Barber Studiju.
        </p>
    </div>
</section>

<section class="mx-auto max-w-7xl px-6 py-12 lg:px-10 lg:py-16">

    @if ($errors->any())
        <div role="alert" class="mb-8 rounded-xl border border-red-500/30 bg-red-500/10 p-5">
            <p class="font-bold text-red-300">
                Proveri unete podatke.
            </p>

            <ul class="mt-3 list-inside list-disc space-y-2 text-sm text-red-200">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid items-start gap-8 lg:grid-cols-[minmax(0,1fr)_320px]">

        <form
            action="{{ route('services.update', $service) }}"
            method="POST"
            class="rounded-2xl border border-white/10 bg-[#17181b] p-6 sm:p-8"
        >
            @csrf
            @method('PUT')

            <div class="mb-9 flex items-center gap-4 border-b border-white/10 pb-7">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-500/10 text-2xl text-amber-400">
                    ✎
                </div>

                <div>
                    <h2 class="text-xl font-bold text-white">
                        Podaci o usluzi
                    </h2>

                    <p class="mt-1 text-sm text-stone-400">
                        Menjaš uslugu #{{ $service->id }}
                    </p>
                </div>
            </div>

            <div class="space-y-7">

                <div>
                    <label for="name" class="mb-3 block text-sm font-semibold text-stone-200">
                        Naziv usluge <span class="text-amber-400">*</span>
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $service->name) }}"
                        maxlength="255"
                        required
                        autofocus
                        class="w-full rounded-xl border border-white/10 bg-[#202124] px-5 py-4 text-white placeholder:text-stone-600 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-400/10"
                    >

                    @error('name')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="mb-3 block text-sm font-semibold text-stone-200">
                        Opis usluge
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="5"
                        placeholder="Opis usluge..."
                        class="w-full resize-y rounded-xl border border-white/10 bg-[#202124] px-5 py-4 text-white placeholder:text-stone-600 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-400/10"
                    >{{ old('description', $service->description) }}</textarea>

                    @error('description')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-6 sm:grid-cols-2">

                    <div>
                        <label for="price" class="mb-3 block text-sm font-semibold text-stone-200">
                            Cena <span class="text-amber-400">*</span>
                        </label>

                        <div class="relative">
                            <input
                                type="number"
                                id="price"
                                name="price"
                                value="{{ old('price', $service->price) }}"
                                min="0"
                                step="0.01"
                                required
                                class="w-full rounded-xl border border-white/10 bg-[#202124] px-5 py-4 pr-20 text-white outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-400/10"
                            >

                            <span class="pointer-events-none absolute inset-y-0 right-5 flex items-center text-sm font-bold text-amber-400">
                                RSD
                            </span>
                        </div>

                        @error('price')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="duration_minutes" class="mb-3 block text-sm font-semibold text-stone-200">
                            Trajanje <span class="text-amber-400">*</span>
                        </label>

                        <div class="relative">
                            <input
                                type="number"
                                id="duration_minutes"
                                name="duration_minutes"
                                value="{{ old('duration_minutes', $service->duration_minutes) }}"
                                min="1"
                                step="1"
                                required
                                class="w-full rounded-xl border border-white/10 bg-[#202124] px-5 py-4 pr-20 text-white outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-400/10"
                            >

                            <span class="pointer-events-none absolute inset-y-0 right-5 flex items-center text-sm font-bold text-amber-400">
                                MIN
                            </span>
                        </div>

                        @error('duration_minutes')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

            </div>

            <div class="mt-10 flex flex-col-reverse gap-4 border-t border-white/10 pt-8 sm:flex-row sm:justify-end">

                <a
                    href="{{ route('services.index') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-white/15 px-7 py-4 text-sm font-bold text-stone-300 transition hover:border-white/30 hover:text-white"
                >
                    Odustani
                </a>

                <button
                    type="submit"
                    class="cursor-pointer rounded-xl bg-amber-500 px-8 py-4 text-sm font-black uppercase tracking-wide text-neutral-950 transition hover:bg-amber-400"
                >
                    Sačuvaj izmene
                </button>

            </div>

        </form>

        <aside class="space-y-6">

            <div class="overflow-hidden rounded-2xl border border-amber-500/20 bg-[#191a1d]">

                <div class="border-b border-white/10 bg-gradient-to-br from-amber-500/10 to-transparent p-7">
                    <p class="text-xs font-bold uppercase tracking-[0.25em] text-amber-400">
                        Service Preview
                    </p>

                    <h3 class="mt-5 text-2xl font-bold text-white">
                        {{ $service->name }}
                    </h3>

                    <p class="mt-3 text-sm leading-7 text-stone-400">
                        {{ $service->description ?: 'Profesionalna barber usluga.' }}
                    </p>
                </div>

                <div class="p-7">
                    <p class="text-xs uppercase tracking-widest text-stone-500">
                        Trenutna cena
                    </p>

                    <p class="mt-2 text-3xl font-black text-amber-400">
                        {{ number_format($service->price, 0, ',', '.') }}
                        <span class="text-sm font-semibold">RSD</span>
                    </p>

                    <div class="mt-6 border-t border-white/10 pt-6">
                        <p class="text-xs uppercase tracking-widest text-stone-500">
                            Evidentirano trajanje
                        </p>

                        <p class="mt-2 text-lg font-bold text-white">
                            {{ $service->duration_minutes }} minuta
                        </p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-white/10 bg-[#17181b] p-7">
                <h3 class="font-bold text-white">
                    Ažuriranje usluge
                </h3>

                <p class="mt-3 text-sm leading-7 text-stone-400">
                    Izmene naziva, opisa i cene biće vidljive u katalogu nakon uspešnog čuvanja.
                </p>

                <a
                    href="{{ route('services.index') }}"
                    class="mt-6 inline-flex text-sm font-bold text-amber-400 transition hover:text-amber-300"
                >
                    Pregled svih usluga →
                </a>
            </div>

        </aside>

    </div>
</section>

@endsection
