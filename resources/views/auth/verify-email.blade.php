@extends('layouts.auth')

@section('title', 'Potwierdź e-mail')
@section('heading', 'Potwierdzanie adresu e-mail')
@section('subheading', 'Twoje konto wymaga potwierdzenia adresu e-mail.')

@section('content')
    @if (session('status') === 'email-verification-sent')
        <p class="mb-4 rounded-lg bg-green-100 px-3 py-2 text-sm text-green-800">
            Wysłaliśmy link weryfikacyjny na Twój adres e-mail.
        </p>
    @endif

    @if (session('error') === 'wait-before-resend')
        <p class="mb-4 rounded-lg bg-red-100 px-3 py-2 text-sm text-red-800">
            Odczekaj chwilę przed ponownym wysłaniem kodu.
        </p>
    @endif

    @if (session('status') === 'email-verification-completed')
        <p class="mb-4 rounded-lg bg-green-100 px-3 py-2 text-sm text-green-800">
            Adres e-mail został pomyślnie zweryfikowany.
        </p>

        <form method="GET" action="{{ route('home') }}" class="space-y-3">
            @csrf
            <button type="submit"
                class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                Kontynuuj
            </button>
        </form>
    @else
        <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
            Aby zweryfikować konto, naciśnij przycisk poniżej, wyślemy link weryfikacyjny na Twój adres e-mail.
        </p>

        <form method="POST" action="{{ route('email.verification.send') }}" class="space-y-3">
            @csrf
            <button type="submit"
                class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                Wyślij link weryfikacyjny
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