@extends('layouts.guest')

@section('content')

<div 
    :class="dark 
        ? 'min-h-screen bg-gradient-to-br from-[#0e0b16] via-[#1a103d] to-[#2a144a] text-gray-100'
        : 'min-h-screen bg-gradient-to-br from-[#f6d5e6] via-[#d4c0f9] to-[#b3d9ff] text-gray-900'"
    class="relative">

    @section('topbar-right')
        <a href="{{ route('login') }}"
           class="px-4 py-2 rounded-xl text-sm font-semibold
                   bg-white shadow-md hover:shadow-lg text-gray-600
                   dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600 transition">
            🔑 Zaloguj się
        </a>
    @endsection

    {{-- SLIDER FULLSCREEN --}}
    <div 
        x-data="{ slide: 0, total: 3 }"
        x-init="setInterval(() => { slide = (slide + 1) % total }, 4000)"
        class="relative w-full h-screen overflow-hidden"
    >

        {{-- SLIDE 1 --}}
        <section
            x-show="slide === 0"

            x-transition:enter="transition-opacity duration-700"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"

            x-transition:leave="transition-opacity duration-700"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"

            class="absolute inset-0 flex items-center justify-center px-6 md:px-12"
        >
            <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-12 items-center">

                <div>
                    <h1 class="text-5xl font-extrabold leading-tight mb-6">
                        Poznawaj ludzi <span class="text-pink-500 dark:text-pink-400">naturalnie i bez stresu.</span>
                    </h1>

                    <p class="text-lg text-gray-700/90 dark:text-gray-300 mb-8">
                        Oglądasz profile jeden po drugim.
                        Klikasz <strong>✔ pasuje</strong> lub <strong>✖ nie pasuje</strong>.
                        Jeśli oboje się polubicie - tworzy się <strong>match i możecie pisać!</strong>
                    </p>

                    <a href="{{ route('register') }}"
                       class="px-10 py-4 rounded-2xl text-white text-xl font-semibold
                              bg-gradient-to-r from-pink-500 to-blue-500
                              shadow-lg hover:shadow-xl transition-transform hover:scale-[1.03]">
                        Dołącz teraz
                    </a>
                </div>

                <div class="relative flex justify-center">
                    <div class="w-72 h-96 
                        bg-white/80 dark:bg-gray-800 backdrop-blur-xl
                        rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.08)]
                        dark:shadow-[0_10px_40px_rgba(0,0,0,0.45)]
                        border border-white/60 dark:border-gray-700 p-5">

                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=400&q=80"
                             class="w-full h-64 object-cover rounded-2xl mb-4" alt="">

                        <h3 class="text-xl font-bold">Anna, 24</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">Podróże • Książki • Kawa</p>

                        <div class="w-full flex justify-center gap-10 mt-6">

                            <button class="w-20 h-20 rounded-full 
                                           bg-gradient-to-br from-red-400 to-red-600
                                           hover:from-red-500 hover:to-red-700
                                           shadow-xl hover:shadow-2xl
                                           flex items-center justify-center
                                           text-white text-4xl transition duration-200">
                                ✖
                            </button>

                            <button class="w-20 h-20 rounded-full 
                                           bg-gradient-to-br from-green-400 to-green-600
                                           hover:from-green-500 hover:to-green-700
                                           shadow-xl hover:shadow-2xl
                                           flex items-center justify-center
                                           text-white text-4xl transition duration-200">
                                ✔
                            </button>

                        </div>

                    </div>
                </div>

            </div>
        </section>

        {{-- SLIDE 2 --}}
        <section
            x-show="slide === 1"

            x-transition:enter="transition-opacity duration-700"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"

            x-transition:leave="transition-opacity duration-700"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"

            class="absolute inset-0 flex items-center justify-center px-6 md:px-12"
        >
            <div class="max-w-4xl text-center 
                        bg-white/70 dark:bg-gray-900/60 backdrop-blur-xl
                        rounded-3xl p-12 shadow-xl border border-white/50 dark:border-gray-700">

                <h2 class="text-4xl font-bold mb-10">Jak to działa?</h2>

                <div class="grid md:grid-cols-3 gap-10">

                    <div class="bg-white/60 dark:bg-gray-800 p-8 rounded-2xl backdrop-blur-lg">
                        <div class="text-4xl mb-3">🖼️</div>
                        <h3 class="text-xl font-semibold mb-2">1. Oglądasz profil</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Jedna osoba na ekranie - zero rozpraszaczy.
                        </p>
                    </div>

                    <div class="bg-white/60 dark:bg-gray-800 p-8 rounded-2xl backdrop-blur-lg">
                        <div class="text-4xl mb-3">✔ ✖</div>
                        <h3 class="text-xl font-semibold mb-2">2. Decydujesz</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Pasuje lub nie - jedno kliknięcie.
                        </p>
                    </div>

                    <div class="bg-white/60 dark:bg-gray-800 p-8 rounded-2xl backdrop-blur-lg">
                        <div class="text-4xl mb-3">💬</div>
                        <h3 class="text-xl font-semibold mb-2">3. Match & czat</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Jeśli oboje klikniecie ✔ - możecie pisać!
                        </p>
                    </div>

                </div>

            </div>
        </section>

        {{-- SLIDE 3 --}}
        <section
            x-show="slide === 2"

            x-transition:enter="transition-opacity duration-700"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"

            x-transition:leave="transition-opacity duration-700"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"

            class="absolute inset-0 flex flex-col items-center justify-center px-6 md:px-12 text-center"
        >
            <h2 class="text-4xl font-bold mb-4">Gotowy/a, by zacząć?</h2>

            <p class="text-gray-600 dark:text-gray-300 mb-8 text-lg">
                Rejestracja zajmie Ci mniej niż minutę.
            </p>

            <a href="{{ route('register') }}" 
               class="px-10 py-4 rounded-2xl text-white text-xl font-semibold
                      bg-gradient-to-r from-pink-500 to-blue-500
                      shadow-lg hover:shadow-xl transition-transform hover:scale-[1.03]">
                Załóż konto
            </a>
        </section>

    </div>
</div>

@endsection
