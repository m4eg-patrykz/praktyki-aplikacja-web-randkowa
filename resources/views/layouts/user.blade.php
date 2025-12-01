
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
    <div class="absolute top-4 right-4 z-50 flex items-center gap-4 justify-end">
        @hasSection('topbar-right')
            @yield('topbar-right')
        @endif

        <a href="{{ route('logout') }}" class="px-4 py-2 rounded-xl text-sm font-semibold
                   bg-white shadow-md hover:shadow-lg text-gray-600
                   dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600 transition">
        🔒 Wyloguj</a>

        <button @click="toggleTheme()" class="px-4 py-2 rounded-xl text-sm font-semibold
                   bg-white shadow-md hover:shadow-lg text-gray-600
                   dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600 transition">
            <span x-show="!dark">🌙 Tryb ciemny</span>
            <span x-show="dark">☀️ Tryb jasny</span>
        </button>
    </div>
    <main>
         @yield('content')
    </main>
    <nav class="fixed bottom-0 left-0 right-0 z-40
            bg-pink-200 dark:bg-pink-700
            border-t border-pink-300/80 dark:border-pink-900/80
            backdrop-blur-md">
    <div class="max-w-md mx-auto flex justify-between px-6 py-3 text-xs font-medium
                text-pink-900 dark:text-white">

        {{-- GŁÓWNA --}}
        <a href="{{ route('user.home') }}"
           class="flex flex-col items-center gap-0.5
                  @if(request()->routeIs('user.home'))
                      font-semibold
                  @else
                      text-pink-800/80 dark:text-white/80
                  @endif">
            <span class="text-lg">🏠</span>
            <span>Główna</span>
        </a>

        {{-- CZATY --}}
        <a href="{{ route('user.matches') }}"
           class="flex flex-col items-center gap-0.5
                  @if(request()->routeIs('user.matches'))
                      font-semibold
                  @else
                      text-pink-800/80 dark:text-white/80
                  @endif">
            <span class="text-lg">💬</span>
            <span>Czaty</span>
        </a>

        {{-- PROFIL --}}
        <a href="{{ route('user.profile') }}"
           class="flex flex-col items-center gap-0.5
                  @if(request()->routeIs('user.profile'))
                      font-semibold
                  @else
                      text-pink-800/80 dark:text-white/80
                  @endif">
            <span class="text-lg">👤</span>
            <span>Profil</span>
        </a>

    </div>
</nav>
</body>

</html>