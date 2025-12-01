<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserController extends Controller
{
    public function home()
    {
        $userId = auth()->id();

        // Tu możesz później wstawić logikę losowania profilu
        $profileUser = User::where('id', '!=', $userId)
            ->inRandomOrder()
            ->first();

        return view('user.home', compact('profileUser'));
    }

    public function matches()
    {
        // Na razie placeholder, żeby route nie wywalał błędu
        return view('user.matches');
    }

    public function profile()
    {
        $user = auth()->user();

        // lista orientacji
        $orientations = [
            'hetero' => 'Heteroseksualna',
            'homo'   => 'Homoseksualna',
            'bi'     => 'Biseksualna',
            'pan'    => 'Panseksualna',
            'ace'    => 'Aseksualna',
            'other'  => 'Inna / nie chcę podawać',
        ];

        // lista zainteresowań
        $interestsList = [
            'Podróże',
            'Książki',
            'Filmy i seriale',
            'Muzyka',
            'Imprezy i wyjścia',
            'Sport / fitness',
            'Gaming',
            'Gotowanie',
            'Sztuka i kultura',
            'Zwierzęta',
            'Przyroda',
            'Technologia',
            'Fotografia',
            'Kawa / herbata',
            'Rozwój osobisty',
        ];

        return view('user.profile', compact('user', 'orientations', 'interestsList'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $orientations = ['hetero', 'homo', 'bi', 'pan', 'ace', 'other'];
        $genders      = ['M', 'K', 'NB'];

        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'age'         => ['nullable', 'integer', 'min:18', 'max:100'],
            'gender'      => ['nullable', 'in:'.implode(',', $genders)],
            'orientation' => ['nullable', 'in:'.implode(',', $orientations)],
            'interests'   => ['nullable', 'array'],
            'interests.*' => ['string', 'max:100'],
            'avatar'      => ['nullable', 'image', 'max:2048'], // 2MB
        ]);

        // AVATAR
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->name        = $data['name'];
        $user->age         = $data['age'] ?? null;
        $user->gender      = $data['gender'] ?? null;
        $user->orientation = $data['orientation'] ?? null;

        // Zainteresowania jako JSON
        if (!empty($data['interests'])) {
            $user->interests = json_encode(array_values($data['interests']));
        } else {
            $user->interests = json_encode([]);
        }

        $user->save();

        return redirect()
            ->route('user.profile')
            ->with('status', 'Profil został zaktualizowany ✅');
    }
}
