<?php
// app/Libraries/OpenAIClient.php
// Kompatibel dengan OpenAI dan Groq (format API sama)
namespace App\Libraries;

class OpenAIClient
{
    private string $apiKey;
    private string $model;
    private int    $maxTokens;

    // Groq endpoint (gratis) — ganti ke OpenAI jika perlu
    private string $endpoint = 'https://api.groq.com/openai/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey    = env('openai.apiKey', '');
        $this->model     = env('openai.model', 'llama3-8b-8192');
        $this->maxTokens = (int) env('openai.maxTokens', 800);
    }

    /**
     * Kirim pesan ke AI dan kembalikan teks respons.
     *
     * @param array $messages  Riwayat chat ['role'=>'...','content'=>'...']
     * @param array $hasilTes  Data DASS-21 untuk konteks AI (opsional)
     */
    public function chat(array $messages, array $hasilTes = []): string
    {
        // Validasi API key
        if (empty($this->apiKey) || str_starts_with($this->apiKey, 'gsk_GANTI')) {
            return '⚠️ API Key belum diisi. Silakan isi `openai.apiKey` di file `.env` dengan Groq API Key kamu.';
        }

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

        // Handle cURL error
        if ($err) {
            log_message('error', "Groq cURL error: {$err}");
            return '⚠️ Koneksi ke AI gagal. Pastikan internet tersambung dan coba lagi.';
        }

        // Handle HTTP error
        if ($status !== 200) {
            $body = json_decode($raw, true);
            $msg  = $body['error']['message'] ?? 'Unknown error';
            log_message('error', "Groq HTTP [{$status}]: {$msg}");

            return match($status) {
                401 => '⚠️ API Key tidak valid. Periksa kembali Groq API Key di file `.env`.',
                429 => '⚠️ Terlalu banyak permintaan. Tunggu sebentar dan coba lagi.',
                503 => '⚠️ Server AI sedang sibuk. Coba lagi dalam beberapa detik.',
                default => "⚠️ Terjadi kesalahan (HTTP {$status}). Coba lagi nanti.",
            };
        }

        $data = json_decode($raw, true);
        return trim($data['choices'][0]['message']['content'] ?? 'Tidak ada respons dari AI.');
    }

    /**
     * Bangun system prompt — termasuk data DASS-21 jika tersedia.
     */
    private function buildSystemPrompt(array $hasilTes = []): string
    {
        $prompt = <<<PROMPT
Kamu adalah Mentality AI, asisten kesehatan mental yang empatik, hangat, dan berpengetahuan luas dalam psikologi.
Kamu berperan sebagai konselor psikologis awal sekaligus edukator kesehatan mental.

PANDUAN UTAMA:
1. Selalu gunakan Bahasa Indonesia yang sopan, hangat, dan mudah dipahami mahasiswa.
2. Tunjukkan EMPATI terlebih dahulu sebelum memberikan saran atau informasi.
3. JANGAN memberikan diagnosis medis resmi — itu hanya bisa dilakukan dokter/psikiater.
4. Jika kondisi pengguna tampak sangat serius, sarankan hotline: Into The Light 119 ext 8.
5. Respons maksimal 3-4 paragraf agar tidak terlalu panjang dan mudah dibaca.
6. Gunakan bahasa yang friendly, bukan kaku seperti buku teks.
7. Boleh gunakan emoji secukupnya agar terasa lebih personal 😊
PROMPT;

        if (!empty($hasilTes)) {
            $prompt .= "\n\nDATA HASIL TES DASS-21 PENGGUNA INI:\n";
            $prompt .= "• Depresi    : Skor {$hasilTes['skor_depresi']} → Kategori {$hasilTes['kategori_depresi']}\n";
            $prompt .= "• Kecemasan  : Skor {$hasilTes['skor_kecemasan']} → Kategori {$hasilTes['kategori_kecemasan']}\n";
            $prompt .= "• Stres      : Skor {$hasilTes['skor_stres']} → Kategori {$hasilTes['kategori_stres']}\n";
            $prompt .= "\nGunakan data ini sebagai konteks percakapan. Personalisasikan responsmu berdasarkan kondisi mereka. Jangan langsung sebut angka skor kecuali diminta.";
        }

        return $prompt;
    }
}
