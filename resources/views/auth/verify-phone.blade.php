@extends('layouts.auth')

@section('title', 'Potwierdź numer telefonu')
@section('heading', 'Dodaj numer telefonu')
@section('subheading', 'Twoje konto wymaga dodania numeru telefonu.')

@section('content')
    @if (session('error') === 'wait-before-resend')
        <p class="mb-4 rounded-lg bg-red-100 px-3 py-2 text-sm text-red-800">
            Odczekaj chwilę przed ponownym wysłaniem kodu.
        </p>
    @endif

    @if (session('status') === 'phone-verification-completed')
        <p class="mb-4 rounded-lg bg-green-100 px-3 py-2 text-sm text-green-800">
            Numer telefonu został dodany do Twojego konta.
        </p>

        <form method="GET" action="{{ route('home') }}" class="space-y-3">
            @csrf
            <button type="submit"
                class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                Kontynuuj
            </button>
        </form>
    @elseif (session('status') == 'phone-verification-sent')
        @if (session('error') === 'code-invalid')
            <p class="mb-4 rounded-lg bg-red-100 px-3 py-2 text-sm text-red-800">
                Nieprawidłowy kod weryfikacyjny. Spróbuj ponownie.
            </p>
        @endif

        <p class="mb-4 text-sm text-gray-600 dark:text-gray-300">
            Wysłaliśmy kod weryfikacyjny na Twój numer telefonu
            @php
                $u = auth()->user();
                $displayPhone = trim(($u->phone_country_code ?? '') . ' ' . ($u->phone_number ?? ''));
            @endphp
            @if($displayPhone)
                <span class="font-semibold">{{ $displayPhone }}</span>.
            @else
                .
            @endif
        </p>

        <form method="POST" action="{{ route('phone.verification.check') }}" class="space-y-3">
            @csrf
            <input type="text" name="verification_code" placeholder="Kod weryfikacyjny"
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:focus:border-indigo-400 dark:focus:ring-indigo-400"
                required>

            <button type="submit"
                class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                Zweryfikuj kod
            </button>
        </form>
    @else
        @if(session('error') === 'no-active-code')
            <p class="mb-4 rounded-lg bg-red-100 px-3 py-2 text-sm text-red-800">
                Brak aktywnego kodu weryfikacyjnego. Proszę poprosić o wysłanie nowego kodu.
            </p>
        @elseif(session('error') === 'code-expired')
            <p class="mb-4 rounded-lg bg-red-100 px-3 py-2 text-sm text-red-800">
                Kod weryfikacyjny wygasł. Proszę poprosić o wysłanie nowego kodu.
            </p>
        @endif

        <p class="mb-4 text-sm text-gray-600 dark:text-gray-300">
            Aby zapewnić bezpieczeństwo naszych użytkowników, prosimy o dodanie numeru telefonu do Twojego konta.
            Podaj numer telefonu, a następnie wyślemy na niego kod weryfikacyjny.
        </p>

        <form method="POST" action="{{ route('phone.verification.send') }}" class="space-y-3">
            @csrf

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">
                    Numer telefonu
                </label>

                <div class="flex gap-3">
                    {{-- Kierunkowy --}}
                    <div class="w-28">
                        <input id="phone_country_code" type="text" name="phone_country_code"
                            value="{{ old('phone_country_code', auth()->user()->phone_country_code ?? '+48') }}"
                            placeholder="+48"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:focus:border-indigo-400 dark:focus:ring-indigo-400"
                            required>
                    </div>

                    {{-- Numer --}}
                    <div class="flex-1">
                        <input id="phone_number" type="text" name="phone_number"
                            value="{{ old('phone_number', auth()->user()->phone_number ?? '') }}" placeholder="600 123 456"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:focus:border-indigo-400 dark:focus:ring-indigo-400"
                            required>
                    </div>
                </div>

                @error('phone_country_code')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror

                @error('phone_number')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                Wyślij kod weryfikacyjny
            </button>
        </form>
    @endif

    <form method="GET" action="{{ route('logout') }}" class="mt-3">
        @csrf
        <button type="submit"
            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-800">
            Wyloguj się
        </button>
    </form>
@endsection