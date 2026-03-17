<?php
// app/Controllers/ChatbotController.php
namespace App\Controllers;

use App\Models\ChatModel;
use App\Models\HasilTesModel;
use App\Libraries\OpenAIClient;

class ChatbotController extends BaseController
{
    private ChatModel   $chatModel;
    private HasilTesModel $hasilModel;

    public function __construct()
    {
        $this->chatModel  = new ChatModel();
        $this->hasilModel = new HasilTesModel();
    }

    public function index(): string
    {
        // Ambil hasil_tes_id dari session jika ada (diteruskan dari halaman hasil tes)
        $hasilTesId = session()->get('hasil_tes_id');
        $hasilTes   = $hasilTesId ? $this->hasilModel->find($hasilTesId) : null;

        return view('layouts/main', [
            'content'  => view('chatbot/index', ['hasilTes' => $hasilTes]),
            'title'    => 'Konseling AI - Mentality',
        ]);
    }

    // Buat atau ambil session chatbot (via AJAX)
    public function getSession(): \CodeIgniter\HTTP\ResponseInterface
    {
        $hasilTesId   = session()->get('hasil_tes_id');
        $mahasiswaId  = session()->get('mahasiswa_id');

        // Cek apakah session chat sudah ada
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

    // Terima pesan user dan balas dengan AI (via AJAX)
    public function send(): \CodeIgniter\HTTP\ResponseInterface
    {
        $json    = $this->request->getJSON(true);
        $userMsg = trim($json['message'] ?? '');

        if (empty($userMsg) || strlen($userMsg) > 2000) {
            return $this->response->setJSON(['error' => 'Pesan tidak valid.'], 400);
        }

        // Sanitasi input
        $userMsg = htmlspecialchars($userMsg, ENT_QUOTES, 'UTF-8');

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
            return $this->response->setJSON(['error' => 'Sesi tidak ditemukan.'], 404);
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

        // Panggil OpenAI
        $ai      = new OpenAIClient();
        $aiReply = $ai->chat($history, $hasilTes);

        // Simpan balasan AI
        $this->chatModel->addMessage($session['id'], 'assistant', $aiReply);

        return $this->response->setJSON(['reply' => $aiReply]);
    }
}
