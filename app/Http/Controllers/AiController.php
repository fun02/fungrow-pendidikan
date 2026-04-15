<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class AiController extends Controller
{
    private function callGemini($prompt)
    {
        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) return "Error: API Key belum dipasang di .env";

        try {
            $response = Http::timeout(30)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $apiKey, [
                'contents' => [['parts' => [['text' => $prompt]]]]
            ]);

            if ($response->failed()) return "Google API Error: " . $response->body();

            return $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? 'Format respon AI tidak dikenal.';
        } catch (\Exception $e) {
            return "Koneksi Gagal: " . $e->getMessage();
        }
    }

    public function summarize(Request $request)
    {
        return response()->json(['result' => $this->callGemini("Rangkum percakapan kelas ini dalam poin-poin singkat yang rapi:\n\n" . $request->history)]);
    }

    public function ask(Request $request)
    {
        return response()->json(['result' => $this->callGemini("Berdasarkan konteks percakapan berikut:\n" . $request->history . "\n\nTolong jawab pertanyaan ini: " . $request->question)]);
    }

    public function sendOtpEmail(Request $request)
    {
        $email = $request->input('email');
        $otp = rand(100000, 999999);

        try {
            Mail::raw("Halo! Kode OTP FunGrow Anda adalah: {$otp}. Jangan berikan kode ini kepada siapapun.", function ($message) use ($email) {
                $message->to($email)->subject('Kode Verifikasi FunGrow');
            });

            return response()->json([
                'success' => true,
                'otp' => $otp
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
