
@extends('layouts.user')

@section('content')

<div 
    class="min-h-screen flex flex-col text-gray-900 dark:text-gray-100
           bg-gradient-to-br from-[#ffe4e6] via-[#e0f2fe] to-[#ddd6fe]
           dark:from-[#020617] dark:via-[#111827] dark:to-[#4c1d95]">



    {{-- GŁÓWNA SEKCJA – PROFIL DO OCENY --}}
    <div class="flex-1 flex items-center justify-center px-4 pb-24">

        @php
            $profile = $profileUser ?? null;
        @endphp

        @if($profile)
            <div class="w-full max-w-5xl">

                {{-- KARTA NA CAŁĄ SZEROKOŚĆ --}}
                <div class="relative rounded-3xl overflow-hidden
                            bg-white/95 dark:bg-gray-900/95
                            shadow-[0_18px_45px_rgba(15,23,42,0.25)]
                            border border-white/70 dark:border-gray-800">

                    <div class="grid md:grid-cols-2">

                        {{-- LEWO: ZDJĘCIE --}}
                        <div class="relative h-[420px] md:h-[480px]">
                            <img src="{{ $profile->avatar_url ?? 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=1000&q=80' }}"
                                 alt="{{ $profile->name ?? 'Użytkownik' }}"
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/45 via-transparent to-transparent"></div>

                            <div class="absolute bottom-4 left-5 text-white drop-shadow-md">
                                <div class="text-3xl font-extrabold">
                                    {{ $profile->name ?? 'Anna' }},
                                    @if(!empty($profile->age))
                                        {{ $profile->age }}
                                    @else
                                        24
                                    @endif
                                </div>
                                <div class="text-sm opacity-90">
                                    {{ $profile->city ?? 'Warszawa' }}
                                </div>
                            </div>
                        </div>

                        {{-- PRAWO: OPIS + TAGI + PRZYCISKI --}}
                        <div class="flex flex-col h-full p-6 md:p-8 gap-6">

                            {{-- krótki opis --}}
                            <div class="space-y-3">
                                <h2 class="text-xl font-semibold">
                                    O {{ $profile->name ?? 'mnie' }}
                                </h2>

                                <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                                    @if(!empty($profile->bio))
                                        {{ $profile->bio }}
                                    @else
                                        Lubię spontan, dobre jedzenie i długie rozmowy. 
                                        Szukam kogoś, z kim będzie można się pośmiać,
                                        pojechać na weekend i po prostu dobrze spędzić czas. ✨
                                    @endif
                                </p>
                            </div>

                            {{-- zainteresowania --}}
                            @php
                                $interests = $profile->interests ?? ['Podróże', 'Książki', 'Kawa'];
                            @endphp

                            <div class="space-y-2">
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    Zainteresowania
                                </p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($interests as $tag)
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium
                                                     bg-pink-50 text-pink-700
                                                     dark:bg-pink-900/40 dark:text-pink-200">
                                            {{ $tag }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            {{-- PRZYcisKI NA DOLE PRAWEJ KOLUMNY --}}
                            <div class="mt-auto flex items-center justify-center md:justify-end gap-8 pt-4">

                                {{-- NIE PASUJE --}}
                                <form method="POST" action="{{ route('user.swipes.store') }}">
                                    @csrf
                                    <input type="hidden" name="target_user_id" value="{{ $profile->id }}">
                                    <input type="hidden" name="decision" value="no">

                                    <button type="submit"
                                            class="w-20 h-20 rounded-full 
                                                   bg-gradient-to-br from-red-400 to-red-600
                                                   hover:from-red-500 hover:to-red-700
                                                   shadow-xl hover:shadow-2xl
                                                   flex items-center justify-center
                                                   text-white text-4xl
                                                   transition duration-200">
                                        ✖
                                    </button>
                                </form>

                                {{-- PASUJE --}}
                                <form method="POST" action="{{ route('user.swipes.store') }}">
                                    @csrf
                                    <input type="hidden" name="target_user_id" value="{{ $profile->id }}">
                                    <input type="hidden" name="decision" value="yes">

                                    <button type="submit"
                                            class="w-20 h-20 rounded-full 
                                                   bg-gradient-to-br from-green-400 to-green-600
                                                   hover:from-green-500 hover:to-green-700
                                                   shadow-xl hover:shadow-2xl
                                                   flex items-center justify-center
                                                   text-white text-4xl
                                                   transition duration-200">
                                        ✔
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
@else
    {{-- STAN: BRAK OSÓB DO POKAZANIA --}}
    <div class="text-center space-y-4 max-w-md mx-auto">
        <p class="text-lg font-semibold">
            Na ten moment nie mamy więcej profili do pokazania. 💔
        </p>
        <p class="text-sm text-gray-700 dark:text-gray-300">
            Wróć później albo uzupełnij swój profil, żeby zwiększyć szanse na znalezienie matchy.
        </p>

        <a href="{{ route('user.profile') }}"
           class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold
                  rounded-full border
                  bg-white text-pink-600 border-pink-300
                  hover:bg-pink-50 hover:border-pink-400 hover:shadow-md
                  dark:bg-black dark:text-pink-400 dark:border-pink-500
                  dark:hover:bg-gray-900 dark:hover:border-pink-400 dark:hover:text-pink-300 dark:hover:shadow-md
                  transition-colors transition-shadow duration-150">
            Przejdź do mojego profilu
        </a>
    </div>
@endif



    </div>

    

</div>

@endsection
