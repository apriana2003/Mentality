<?php
// app/Models/ChatModel.php
namespace App\Models;

use CodeIgniter\Model;

class ChatModel extends Model
{
    protected $table         = 'chat_sessions';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['session_token','mahasiswa_id','hasil_tes_id'];
    protected $useTimestamps = false;
    protected $returnType    = 'array';

    public function createSession(?int $mahasiswaId = null, ?int $hasilTesId = null): string
    {
        $token = bin2hex(random_bytes(32)); // 64 char hex
        $this->insert([
            'session_token' => $token,
            'mahasiswa_id'  => $mahasiswaId,
            'hasil_tes_id'  => $hasilTesId,
        ]);
        return $token;
    }

    public function getByToken(string $token): array|null
    {
        return $this->where('session_token', $token)->first();
    }

    public function getMessages(int $sessionId): array
    {
        $db = \Config\Database::connect();
        return $db->table('chat_messages')
                  ->where('session_id', $sessionId)
                  ->orderBy('created_at', 'ASC')
                  ->get()->getResultArray();
    }

    public function addMessage(int $sessionId, string $role, string $content): void
    {
        $db = \Config\Database::connect();
        $db->table('chat_messages')->insert([
            'session_id' => $sessionId,
            'role'       => $role,
            'content'    => $content,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
