<?php
// app/Libraries/OpenAIClient.php
namespace App\Libraries;

class OpenAIClient
{
    private string $apiKey;
    private string $model;
    private int    $maxTokens;
    private string $endpoint = 'https://api.openai.com/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey    = env('openai.apiKey', '');
        $this->model     = env('openai.model', 'gpt-3.5-turbo');
        $this->maxTokens = (int) env('openai.maxTokens', 800);
    }

    /**
     * Kirim pesan ke OpenAI dan kembalikan respons teks.
     *
     * @param array $messages  Array of ['role'=>'...', 'content'=>'...']
     * @param array $hasilTes  Opsional — data DASS-21 untuk context AI
     */
    public function chat(array $messages, array $hasilTes = []): string
    {
        $systemPrompt = $this->buildSystemPrompt($hasilTes);

        $payload = [
            'model'       => $this->model,
            'max_tokens'  => $this->maxTokens,
            'temperature' => 0.7,
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

        if ($err || $status !== 200) {
            log_message('error', "OpenAI error [{$status}]: {$err} | {$raw}");
            return 'Maaf, saya sedang mengalami gangguan. Silakan coba lagi dalam beberapa saat.';
        }

        $data = json_decode($raw, true);
        return trim($data['choices'][0]['message']['content'] ?? 'Tidak ada respons dari AI.');
    }

    private function buildSystemPrompt(array $hasilTes = []): string
    {
        $base = <<<PROMPT
Kamu adalah Mentality AI, asisten kesehatan mental yang empatik, suportif, dan berpengetahuan luas.
Kamu berperan sebagai konselor psikologis awal sekaligus dokter yang memberikan edukasi kesehatan mental.

PANDUAN PENTING:
1. Selalu berbahasa Indonesia yang sopan, hangat, dan mudah dipahami.
2. Jangan memberikan diagnosis medis resmi — arahkan ke profesional jika diperlukan.
3. Jangan pernah mendorong self-harm atau perilaku berbahaya.
4. Tunjukkan empati sebelum memberikan saran.
5. Respons maksimal 3 paragraf agar tidak terlalu panjang.
6. Jika pengguna tampak dalam krisis, segera sarankan hotline: Into The Light Indonesia: 119 ext 8.
PROMPT;

        if (!empty($hasilTes)) {
            $base .= "\n\nDATA HASIL TES DASS-21 PENGGUNA INI:\n";
            $base .= "- Depresi    : Skor {$hasilTes['skor_depresi']} → {$hasilTes['kategori_depresi']}\n";
            $base .= "- Kecemasan  : Skor {$hasilTes['skor_kecemasan']} → {$hasilTes['kategori_kecemasan']}\n";
            $base .= "- Stres      : Skor {$hasilTes['skor_stres']} → {$hasilTes['kategori_stres']}\n";
            $base .= "\nGunakan data ini sebagai konteks percakapan. Personalisasikan responsmu berdasarkan kondisi mereka.";
        }

        return $base;
    }
}
