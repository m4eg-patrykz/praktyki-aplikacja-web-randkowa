@extends('layouts.guest')

@section('content')



    <div :class="dark 
                ? 'min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-gray-100' 
                : 'min-h-screen bg-gradient-to-br from-[#ffffff] via-[#f9f5ff] to-[#f0f7ff] text-gray-800'"
        class="transition-colors duration-500">



        {{-- HERO --}}
        <section class="px-6 md:px-12 py-20 fade">
            <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-12 items-center">

                <div>
                    <h1 class="text-5xl font-extrabold leading-tight mb-6">
                        Poznawaj ludzi <span class="text-pink-500 dark:text-pink-400">naturalnie i bez stresu.</span>
                    </h1>

                    <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">
                        Oglądasz profile jeden po drugim.
                        Klikasz <strong>✔ pasuje</strong> lub <strong>✖ nie pasuje</strong>.
                        Jeśli oboje się polubicie — tworzy się <strong>match i możecie pisać!</strong>
                    </p>

                    <a href="{{ route('register') }}"
                        class="px-8 py-4 bg-pink-500 hover:bg-pink-600 text-white rounded-xl text-lg font-semibold shadow-lg transition">
                        Dołącz teraz
                    </a>
                </div>

                <div class="relative flex justify-center fade">
                    <div class="w-72 h-96 
                    bg-white 
                    dark:bg-gray-800 
                    rounded-3xl 
                    shadow-[0_8px_30px_rgb(0,0,0,0.06)]
                    dark:shadow-[0_8px_30px_rgba(0,0,0,0.4)]
                    border border-gray-100 
                    dark:border-gray-700 
                    p-4">

                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=400&q=80"
                            class="w-full h-64 object-cover rounded-2xl mb-4" alt="">

                        <h3 class="text-xl font-bold">Anna, 24</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">Podróże • Książki • Kawa</p>

                        <div class="w-full flex justify-center gap-10 mt-6">

                            <div class="flex justify-center gap-10 mt-auto">

                                <!-- ODRZUĆ (CZERWONY) -->
                                <button class="w-20 h-20 rounded-full 
                           bg-gradient-to-br from-red-400 to-red-600
                           hover:from-red-500 hover:to-red-700
                           shadow-xl hover:shadow-2xl
                           flex items-center justify-center
                           text-white text-4xl
                           transition duration-200">
                                    ✖
                                </button>

                                <!-- AKCEPTUJ (ZIELONY) -->
                                <button class="w-20 h-20 rounded-full 
                           bg-gradient-to-br from-green-400 to-green-600
                           hover:from-green-500 hover:to-green-700
                           shadow-xl hover:shadow-2xl
                           flex items-center justify-center
                           text-white text-4xl
                           transition duration-200">
                                    ✔
                                </button>

                            </div>


                        </div>
                    </div>
                </div>

            </div>
        </section>

        {{-- JAK TO DZIAŁA --}}
        <section class="px-6 md:px-12 py-24 bg-white dark:bg-gray-900 fade border-t border-gray-200 dark:border-gray-700">
            <div class="max-w-5xl mx-auto text-center mb-12">
                <h2 class="text-4xl font-bold mb-4">Jak to działa?</h2>
                <p class="text-gray-600 dark:text-gray-300">
                    Prosto. Intuicyjnie. Bez zbędnych funkcji.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-10 max-w-6xl mx-auto">

                <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-2xl shadow text-center">
                    <div class="text-4xl mb-3">🖼️</div>
                    <h3 class="text-2xl font-semibold mb-2">1. Oglądasz profil</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Jedna osoba na ekranie — zero rozpraszaczy.
                    </p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-2xl shadow text-center">
                    <div class="text-4xl mb-3">✔ ✖</div>
                    <h3 class="text-2xl font-semibold mb-2">2. Decydujesz</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Pasuje lub nie — jedno kliknięcie.
                    </p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-2xl shadow text-center">
                    <div class="text-4xl mb-3">💬</div>
                    <h3 class="text-2xl font-semibold mb-2">3. Match & czat</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Jeśli oboje klikniecie ✔ — możecie pisać!
                    </p>
                </div>

            </div>
        </section>

        {{-- CTA --}}
        <section class="px-6 md:px-12 py-24 text-center fade">
            <h2 class="text-4xl font-bold mb-4">Gotowy/a, by zacząć?</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-8">
                Rejestracja zajmie Ci mniej niż minutę.
            </p>

            <a href="{{ route('register') }}" class="px-10 py-4 rounded-2xl text-white text-xl font-semibold
                  bg-gradient-to-r from-pink-500 to-blue-500
                  shadow-lg hover:shadow-xl
                  transition-transform hover:scale-[1.03]">
                Załóż konto
            </a>
        </section>

    </div>

@endsection