
@extends('layouts.app')

@section('title', 'Prijava | MAKEDONCE')

@section('content')

<section class="relative flex min-h-[80vh] items-center justify-center overflow-hidden px-6 py-16">

    <div class="pointer-events-none absolute left-0 top-0 h-80 w-80 rounded-full bg-amber-500/10 blur-3xl"></div>
    <div class="pointer-events-none absolute bottom-0 right-0 h-80 w-80 rounded-full bg-amber-500/5 blur-3xl"></div>

    <div class="relative w-full max-w-md">

        <div class="mb-9 text-center">
            <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-2xl border border-amber-500/30 bg-amber-500/10 text-3xl font-black text-amber-400">
                M
            </div>

            <p class="text-xs font-bold uppercase tracking-[0.3em] text-amber-400">
                Makedonce Barber Studio
            </p>

            <h1 class="mt-4 text-4xl font-black uppercase text-white">
                Dobrodošao <span class="text-amber-400">nazad.</span>
            </h1>

            <p class="mt-4 text-sm leading-7 text-stone-400">
                Prijavi se i upravljaj svojim rezervacijama.
            </p>
        </div>

        <div class="rounded-2xl border border-white/10 bg-[#17181b] p-7 shadow-2xl sm:p-9">

            @if (session('status'))
                <div role="status" class="mb-6 rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-4 text-sm text-emerald-300">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div role="alert" class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-sm text-red-300">
                    <ul class="list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="mb-3 block text-sm font-semibold text-stone-200">
                        Email adresa
                    </label>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        placeholder="ime@example.com"
                        autocomplete="email"
                        required
                        autofocus
                        class="w-full rounded-xl border border-white/10 bg-[#202124] px-5 py-4 text-white placeholder:text-stone-600 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-400/10"
                    >
                </div>

                <div>
                    <div class="mb-3 flex items-center justify-between">
                        <label for="password" class="text-sm font-semibold text-stone-200">
                            Lozinka
                        </label>
                    </div>

                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Unesi lozinku"
                            autocomplete="current-password"
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
                </div>

                <button
                    type="submit"
                    class="w-full cursor-pointer rounded-xl bg-amber-500 px-6 py-4 text-sm font-black uppercase tracking-wider text-neutral-950 transition hover:bg-amber-400"
                >
                    Prijavi se →
                </button>

            </form>

            <div class="mt-8 border-t border-white/10 pt-7 text-center">
                <p class="text-sm text-stone-400">
                    Nemaš nalog?
                    <a href="{{ url('/register') }}" class="ml-1 font-bold text-amber-400 transition hover:text-amber-300">
                        Registruj se
                    </a>
                </p>
            </div>

        </div>

        <p class="mt-8 text-center text-xs uppercase tracking-[0.25em] text-stone-600">
            Precision. Style. Confidence.
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
