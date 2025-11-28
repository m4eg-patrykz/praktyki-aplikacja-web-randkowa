@extends('layouts.auth')

@section('title', 'Potwierdź e-mail')
@section('heading', 'Potwierdź swój adres e-mail')
@section('subheading', 'Wysłaliśmy do Ciebie link aktywacyjny.')

@section('content')
    @if (session('status') === 'verification-link-sent')
        <div class="mb-4 rounded-lg bg-green-100 px-3 py-2 text-sm text-green-800">
            Link weryfikacyjny został wysłany na Twój adres e-mail.
        </div>
    @endif

    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
        Zanim przejdziesz dalej, kliknij w link weryfikacyjny, który wysłaliśmy na Twój adres e-mail.
        Jeśli nie otrzymałeś wiadomości, możesz wysłać link ponownie.
    </p>

    <form method="POST" action="{{ route('email.verification.send') }}" class="space-y-3">
        @csrf
        <button type="submit" class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white
                                       hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-400">
            Wyślij ponownie link weryfikacyjny
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="mt-3">
        @csrf
        <button type="submit"
            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm
                                       text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-800">
            Wyloguj się
        </button>
    </form>
@endsection