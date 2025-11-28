<!DOCTYPE html>
<html lang="pl" x-data="themeController()" x-init="initTheme()">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', config('app.name'))</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>

    {{-- Alpine --}}
    <script defer src="https://unpkg.com/alpinejs"></script>

    {{-- LOGIKA MOTYWU --}}
    <script>
        function themeController() {
            return {

                dark: false,

                initTheme() {
                    const saved = localStorage.getItem('theme');

                    if (saved === 'dark') {
                        this.dark = true;
                    } else {
                        this.dark = false;
                    }

                    document.documentElement.classList.toggle('dark', this.dark);
                },

                toggleTheme() {
                    this.dark = !this.dark;
                    localStorage.setItem('theme', this.dark ? 'dark' : 'light');
                    document.documentElement.classList.toggle('dark', this.dark);
                }
            };
        }
    </script>
</head>

<body :class="dark 
        ? 'min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-gray-100' 
        : 'min-h-screen bg-gradient-to-br from-[#ffffff] via-[#f9f5ff] to-[#f0f7ff] text-gray-800'"
    class="transition-colors duration-500 min-h-screen">


    {{-- PRZEŁĄCZNIK MOTYWU --}}
    <button @click="toggleTheme()" class="fixed top-6 right-6 z-50 px-4 py-2 rounded-xl text-sm font-semibold
                   bg-white shadow-md hover:shadow-lg text-gray-600
                   dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600 transition">
        <span x-show="!dark">🌙 Tryb ciemny</span>
        <span x-show="dark">☀️ Tryb jasny</span>
    </button>

    @yield('content')

</body>

</html>