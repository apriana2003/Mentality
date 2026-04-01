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

    // ── Validasi request AJAX ─────────────────────────────────
    private function isAjax(): bool
    {
        return $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest';
    }

    // ── Halaman chatbot ───────────────────────────────────────
    public function index(): string
    {
        $hasilTesId = session()->get('hasil_tes_id');
        $hasilTes   = $hasilTesId ? $this->hasilModel->find($hasilTesId) : null;

        return view('layouts/main', [
            'content' => view('chatbot/index', ['hasilTes' => $hasilTes]),
            'title'   => 'Konseling AI - Mentality',
        ]);
    }

    // ── Buat / ambil session chatbot (AJAX GET) ───────────────
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
            'token'    => $sessionToken,
            'messages' => $messages,
        ]);
    }

    // ── Kirim pesan & balas dengan AI (AJAX POST) ─────────────
    public function send(): \CodeIgniter\HTTP\ResponseInterface
    {
        // Pastikan hanya AJAX yang bisa akses
        if (!$this->isAjax()) {
            return $this->response->setStatusCode(403)->setJSON([
                'error' => 'Akses tidak diizinkan.'
            ]);
        }

        $json    = $this->request->getJSON(true);
        $userMsg = trim($json['message'] ?? '');

        if (empty($userMsg)) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Pesan tidak boleh kosong.'
            ]);
        }

        if (strlen($userMsg) > 2000) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Pesan terlalu panjang (maks 2000 karakter).'
            ]);
        }

        // Sanitasi XSS
        // Cek apakah ini pesan init hasil tes
        $isInitMessage = $userMsg === '__init_with_hasil_tes__';

        // Sanitasi XSS
        $userMsg = htmlspecialchars($userMsg, ENT_QUOTES, 'UTF-8');

        // Kalau pesan init, jangan simpan ke database
        if ($isInitMessage) {
            $session = $this->chatModel->getByToken($sessionToken ?? '');
            if (!$session) {
                $sessionToken = $this->chatModel->createSession(
                    session()->get('mahasiswa_id'),
                    session()->get('hasil_tes_id')
                );
                session()->set('chat_token', $sessionToken);
                $session = $this->chatModel->getByToken($sessionToken);
            }

            $hasilTes = [];
            if ($session['hasil_tes_id']) {
                $hasilTes = $this->hasilModel->find($session['hasil_tes_id']) ?? [];
            }

            // Buat pesan khusus untuk AI
            $userMsg = 'Berikan salam pembuka dan analisis singkat hasil tes DASS-21 saya, lalu berikan nasihat dan motivasi yang personal berdasarkan skor tersebut.';

            $history = [['role' => 'user', 'content' => $userMsg]];
            $ai      = new OpenAIClient();
            $aiReply = $ai->chat($history, $hasilTes);

            // Simpan hanya balasan AI
            $this->chatModel->addMessage($session['id'], 'assistant', $aiReply);

            return $this->response->setJSON(['reply' => $aiReply]);
        }

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
            return $this->response->setStatusCode(404)->setJSON([
                'error' => 'Sesi tidak ditemukan.'
            ]);
        }

        // Simpan pesan user
        $this->chatModel->addMessage($session['id'], 'user', $userMsg);

        // Ambil riwayat (maks 20 pesan terakhir agar tidak overflow token)
        $allMessages = $this->chatModel->getMessages($session['id']);
        $history = array_slice(
            array_map(fn($m) => ['role' => $m['role'], 'content' => $m['content']], $allMessages),
            -20
        );

        // Ambil data hasil tes jika ada
        $hasilTes = [];
        if ($session['hasil_tes_id']) {
            $hasilTes = $this->hasilModel->find($session['hasil_tes_id']) ?? [];
        }

        // Panggil AI
        $ai      = new OpenAIClient();
        $aiReply = $ai->chat($history, $hasilTes);

        // Simpan balasan AI
        $this->chatModel->addMessage($session['id'], 'assistant', $aiReply);

        return $this->response->setJSON(['reply' => $aiReply]);
    }

    // ── Hapus semua pesan dalam sesi (AJAX POST) ──────────────
    public function clear(): \CodeIgniter\HTTP\ResponseInterface
    {
        if (!$this->isAjax()) {
            return $this->response->setStatusCode(403)->setJSON([
                'error' => 'Akses tidak diizinkan.'
            ]);
        }

        $sessionToken = session()->get('chat_token');

        if ($sessionToken) {
            $session = $this->chatModel->getByToken($sessionToken);
            if ($session) {
                $db = \Config\Database::connect();
                $db->table('chat_messages')
                   ->where('session_id', $session['id'])
                   ->delete();
            }
        }

        session()->remove('chat_token');

        return $this->response->setJSON(['success' => true]);
    }
}