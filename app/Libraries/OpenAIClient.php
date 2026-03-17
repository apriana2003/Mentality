<?php
// app/Libraries/OpenAIClient.php
namespace App\Libraries;

class OpenAIClient
{
    private string $apiKey;
    private string $model;
    private int    $maxTokens;
    private string $endpoint = 'https://api.groq.com/openai/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey    = env('openai.apiKey', '');
        $this->model     = env('openai.model', 'llama-3.3-70b-versatile');
        $this->maxTokens = (int) env('openai.maxTokens', 800);
    }

    /**
     * Kirim pesan ke AI dan kembalikan teks respons.
     */
    public function chat(array $messages, array $hasilTes = []): string
    {
        if (empty($this->apiKey) || str_starts_with($this->apiKey, 'gsk_GANTI')) {
            return '⚠️ API Key belum diisi. Silakan isi `openai.apiKey` di file `.env` dengan Groq API Key kamu.';
        }

        $systemPrompt = $this->buildSystemPrompt($hasilTes);

        $payload = [
            'model'       => $this->model,
            'max_tokens'  => $this->maxTokens,
            'temperature' => 0.85,
            'messages'    => array_merge(
                [['role' => 'system', 'content' => $systemPrompt]],
                $messages
            ),
        ];

        $ch = curl_init($this->endpoint);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->apiKey,
            ],
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);

        $raw    = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err    = curl_error($ch);
        curl_close($ch);

        if ($err) {
            log_message('error', "Groq cURL error: {$err}");
            return '⚠️ Aduh, koneksinya lagi bermasalah nih. Coba lagi ya!';
        }

        if ($status !== 200) {
            $body = json_decode($raw, true);
            $msg  = $body['error']['message'] ?? 'Unknown error';
            log_message('error', "Groq HTTP [{$status}]: {$msg} | Raw: {$raw}");

            return match($status) {
                401 => '⚠️ API Key-nya kayaknya salah deh. Cek lagi file `.env` ya!',
                429 => '⚠️ Wah, lagi rame banget nih. Tunggu bentar terus coba lagi ya 🙏',
                503 => '⚠️ Server AI-nya lagi istirahat sebentar. Coba lagi dalam beberapa detik!',
                default => "⚠️ Ada error nih (HTTP {$status}). Coba lagi nanti ya!",
            };
        }

        $data = json_decode($raw, true);
        return trim($data['choices'][0]['message']['content'] ?? 'Eh, AI-nya bingung nih. Coba tanya lagi ya!');
    }

    private function buildSystemPrompt(array $hasilTes = []): string
    {
        $prompt = <<<PROMPT
Kamu adalah Mentality AI — teman curhat digital yang asik, relate, dan ngerti banget soal kesehatan mental.
Kamu ngobrol kayak temen sebaya yang supportif, bukan kayak dokter atau guru yang kaku.

GAYA BAHASA:
- Pakai bahasa gaul kekinian yang natural — "gue/lo", "sih", "dong", "nih", "deh", "banget", "kayak", "beneran", "relate", "healing", "overthinking", "mager", "gabut", dll
- Tapi tetap sopan dan tidak kasar ya
- Boleh pakai singkatan: "yg", "dgn", "krn", "utk", "tp", "kalo", "gimana", "emang"
- Sesekali pakai emoji biar lebih hidup 😊✨💪
- Jangan terlalu formal, hindari kata "Anda", "saya" — pakai "lo/gue" atau "kamu/aku"
- Nada santai tapi tetap peduli dan serius waktu topiknya butuh keseriusan

CARA MERESPONS:
1. Mulai dengan validasi perasaan dulu — bikin mereka ngerasa didengar
2. Baru kasih info atau saran yang helpful
3. Sesekali tanya balik biar obrolan lebih hidup
4. Kalau kondisinya serius, tetap empati tapi arahkan ke profesional dengan cara yang ga menggurui
5. Respons maksimal 3-4 paragraf — jangan kepanjangan

BATASAN:
- Jangan kasih diagnosis medis resmi
- Kalau ada tanda-tanda krisis atau self-harm, langsung kasih hotline: Into The Light 119 ext 8
- Tetap berbasis ilmu psikologi meskipun bahasanya santai

Contoh gaya bahasa yang benar:
"Duh, kedengarannya berat banget sih yang lo rasain 😔 Wajar banget kok kalo lo ngerasa kayak gitu. Btw, lo udah berapa lama ngerasain ini?"

Contoh yang SALAH (terlalu kaku):
"Saya memahami kondisi Anda. Berdasarkan gejala yang Anda ceritakan..."
PROMPT;

        if (!empty($hasilTes)) {
            $prompt .= "\n\nFYI — ini hasil tes DASS-21 temen lo yang lagi chat:\n";
            $prompt .= "• Depresi    : Skor {$hasilTes['skor_depresi']} → {$hasilTes['kategori_depresi']}\n";
            $prompt .= "• Kecemasan  : Skor {$hasilTes['skor_kecemasan']} → {$hasilTes['kategori_kecemasan']}\n";
            $prompt .= "• Stres      : Skor {$hasilTes['skor_stres']} → {$hasilTes['kategori_stres']}\n";
            $prompt .= "\nPake info ini buat konteks obrolan — tapi jangan langsung sebut angkanya kecuali ditanya. Personalisasi respons lo sesuai kondisi mereka ya!";
        }

        return $prompt;
    }
}