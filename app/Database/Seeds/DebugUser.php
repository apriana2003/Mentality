<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DebugUser extends Seeder
{
    public function run()
    {
        $password_baru = 'admin123'; // Silakan ganti sesukamu
        $hash_baru = password_hash($password_baru, PASSWORD_BCRYPT);

        $data = [
            'password' => $hash_baru
        ];

        // Ganti 'users' dengan nama tabel user kamu (misal: 'user' atau 'account')
        // Ganti 'id' => 1 dengan kriteria user yang mau direset
        $this->db->table('admin')->update($data, ['id' => 1]);

        echo "\n[SUCCESS] Password berhasil diupdate menjadi: $password_baru\n";
        echo "Hash baru: $hash_baru\n";
    }
}