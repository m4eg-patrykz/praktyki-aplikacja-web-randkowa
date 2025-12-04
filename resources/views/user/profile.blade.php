@extends('layouts.guest')

@section('content')

<div class="min-h-screen overflow-y-auto
            bg-gradient-to-br from-[#fce7f3] via-[#e0f2fe] to-[#ddd6fe]
            bg-gradient-to-br from-[#ffe4e6] via-[#e0f2fe] to-[#ddd6fe]
           dark:from-[#020617] dark:via-[#111827] dark:to-[#4c1d95]
            text-gray-900 dark:text-gray-100">

    {{-- PRZYCISK USTAWIEŃ – ZĘBATKA EMOJI --}}
    <a href="{{ url('/settings') }}"
       class="fixed top-4 left-4 z-30
              flex items-center justify-center
              w-10 h-10 rounded-full
              bg-white/90 text-gray-700 shadow-md border border-gray-200
              hover:bg-pink-50 hover:text-pink-600 hover:border-pink-300
              dark:bg-slate-900/90 dark:text-gray-200 dark:border-slate-700
              dark:hover:bg-slate-800 dark:hover:text-pink-300 dark:hover:border-pink-500
              transition">
        <span class="text-2xl leading-[0]">
            ⚙️
        </span>
    </a>

    {{-- jeden ekran, środek --}}
    <div class="h-full flex items-center justify-center px-4 py-8">

        {{-- PANEL PROFILU --}}
        <div class="w-full max-w-5xl
                    bg-white/95 dark:bg-slate-900/95
                    rounded-3xl shadow-[0_18px_45px_rgba(15,23,42,0.25)]
                    border border-white/70 dark:border-slate-800
                    px-6 sm:px-8 py-6 space-y-5">

            {{-- NAGŁÓWEK --}}
            <header class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">
                        Mój profil
                    </h1>
                    <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">
                        Uzupełnij swój profil, aby dopasowania lepiej do Ciebie pasowały.
                    </p>
                </div>

                <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold
                             bg-pink-100 text-pink-700 dark:bg-pink-900/40 dark:text-pink-200">
                    {{ auth()->user()->email }}
                </span>
            </header>

            {{-- KOMUNIKAT PO ZAPISANIU --}}
            @if(session('status'))
                <div class="rounded-xl border border-emerald-300/70 bg-emerald-50 px-4 py-3 text-xs text-emerald-900
                            dark:border-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-100">
                    {{ session('status') }}
                </div>
            @endif

            {{-- FORMULARZ --}}
            <form method="POST"
                  action="{{ route('user.profile.update') }}"
                  enctype="multipart/form-data"
                  class="space-y-5">
                @csrf

                {{-- AVATAR + DANE PODSTAWOWE --}}
                <section class="grid md:grid-cols-[auto,1fr] gap-10 md:gap-16 md:items-center">

                    {{-- AVATAR --}}
                    <div class="flex flex-col items-center gap-3">

                        <p class="text-[11px] font-medium text-gray-600 dark:text-gray-300">
                            Zdjęcie profilowe
                        </p>

                        @php $avatar = $user->avatar ?? null; @endphp

                        <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-pink-400/80 bg-gray-200 dark:bg-gray-800">
                            <img
                                id="avatarPreview"
                                src="{{ $avatar ? asset('storage/'.$avatar) : '' }}"
                                alt="Avatar"
                                class="w-full h-full object-cover @if(!$avatar) hidden @endif">

                            @if(!$avatar)
                                <div id="avatarPlaceholder"
                                     class="w-full h-full flex items-center justify-center text-3xl text-gray-400">
                                    👤
                                </div>
                            @endif
                        </div>

                        <label for="avatarInput"
                               class="inline-flex items-center justify-center rounded-full
                                      bg-pink-500 px-4 py-1.5 text-[11px] font-semibold text-white
                                      shadow-md hover:bg-pink-600 hover:shadow-lg cursor-pointer
                                      transition">
                            Wybierz plik
                        </label>

                        <input
                            id="avatarInput"
                            type="file"
                            name="avatar"
                            accept="image/*"
                            class="hidden">

                        <p id="avatarFilename"
                           class="text-[11px] text-gray-500 dark:text-gray-400 text-center">
                            Nie wybrano pliku
                        </p>

                        @error('avatar')
                            <p class="mt-1 text-[11px] text-red-500 text-center">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- IMIĘ, NAZWISKO, DATA URODZENIA + BIO --}}
                    <div class="grid sm:grid-cols-3 gap-4 md:pl-4">

                        {{-- Imię --}}
                        <div>
                            <label for="first_name" class="mb-1 block text-sm font-medium">Imię</label>
                            <input id="first_name"
                                   type="text"
                                   name="first_name"
                                   value="{{ old('first_name', $user->first_name ?? '') }}"
                                   class="w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm
                                          shadow-sm outline-none transition
                                          focus:border-pink-500 focus:ring-2 focus:ring-pink-200
                                          dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100
                                          dark:focus:border-pink-400 dark:focus:ring-pink-500/40">
                            @error('first_name')
                                <p class="mt-1 text-[11px] text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nazwisko --}}
                        <div>
                            <label for="last_name" class="mb-1 block text-sm font-medium">Nazwisko</label>
                            <input id="last_name"
                                   type="text"
                                   name="last_name"
                                   value="{{ old('last_name', $user->last_name ?? '') }}"
                                   class="w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm
                                          shadow-sm outline-none transition
                                          focus:border-pink-500 focus:ring-2 focus:ring-pink-200
                                          dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100
                                          dark:focus:border-pink-400 dark:focus:ring-pink-500/40">
                            @error('last_name')
                                <p class="mt-1 text-[11px] text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Data urodzenia (zamiast wieku) --}}
                        <div>
                            <label for="birth_date" class="mb-1 block text-sm font-medium">Data urodzenia</label>
                            <input id="birth_date"
                                   type="date"
                                   name="birth_date"
                                   value="{{ old('birth_date', $user->birth_date ?? '') }}"
                                   class="w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm
                                          shadow-sm outline-none transition
                                          focus:border-pink-500 focus:ring-2 focus:ring-pink-200
                                          dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100
                                          dark:focus:border-pink-400 dark:focus:ring-pink-500/40">
                            @error('birth_date')
                                <p class="mt-1 text-[11px] text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- BIO --}}
                        <div class="sm:col-span-3">
                            <label for="bio" class="mb-1 block text-sm font-medium">Biografia</label>
                            <textarea id="bio"
                                      name="bio"
                                      rows="3"
                                      class="w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm
                                             shadow-sm outline-none transition
                                             focus:border-pink-500 focus:ring-2 focus:ring-pink-200
                                             dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100
                                             dark:focus:border-pink-400 dark:focus:ring-pink-500/40"
                                      placeholder="Napisz kilka zdań o sobie...">{{ old('bio', $user->bio ?? '') }}</textarea>
                            @error('bio')
                                <p class="mt-1 text-[11px] text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </section>

                {{-- PŁEĆ + CHECKBOX TRANS --}}
                <section class="space-y-2">
                    <label class="block text-sm font-medium">Płeć</label>
                    @php
                        $gender  = old('gender', $user->gender);
                        $isTrans = old('is_trans', $user->is_trans ?? false);
                    @endphp

                    <div class="flex flex-wrap gap-2">
                        @foreach($genders as $value => $label)
                            <label class="inline-flex items-center gap-2 rounded-full border px-3 py-1.5 text-[11px] cursor-pointer
                                           @if($gender === $value)
                                               border-pink-500 bg-pink-50 text-pink-700
                                               dark:border-pink-500 dark:bg-pink-900/40 dark:text-pink-100
                                           @else
                                               border-gray-300 text-gray-700
                                               dark:border-gray-700 dark:text-gray-300
                                           @endif">
                                <input type="radio"
                                       name="gender"
                                       value="{{ $value }}"
                                       @checked($gender === $value)
                                       class="h-3 w-3 text-pink-500 focus:ring-pink-500 border-gray-300 dark:border-gray-600">
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>

                    @error('gender')
                        <p class="mt-1 text-[11px] text-red-500">{{ $message }}</p>
                    @enderror

                    <div class="mt-2 flex items-center gap-2">
                        <input type="checkbox"
                               id="is_trans"
                               name="is_trans"
                               value="1"
                               @checked($isTrans)
                               class="h-4 w-4 rounded border-gray-300 text-pink-500 focus:ring-pink-500 dark:border-gray-600">
                        <label for="is_trans" class="text-[11px] text-gray-700 dark:text-gray-300">
                            Jestem osobą transpłciową
                        </label>
                    </div>

                    @error('is_trans')
                        <p class="mt-1 text-[11px] text-red-500">{{ $message }}</p>
                    @enderror
                </section>

                {{-- ORIENTACJA --}}
                <section class="space-y-2">
                    <label for="orientation" class="block text-sm font-medium">Orientacja</label>
                    <select id="orientation" name="orientation"
                            class="w-full sm:max-w-md rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm
                                   shadow-sm outline-none transition
                                   focus:border-pink-500 focus:ring-2 focus:ring-pink-200
                                   dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100
                                   dark:focus:border-pink-400 dark:focus:ring-pink-500/40">
                        <option value="">Wybierz...</option>
                        @foreach($orientations as $value => $label)
                            <option value="{{ $value }}"
                                @selected(old('orientation', $user->orientation) === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('orientation')
                        <p class="mt-1 text-[11px] text-red-500">{{ $message }}</p>
                    @enderror
                </section>

                {{-- ZAINTERESOWANIA --}}
                <section class="space-y-2">
                    <label class="block text-sm font-medium">Zainteresowania</label>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 mb-1">
                        Wybierz kilka rzeczy, które najlepiej Cię opisują.
                    </p>

                    @php
                        $userInterests = collect(json_decode($user->interests ?? '[]', true));
                        if ($userInterests->isEmpty() && is_array(old('interests'))) {
                            $userInterests = collect(old('interests'));
                        }
                    @endphp

                    <div class="flex flex-wrap gap-2">
                        @foreach($interestsList as $interest)
                            <label class="inline-flex items-center gap-2 rounded-full border px-3 py-1.5 text-[11px] cursor-pointer
                                           @if($userInterests->contains($interest))
                                               border-pink-500 bg-pink-50 text-pink-700 dark:border-pink-500 dark:bg-pink-900/40 dark:text-pink-100
                                           @else
                                               border-gray-300 text-gray-700 dark:border-gray-700 dark:text-gray-300
                                           @endif">
                                <input type="checkbox"
                                       name="interests[]"
                                       value="{{ $interest }}"
                                       @checked($userInterests->contains($interest))
                                       class="h-3 w-3 text-pink-500 focus:ring-pink-500 border-gray-300 dark:border-gray-600">
                                <span>{{ $interest }}</span>
                            </label>
                        @endforeach
                    </div>

                    @error('interests')
                        <p class="mt-1 text-[11px] text-red-500">{{ $message }}</p>
                    @enderror
                </section>

                {{-- PRZYCISK ZAPISU --}}
                <div class="pt-1 flex justify-end">
                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-full
                                   bg-purple-600 px-6 py-2 text-sm font-semibold text-white
                                   shadow-md hover:bg-purple-700 hover:shadow-lg
                                   focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2
                                   dark:bg-purple-500 dark:hover:bg-purple-400">
                        Zapisz profil
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input       = document.getElementById('avatarInput');
        const preview     = document.getElementById('avatarPreview');
        const placeholder = document.getElementById('avatarPlaceholder');
        const filename    = document.getElementById('avatarFilename');

        if (!input) return;

        input.addEventListener('change', function (e) {
            const file = e.target.files[0];

            if (filename) {
                filename.textContent = file ? file.name : 'Nie wybrano pliku';
            }

            if (!file || !file.type.startsWith('image/')) {
                return;
            }

            const reader = new FileReader();
            reader.onload = function (event) {
                if (preview) {
                    preview.src = event.target.result;
                    preview.classList.remove('hidden');
                }
                if (placeholder) {
                    placeholder.classList.add('hidden');
                }
            };
            reader.readAsDataURL(file);
        });
    });
</script>

@endsection
