@extends('auth.layout')

@section('title', 'Rejestracja')
@section('heading', 'Załóż konto')
@section('subheading', 'Wypełnij dane, aby utworzyć nowe konto.')

@section('content')
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        {{-- Imię / nazwa --}}
        <div>
            <label class="mb-1 block text-sm font-medium" for="name">Nazwa użytkownika</label>
            <input id="name"
                   type="text"
                   name="name"
                   value="{{ old('name') }}"
                   required
                   autofocus
                   class="w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm
                          shadow-sm outline-none transition
                          focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200
                          dark:border-gray-600 dark:bg-gray-900 dark:focus:border-indigo-400 dark:focus:ring-indigo-500/40">
            @error('name')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- E-mail --}}
        <div>
            <label class="mb-1 block text-sm font-medium" for="email">E-mail</label>
            <input id="email"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   class="w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm
                          shadow-sm outline-none transition
                          focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200
                          dark:border-gray-600 dark:bg-gray-900 dark:focus:border-indigo-400 dark:focus:ring-indigo-500/40">
            @error('email')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Hasło --}}
        <div>
            <label class="mb-1 block text-sm font-medium" for="password">Hasło</label>
            <input id="password"
                   type="password"
                   name="password"
                   required
                   class="w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm
                          shadow-sm outline-none transition
                          focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200
                          dark:border-gray-600 dark:bg-gray-900 dark:focus:border-indigo-400 dark:focus:ring-indigo-500/40">
            @error('password')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Potwierdzenie hasła --}}
        <div>
            <label class="mb-1 block text-sm font-medium" for="password_confirmation">Potwierdź hasło</label>
            <input id="password_confirmation"
                   type="password"
                   name="password_confirmation"
                   required
                   class="w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm
                          shadow-sm outline-none transition
                          focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200
                          dark:border-gray-600 dark:bg-gray-900 dark:focus:border-indigo-400 dark:focus:ring-indigo-500/40">
        </div>

        {{-- Przycisk --}}
        <div class="pt-2">
            <button type="submit"
                    class="flex w-full justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md
                           transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                           dark:bg-indigo-500 dark:hover:bg-indigo-400">
                Załóż konto
            </button>
        </div>
    </form>
@endsection

@section('bottom-link')
    Masz już konto?
    <a href="{{ route('login') }}"
       class="font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
        Zaloguj się
    </a>
@endsection
