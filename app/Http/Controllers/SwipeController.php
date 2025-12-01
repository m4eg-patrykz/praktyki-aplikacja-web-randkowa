<?php

namespace App\Http\Controllers;

use App\Models\Swipe;
use Illuminate\Http\Request;

class SwipeController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'target_user_id' => ['required', 'exists:users,id'],
            'decision'       => ['required', 'in:yes,no'],
        ]);

        Swipe::updateOrCreate(
            [
                'user_id'        => auth()->id(),
                'target_user_id' => $data['target_user_id'],
            ],
            [
                'decision'       => $data['decision'],
            ]
        );

        // tutaj później możesz sprawdzić, czy druga strona też kliknęła "yes"
        // i utworzyć rekord 'Match'

        return redirect()->route('user.dashboard');
    }
}
