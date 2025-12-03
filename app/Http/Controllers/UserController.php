<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\SexualOrientation;
use App\Models\Gender;
use App\Models\Hobby;

class UserController extends Controller
{
    private function getDictionaries()
    {
        return [
            'genders' => Gender::pluck('code')->toArray(),
            'orientations' => SexualOrientation::pluck('code')->toArray(),
            'hobbyCodes' => Hobby::pluck('code')->toArray(),
        ];
    }

    public function home()
    {
        $userId = auth()->id();
        $profileUser = User::where('id', '!=', $userId)
            ->inRandomOrder()
            ->first();

        return view('user.home', compact('profileUser'));
    }

    public function matches()
    {
        return view('user.matches');
    }

    public function profile()
    {
        $user = auth()->user();
        $genders = Gender::pluck('label', 'code')->toArray();
        $orientations = SexualOrientation::pluck('label', 'code')->toArray();
        $interestsList = Hobby::pluck('label', 'code')->toArray();

        return view('user.profile', compact('user', 'genders', 'orientations', 'interestsList'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $dicts = $this->getDictionaries();

        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:18', 'max:100'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'gender' => ['required', 'in:' . implode(',', $dicts['genders'])],
            'orientation' => ['required', 'in:' . implode(',', $dicts['orientations'])],
            'interests' => ['nullable', 'array'],
            'interests.*' => ['in:' . implode(',', $dicts['hobbyCodes'])],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->bio = $data['bio'] ?? null;
        // $user->age = $data['age'] ?? null; zmienione na date_of_birth w migracji
        // $user->gender = $data['gender'] ?? null; przerobic na relacje one=to-many
        // $user->orientation = $data['orientation'] ?? null; przerobic na relacje one-to-many
        // $user->interests = json_encode($data['interests'] ?? []); przerobic na relacje many-to-many

        $user->save();

        return redirect()
            ->route('user.profile')
            ->with('status', 'Profil został zaktualizowany ✅');
    }
}
