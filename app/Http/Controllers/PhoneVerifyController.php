<?php

namespace App\Http\Controllers;

use App\Models\PhoneVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PhoneVerifyController extends Controller
{
    public function show(Request $request)
    {
        return view('auth.verify-phone');
    }

    public function sendCode(Request $request)
    {
        $user = $request->user();

        // 1. Walidacja osobno kierunkowego i numeru
        $validated = $request->validate([
            'phone_country_code' => ['required', 'string', 'max:5'],
            'phone_number' => ['required', 'string', 'max:20'],
        ]);

        $country = $validated['phone_country_code'];
        $number = $validated['phone_number'];

        // 2. Zapisujemy telefon w users (dostosuj nazwy kolumn do bazy)
        // zakładam: phone_country_code, phone_number, phone_verified_at
        $user->phone_country_code = $country;
        $user->phone_number = $number;
        $user->phone_verified_at = null; // na wszelki wypadek przy zmianie numeru
        $user->save();

        $fullPhone = trim($country . ' ' . $number);

        // 3. BLOKADA: max 1 kod na 60 sekund
        $last = PhoneVerification::where('user_id', $user->id)
            ->orderByDesc('id')
            ->first();

        if ($last && $last->sent_at && $last->sent_at->diffInSeconds(now()) < 60) {
            // dopasowane do Twojego widoku: session('error') === 'wait-before-resend'
            return back()->with('error', 'wait-before-resend');
        }

        // 4. GENERUJEMY KOD – tu właśnie brakowało:
        $code = random_int(100000, 999999);

        // 5. Zapis do osobnej tabeli phone_verifications
        PhoneVerification::create([
            'user_id' => $user->id,
            'phone' => $fullPhone,
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
            'sent_at' => now(),
        ]);

        // 6. Tymczasowo wysyłamy kod mailem (później SMS)
        Mail::raw("Twój kod weryfikacyjny: {$code}", function ($msg) use ($user) {
            $msg->to($user->email)->subject('Kod weryfikacyjny telefonu');
        });

        // dopasowane do widoku: session('status') == 'phone-verification-sent'
        return back()->with('status', 'phone-verification-sent');
    }

    public function checkCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'verification_code' => ['required', 'digits:6'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('phone.verification.notice')
                ->with('status', 'phone-verification-sent')
                ->with('error', 'code-invalid');
        }
        $user = $request->user();

        $verification = PhoneVerification::where('user_id', $user->id)
            ->where('verified', false)
            ->orderByDesc('id')
            ->first();

        if (!$verification) {
            return redirect()->route('phone.verification.notice')
                ->with('error', 'no-active-code');
        }

        if ($verification->expires_at && $verification->expires_at->isPast()) {
            return redirect()->route('phone.verification.notice')
                ->with('error', 'code-expired');
        }

        if ($verification->code !== $request->verification_code) {
            return redirect()->route('phone.verification.notice')
                ->with('status', 'phone-verification-sent')
                ->with('error', 'code-invalid');
        }

        // Oznaczamy kod jako użyty
        $verification->update([
            'verified' => true,
            'verified_at' => now(),
        ]);

        // Zaznaczamy telefon jako zweryfikowany
        $user->update([
            'phone_verified_at' => now(),
        ]);

        // Widok ma blok: session('status') === 'phone-verification-completed'
        return redirect()
            ->route('phone.verification.notice')
            ->with('status', 'phone-verification-completed');
    }
}
