<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;

class LangController extends Controller
{
    private $availableLocales = ['en' => 'English', 'pl' => 'Polski'];

    public function show()
    {
        return view('lang.show', compact('availableLocales'));
    }
    public function switch($locale)
    {
        if (!key_exists($locale, $this->availableLocales)) {
            abort(404);
        }

        Session::put('locale', $locale);

        return redirect()->back();
    }
}
