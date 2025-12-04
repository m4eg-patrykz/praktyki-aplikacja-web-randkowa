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
            'genderIds' => Gender::pluck('id')->toArray(),
            'orientationIds' => SexualOrientation::pluck('id')->toArray(),
            'hobbyIds' => Hobby::pluck('id')->toArray(),
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
        $genders = Gender::pluck('label', 'id')->toArray();
        $orientations = SexualOrientation::pluck('label', 'id')->toArray();
        $interestsList = Hobby::pluck('label', 'id')->toArray();

        return view('user.profile', compact('user', 'genders', 'orientations', 'interestsList'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $dicts = $this->getDictionaries();

        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date', 'before:-18 years', 'after:-100 years'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'gender' => ['required', 'in:' . implode(',', $dicts['genderIds'])],
            'transgender' => ['nullable', 'boolean'],
            'orientation' => ['required', 'in:' . implode(',', $dicts['orientationIds'])],
            'interests' => ['nullable', 'array'],
            'interests.*' => ['in:' . implode(',', $dicts['hobbyIds'])],
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
        $user->bio = $data['bio'];
        $user->date_of_birth = $data['date_of_birth'];
        $user->gender_id = $data['gender'];
        $user->transgender = $data['transgender'] ?? false;
        $user->sexual_orientation_id = $data['orientation'];
        // $user->interests = json_encode($data['interests'] ?? []); przerobic na relacje many-to-many

        $user->save();

        return redirect()
            ->route('user.profile')
            ->with('status', 'Profil został zaktualizowany ✅');
    }
}
