<?php
// app/Controllers/ChatbotController.php
namespace App\Controllers;

use App\Models\ChatModel;
use App\Models\HasilTesModel;
use App\Libraries\OpenAIClient;

class ChatbotController extends BaseController
{
    private ChatModel     $chatModel;
    private HasilTesModel $hasilModel;

    public function __construct()
    {
        $this->chatModel  = new ChatModel();
        $this->hasilModel = new HasilTesModel();
    }

    private function isAjax(): bool
    {
        return $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest';
    }

    public function index(): string
    {
        $hasilTesId = session()->get('hasil_tes_id');
        $hasilTes   = $hasilTesId ? $this->hasilModel->find($hasilTesId) : null;

        return view('layouts/main', [
            'content' => view('chatbot/index', ['hasilTes' => $hasilTes]),
            'title'   => 'Konseling AI - Mentality',
        ]);
    }

    public function getSession(): \CodeIgniter\HTTP\ResponseInterface
    {
        $hasilTesId  = session()->get('hasil_tes_id');
        $mahasiswaId = session()->get('mahasiswa_id');
        $sessionToken = session()->get('chat_token');

        if (!$sessionToken) {
            $sessionToken = $this->chatModel->createSession($mahasiswaId, $hasilTesId);
            session()->set('chat_token', $sessionToken);
        }

        $session  = $this->chatModel->getByToken($sessionToken);
        $messages = $session ? $this->chatModel->getMessages($session['id']) : [];

        return $this->response->setJSON([
            'token'         => $sessionToken,
            'messages'      => $messages,
            'has_hasil_tes' => !empty($hasilTesId),
        ]);
    }

    public function send(): \CodeIgniter\HTTP\ResponseInterface
    {
        if (!$this->isAjax()) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Akses tidak diizinkan.']);
        }

        $json    = $this->request->getJSON(true);
        $userMsg = trim($json['message'] ?? '');

        if (empty($userMsg)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Pesan tidak boleh kosong.']);
        }

        // ── Handle pesan init hasil tes ──────────────────────
        $isInitMessage = $userMsg === '__init_with_hasil_tes__';

        // Buat session jika belum ada
        $sessionToken = session()->get('chat_token');
        if (!$sessionToken) {
            $sessionToken = $this->chatModel->createSession(
                session()->get('mahasiswa_id'),
                session()->get('hasil_tes_id')
            );
            session()->set('chat_token', $sessionToken);
        }

        $session = $this->chatModel->getByToken($sessionToken);
        if (!$session) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Sesi tidak ditemukan.']);
        }

        // Ambil data hasil tes
        $hasilTes = [];
        if ($session['hasil_tes_id']) {
            $hasilTes = $this->hasilModel->find($session['hasil_tes_id']) ?? [];
        }

        if ($isInitMessage) {
            // Pesan khusus untuk AI — minta analisis hasil tes
            $nama = session()->get('mahasiswa_nama') ?? 'kamu';
            $promptInit = "Halo! Sapa pengguna bernama {$nama} dengan hangat, lalu berikan analisis singkat dan nasihat personal berdasarkan hasil tes DASS-21 mereka. Gunakan bahasa yang supportif, relate, dan tidak menggurui. Akhiri dengan pertanyaan terbuka untuk mengajak mereka bercerita lebih lanjut.";

            $history = [['role' => 'user', 'content' => $promptInit]];
            $ai      = new OpenAIClient();
            $aiReply = $ai->chat($history, $hasilTes);

            // Simpan hanya balasan AI ke database
            $this->chatModel->addMessage($session['id'], 'assistant', $aiReply);

            return $this->response->setJSON(['reply' => $aiReply]);
        }

        // ── Pesan biasa ──────────────────────────────────────
        if (strlen($userMsg) > 2000) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Pesan terlalu panjang (maks 2000 karakter).']);
        }

        $userMsg = htmlspecialchars($userMsg, ENT_QUOTES, 'UTF-8');

        $this->chatModel->addMessage($session['id'], 'user', $userMsg);

        $allMessages = $this->chatModel->getMessages($session['id']);
        $history = array_slice(
            array_map(fn($m) => ['role' => $m['role'], 'content' => $m['content']], $allMessages),
            -20
        );

        $ai      = new OpenAIClient();
        $aiReply = $ai->chat($history, $hasilTes);

        $this->chatModel->addMessage($session['id'], 'assistant', $aiReply);

        return $this->response->setJSON(['reply' => $aiReply]);
    }

    public function clear(): \CodeIgniter\HTTP\ResponseInterface
    {
        if (!$this->isAjax()) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Akses tidak diizinkan.']);
        }

        $sessionToken = session()->get('chat_token');

        if ($sessionToken) {
            $session = $this->chatModel->getByToken($sessionToken);
            if ($session) {
                $db = \Config\Database::connect();
                $db->table('chat_messages')->where('session_id', $session['id'])->delete();
            }
        }

        session()->remove('chat_token');

        return $this->response->setJSON(['success' => true]);
    }
}