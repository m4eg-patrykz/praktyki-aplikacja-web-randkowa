@extends('layouts.auth')

@section('title', 'Logowanie')
@section('heading', 'Zaloguj się')
@section('subheading', 'Wpisz swoje dane, aby wejść do panelu.')

@section('content')
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        {{-- E-mail --}}
        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200" for="email">
                E-mail
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full rounded-lg border border-indigo-100 bg-white/90 px-3 py-2 text-sm
                                  shadow-sm outline-none transition
                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200/80
                                  dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100
                                  dark:focus:border-indigo-400 dark:focus:ring-indigo-500/40">
            @error('email')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Hasło --}}
        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200" for="password">
                Hasło
            </label>

            <div class="relative">
                <input id="password" type="password" name="password" required class="w-full rounded-lg border border-indigo-100 bg-white/90 px-3 py-2 text-sm pr-12
                                      shadow-sm outline-none transition
                                      focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200/80
                                      dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100
                                      dark:focus:border-indigo-400 dark:focus:ring-indigo-500/40">

                {{-- Ikona pokaż/ukryj --}}
                <button type="button" onclick="togglePassword('password', 'togglePasswordIcon')"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-300">
                    <span id="togglePasswordIcon" class="text-xl select-none">👁️</span>
                </button>
            </div>

            @error('password')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Zapamiętaj --}}
        <div class="flex items-center justify-between">
            <label class="inline-flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400">
                <input type="checkbox" name="remember"
                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:border-gray-600">
                <span>Zapamiętaj mnie</span>
            </label>
        </div>

        {{-- Przycisk --}}
        <div class="pt-2">
            <button type="submit"
                class="flex w-full justify-center rounded-lg 
                                   bg-gradient-to-r from-indigo-600 to-sky-500 
                                   px-4 py-2.5 text-sm font-semibold text-white shadow-md
                                   transition hover:from-indigo-700 hover:to-sky-600
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                                   dark:bg-indigo-500 dark:hover:bg-indigo-400 dark:bg-gradient-to-r dark:from-indigo-500 dark:to-indigo-600">
                Zaloguj się
            </button>
        </div>
    </form>

    {{-- Skrypt pokaz/ukryj --}}
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === "password") {
                input.type = "text";
                icon.textContent = "🙈"; // ukryte
            } else {
                input.type = "password";
                icon.textContent = "👁️"; // oko
            }
        }
    </script>
@endsection

@section('bottom-link')
    Nie masz jeszcze konta?
    <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
        Załóż konto
    </a>
@endsection