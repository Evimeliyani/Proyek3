<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AiInsightService
{
    public function generateInsight(array $payload): string
    {
        $apiKey = config('services.openai.key');

        $prompt = "Kamu adalah asisten guru SD.
Analisis perkembangan nilai matematika siswa berdasarkan data berikut.

Output WAJIB format:
1) Ringkasan
2) Kekuatan
3) Kelemahan
4) Rekomendasi latihan 1 minggu (harian)

Jangan mengarang nilai di luar data.

DATA (JSON):
" . json_encode($payload, JSON_UNESCAPED_UNICODE);

        $resp = Http::withToken($apiKey)
            ->acceptJson()
            ->contentType('application/json')
            ->post('https://api.openai.com/v1/responses', [
                'model' => 'gpt-5.2',
                'input' => $prompt,
            ]);

        if (!$resp->successful()) {
            return "AI gagal dipanggil. Cek OPENAI_API_KEY. (" . $resp->status() . ")";
        }

        $json = $resp->json();

        $text = '';
        foreach (($json['output'] ?? []) as $item) {
            if (($item['type'] ?? '') === 'message') {
                foreach (($item['content'] ?? []) as $c) {
                    if (($c['type'] ?? '') === 'output_text') {
                        $text .= $c['text'] ?? '';
                    }
                }
            }
        }

        return trim($text) ?: 'AI tidak mengembalikan teks.';
    }
}
