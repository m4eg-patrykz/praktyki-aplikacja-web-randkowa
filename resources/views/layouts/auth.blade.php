<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Logowanie')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        };
    </script>

    {{-- Ustawienie motywu PRZED renderem (bez mignięcia) --}}
    <script>
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
<body
    class="min-h-screen text-gray-900 dark:text-gray-100
           bg-gradient-to-br from-[#ffe4e6] via-[#e0f2fe] to-[#ddd6fe]
           dark:from-[#020617] dark:via-[#111827] dark:to-[#4c1d95]"
>
    <div class="flex min-h-screen items-center justify-center px-4 py-10">
        <div class="w-full max-w-md">

            {{-- Nagłówek + przełącznik motywu --}}
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-semibold tracking-tight">
                        @yield('heading', 'Witaj 👋')
                    </h1>
                    @hasSection('subheading')
                        <p class="mt-1 text-sm text-gray-700 dark:text-gray-400">
                            @yield('subheading')
                        </p>
                    @endif
                </div>

                <button id="themeToggle"
                        type="button"
                        class="inline-flex items-center rounded-full border border-pink-200/70
                               bg-white/90 px-3 py-1 text-xs font-medium shadow-sm backdrop-blur
                               hover:bg-white dark:border-purple-500/60 dark:bg-gray-900/90 dark:hover:bg-gray-800">
                    <span class="mr-1 text-lg" id="themeToggleIcon">🌙</span>
                    <span id="themeToggleLabel">Ciemny</span>
                </button>
            </div>

            {{-- Karta formularza --}}
            <div class="rounded-2xl bg-white/95 backdrop-blur-xl 
                        border border-pink-100/80
                        shadow-[0_18px_45px_rgba(236,72,153,0.25)]
                        dark:bg-[#020617]/95 dark:border-purple-600/70 
                        dark:shadow-[0_18px_45px_rgba(88,28,135,0.7)]">
                <div class="p-6 sm:p-7">
                    @yield('content')
                </div>
            </div>

            {{-- Link pod formularzem --}}
            @hasSection('bottom-link')
                <div class="mt-4 text-center text-sm text-gray-700 dark:text-gray-400">
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

            btn?.addEventListener('click', () => {
                const root = document.documentElement;
                const isDark = root.classList.toggle('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                refreshLabel();
            });
        });
    </script>
</body>
</html>
