@extends('layouts.guest')

@section('content')

<div class="min-h-screen flex items-center justify-center px-4 py-10
            bg-gradient-to-br from-[#fce7f3] via-[#e0f2fe] to-[#ddd6fe]
            dark:bg-gray-900 text-gray-900 dark:text-gray-100">

    <div class="w-full max-w-3xl 
                bg-white/95 dark:bg-gray-900/95 
                rounded-3xl shadow-[0_18px_45px_rgba(15,23,42,0.25)]
                border border-white/70 dark:border-gray-800
                px-6 sm:px-8 py-7 space-y-6">

        {{-- NAGŁÓWEK --}}
        <div class="flex items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold">Mój profil</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Uzupełnij swój profil, aby dopasowania lepiej do Ciebie pasowały.
                </p>
            </div>

            {{-- mały „badge” --}}
            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold
                         bg-pink-100 text-pink-700 dark:bg-pink-900/40 dark:text-pink-200">
                {{ auth()->user()->email }}
            </span>
        </div>

        {{-- KOMUNIKAT PO ZAPISANIU --}}
        @if(session('status'))
            <div class="rounded-xl border border-emerald-300/70 bg-emerald-50 px-4 py-3 text-sm text-emerald-900
                        dark:border-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-100">
                {{ session('status') }}
            </div>
        @endif

        {{-- FORMULARZ PROFILU --}}
        <form method="POST"
              action="{{ route('user.profile.update') }}"
              enctype="multipart/form-data"
              class="space-y-6">
            @csrf

            {{-- SEKCA: AVATAR + IMIĘ I NAZWISKO --}}
            <div class="flex flex-col md:flex-row gap-6 md:items-center">

                {{-- AVATAR --}}
                <div class="flex flex-col items-center gap-3">
                    <div class="w-28 h-28 rounded-full overflow-hidden border-2 border-pink-400/80 bg-gray-200 dark:bg-gray-800">
                        @php
                            $avatar = $user->avatar ?? null;
                        @endphp
                        @if($avatar)
                            <img src="{{ asset('storage/'.$avatar) }}"
                                 alt="Avatar"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-4xl text-gray-400">
                                👤
                            </div>
                        @endif
                    </div>

                    <label class="text-xs font-medium text-gray-600 dark:text-gray-300">
                        Zdjęcie profilowe
                        <input type="file"
                               name="avatar"
                               accept="image/*"
                               class="mt-1 block w-full text-xs text-gray-600 dark:text-gray-300
                                      file:mr-3 file:rounded-full file:border-0
                                      file:bg-pink-500 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white
                                      hover:file:bg-pink-600">
                    </label>

                    @error('avatar')
                        <p class="mt-1 text-xs text-red-500 text-center">{{ $message }}</p>
                    @enderror
                </div>

                {{-- IMIĘ I NAZWISKO + WIEK --}}
                <div class="flex-1 space-y-4">
                    <div>
                        <label for="name" class="mb-1 block text-sm font-medium">Imię i nazwisko</label>
                        <input id="name"
                               type="text"
                               name="name"
                               value="{{ old('name', $user->name) }}"
                               class="w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm
                                      shadow-sm outline-none transition
                                      focus:border-pink-500 focus:ring-2 focus:ring-pink-200
                                      dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100
                                      dark:focus:border-pink-400 dark:focus:ring-pink-500/40">
                        @error('name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="age" class="mb-1 block text-sm font-medium">Wiek</label>
                        <input id="age"
                               type="number"
                               name="age"
                               min="18" max="100"
                               value="{{ old('age', $user->age) }}"
                               class="w-32 rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm
                                      shadow-sm outline-none transition
                                      focus:border-pink-500 focus:ring-2 focus:ring-pink-200
                                      dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100
                                      dark:focus:border-pink-400 dark:focus:ring-pink-500/40">
                        @error('age')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- PŁEĆ --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium">Płeć</label>
                @php
                    $gender = old('gender', $user->gender);
                @endphp

                <div class="flex flex-wrap gap-3">
                    @foreach([ 'M' => 'Mężczyzna', 'K' => 'Kobieta', 'NB' => 'Niebinarne' ] as $value => $label)
                        <label class="inline-flex items-center gap-2 rounded-full border px-3 py-1.5 text-xs cursor-pointer
                                       @if($gender === $value)
                                           border-pink-500 bg-pink-50 text-pink-700 dark:border-pink-500 dark:bg-pink-900/40 dark:text-pink-100
                                       @else
                                           border-gray-300 text-gray-700 dark:border-gray-700 dark:text-gray-300
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
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- ORIENTACJA --}}
            <div class="space-y-2">
                <label for="orientation" class="block text-sm font-medium">Orientacja</label>
                <select id="orientation" name="orientation"
                        class="w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm
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
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- ZAINTERESOWANIA --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium">Zainteresowania</label>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                    Wybierz kilka rzeczy, które najlepiej Cię opisują.
                </p>

                @php
                    // jeśli przechowujemy jako JSON w bazie:
                    $userInterests = collect(json_decode($user->interests ?? '[]', true));
                    if ($userInterests->isEmpty() && is_array(old('interests'))) {
                        $userInterests = collect(old('interests'));
                    }
                @endphp

                <div class="flex flex-wrap gap-2">
                    @foreach($interestsList as $interest)
                        <label class="inline-flex items-center gap-2 rounded-full border px-3 py-1.5 text-xs cursor-pointer
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
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- PRZYCISK ZAPISU --}}
            <div class="pt-2 flex justify-end">
                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-full
                               bg-purple-600 px-6 py-2.5 text-sm font-semibold text-white
                               shadow-md hover:bg-purple-700 hover:shadow-lg
                               focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2
                               dark:bg-purple-500 dark:hover:bg-purple-400">
                    Zapisz profil
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
