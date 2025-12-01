@extends('layouts.auth')

@section('title', 'Rejestracja')
@section('heading', 'Załóż konto')
@section('subheading', 'Wypełnij dane, aby utworzyć nowe konto.')

@section('content')
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        {{-- E-mail --}}
        <div>
            <label class="mb-1 block text-sm font-medium" for="email">E-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
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

            <div class="relative">
                <input id="password" type="password" name="password" required class="w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm pr-12
                                                              shadow-sm outline-none transition
                                                              focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200
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

        {{-- Potwierdzenie hasła --}}
        <div>
            <label class="mb-1 block text-sm font-medium" for="password">Potwiedź hasło</label>

            <div class="relative">
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm pr-12
                                                                      shadow-sm outline-none transition
                                                                      focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200
                                                                      dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100
                                                                      dark:focus:border-indigo-400 dark:focus:ring-indigo-500/40">

                {{-- Ikona pokaż/ukryj --}}
                <button type="button" onclick="togglePassword('password_confirmation', 'togglePasswordIconConfirmation')"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-300">
                    <span id="togglePasswordIconConfirmation" class="text-xl select-none">👁️</span>
                </button>
            </div>
        </div>

        {{-- Przycisk --}}
        <div class="pt-2">
            <button type="submit" class="flex w-full justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md
                                                               transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                                                               dark:bg-indigo-500 dark:hover:bg-indigo-400">
                Załóż konto
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
    Masz już konto?
    <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
        Zaloguj się
    </a>
@endsection