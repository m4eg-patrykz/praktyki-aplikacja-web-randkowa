<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Logowanie')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Tailwind przez CDN, bez npm --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Konfiguracja Tailwinda z dark mode
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {},
            }
        };
    </script>

    <script>
        // Ustawienie motywu PRZED renderem (żeby nie migało)
        (function() {
            const stored = localStorage.getItem('theme');
            const prefersDark = window.matchMedia &&
                window.matchMedia('(prefers-color-scheme: dark)').matches;

            if (stored === 'dark' || (!stored && prefersDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
</head>
<body class="min-h-screen bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100">

<div class="flex min-h-screen items-center justify-center px-4">
    <div class="w-full max-w-md">
        {{-- Pasek tytułu + przełącznik motywu --}}
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-semibold tracking-tight">
                    @yield('heading', 'Witaj 👋')
                </h1>
                @hasSection('subheading')
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        @yield('subheading')
                    </p>
                @endif
            </div>

            <button id="themeToggle"
                    type="button"
                    class="inline-flex items-center rounded-full border border-gray-300 bg-white px-3 py-1 text-xs font-medium shadow-sm transition
                           hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:hover:bg-gray-700">
                <span class="mr-1 text-lg" id="themeToggleIcon">🌙</span>
                <span id="themeToggleLabel">Ciemny</span>
            </button>
        </div>

        {{-- Kontener na formularz --}}
        <div class="rounded-2xl bg-white p-6 shadow-lg shadow-gray-200/60
                    dark:bg-gray-800 dark:shadow-black/40">
            @yield('content')
        </div>

        {{-- Link pod formularzem (login <-> rejestracja) --}}
        @hasSection('bottom-link')
            <div class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400">
                @yield('bottom-link')
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn  = document.getElementById('themeToggle');
        const icon = document.getElementById('themeToggleIcon');
        const lbl  = document.getElementById('themeToggleLabel');

        function refreshLabel() {
            const isDark = document.documentElement.classList.contains('dark');
            if (isDark) {
                icon.textContent = '☀️';
                lbl.textContent = 'Jasny';
            } else {
                icon.textContent = '🌙';
                lbl.textContent = 'Ciemny';
            }
        }

        refreshLabel();

        btn.addEventListener('click', () => {
            const root = document.documentElement;
            const isDark = root.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            refreshLabel();
        });
    });
</script>

@auth
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit"
            class="text-sm text-red-600 hover:text-red-700">
        Wyloguj
    </button>
</form>
@endauth

</body>
</html>
