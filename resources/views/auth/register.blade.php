
@extends('layouts.app')

@section('title', 'Registracija | MAKEDONCE')

@section('content')

<section class="relative flex min-h-[85vh] items-center justify-center overflow-hidden px-6 py-16">

    <div class="pointer-events-none absolute left-0 top-0 h-96 w-96 rounded-full bg-amber-500/10 blur-3xl"></div>
    <div class="pointer-events-none absolute bottom-0 right-0 h-80 w-80 rounded-full bg-amber-500/5 blur-3xl"></div>

    <div class="relative w-full max-w-lg">

        <div class="mb-9 text-center">

            <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-2xl border border-amber-500/30 bg-amber-500/10 text-3xl font-black text-amber-400">
                M
            </div>

            <p class="text-xs font-bold uppercase tracking-[0.3em] text-amber-400">
                Join Makedonce
            </p>

            <h1 class="mt-4 text-4xl font-black uppercase tracking-tight text-white sm:text-5xl">
                Kreiraj svoj <span class="text-amber-400">nalog.</span>
            </h1>

            <p class="mx-auto mt-4 max-w-sm text-sm leading-7 text-stone-400">
                Registruj se, izaberi željene usluge i rezerviši svoj termin online.
            </p>
        </div>

        <div class="rounded-2xl border border-white/10 bg-[#17181b] p-7 shadow-2xl sm:p-9">

            @if ($errors->any())
                <div role="alert" class="mb-7 rounded-xl border border-red-500/30 bg-red-500/10 p-5">
                    <p class="mb-3 text-sm font-bold text-red-300">
                        Proveri podatke za registraciju.
                    </p>

                    <ul class="list-inside list-disc space-y-2 text-sm text-red-200">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('/register') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="mb-3 block text-sm font-semibold text-stone-200">
                        Ime i prezime <span class="text-amber-400">*</span>
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Marko Marković"
                        autocomplete="name"
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
                    <label for="email" class="mb-3 block text-sm font-semibold text-stone-200">
                        Email adresa <span class="text-amber-400">*</span>
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="ime@example.com"
                        autocomplete="email"
                        maxlength="255"
                        required
                        class="w-full rounded-xl border border-white/10 bg-[#202124] px-5 py-4 text-white placeholder:text-stone-600 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-400/10"
                    >

                    @error('email')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-3 block text-sm font-semibold text-stone-200">
                        Lozinka <span class="text-amber-400">*</span>
                    </label>

                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Unesi lozinku"
                            autocomplete="new-password"
                            minlength="8"
                            required
                            class="w-full rounded-xl border border-white/10 bg-[#202124] px-5 py-4 pr-24 text-white placeholder:text-stone-600 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-400/10"
                        >

                        <button
                            type="button"
                            data-toggle-password="password"
                            aria-label="Prikaži lozinku"
                            aria-pressed="false"
                            class="absolute inset-y-0 right-4 cursor-pointer text-xs font-bold text-amber-400 transition hover:text-amber-300"
                        >
                            Prikaži
                        </button>
                    </div>

                    <p class="mt-2 text-xs text-stone-500">
                        Lozinka mora imati najmanje 8 karaktera.
                    </p>

                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="mb-3 block text-sm font-semibold text-stone-200">
                        Potvrdi lozinku <span class="text-amber-400">*</span>
                    </label>

                    <div class="relative">
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Ponovi lozinku"
                            autocomplete="new-password"
                            minlength="8"
                            required
                            class="w-full rounded-xl border border-white/10 bg-[#202124] px-5 py-4 pr-24 text-white placeholder:text-stone-600 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-400/10"
                        >

                        <button
                            type="button"
                            data-toggle-password="password_confirmation"
                            aria-label="Prikaži potvrdu lozinke"
                            aria-pressed="false"
                            class="absolute inset-y-0 right-4 cursor-pointer text-xs font-bold text-amber-400 transition hover:text-amber-300"
                        >
                            Prikaži
                        </button>
                    </div>

                    @error('password_confirmation')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="rounded-xl border border-amber-500/15 bg-amber-500/5 p-5">
                    <div class="flex items-start gap-3">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-amber-500/10 text-lg text-amber-400">
                            ✓
                        </div>

                        <div>
                            <h3 class="text-sm font-bold text-white">
                                Brzo i jednostavno zakazivanje
                            </h3>

                            <p class="mt-2 text-xs leading-6 text-stone-400">
                                Sa svojim nalogom možeš rezervisati termine,
                                pregledati svoje rezervacije i otkazati ih.
                            </p>
                        </div>
                    </div>
                </div>

                <button
                    type="submit"
                    class="w-full cursor-pointer rounded-xl bg-amber-500 px-6 py-4 text-sm font-black uppercase tracking-wider text-neutral-950 transition hover:bg-amber-400"
                >
                    Kreiraj nalog →
                </button>

            </form>

            <div class="mt-8 border-t border-white/10 pt-7 text-center">
                <p class="text-sm text-stone-400">
                    Već imaš nalog?
                    <a
                        href="{{ url('/login') }}"
                        class="ml-1 font-bold text-amber-400 transition hover:text-amber-300"
                    >
                        Prijavi se
                    </a>
                </p>
            </div>
        </div>

        <p class="mt-8 text-center text-xs uppercase tracking-[0.25em] text-stone-600">
            Makedonce Barber Studio
        </p>

    </div>
</section>

<script>
    document.querySelectorAll('[data-toggle-password]').forEach(button => {
        button.addEventListener('click', () => {
            const input = document.getElementById(button.dataset.togglePassword);
            const visible = input.type === 'text';

            input.type = visible ? 'password' : 'text';
            button.textContent = visible ? 'Prikaži' : 'Sakrij';
            button.setAttribute('aria-pressed', String(!visible));
            button.setAttribute('aria-label', visible ? 'Prikaži lozinku' : 'Sakrij lozinku');
        });
    });
</script>

@endsection
