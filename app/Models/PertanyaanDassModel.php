<?php
// app/Models/PertanyaanDassModel.php
namespace App\Models;

use CodeIgniter\Model;

class PertanyaanDassModel extends Model
{
    protected $table         = 'pertanyaan_dass';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['nomor', 'pertanyaan', 'skala', 'aktif'];
    protected $useTimestamps = true;
    protected $returnType    = 'array';

    protected $validationRules = [
        'nomor'      => 'required|integer|greater_than[0]|less_than[100]',
        'pertanyaan' => 'required|min_length[5]',
        'skala'      => 'required|in_list[depresi,kecemasan,stres]',
    ];

    protected $validationMessages = [
        'nomor'      => ['required' => 'Nomor soal wajib diisi.', 'integer' => 'Nomor harus angka.'],
        'pertanyaan' => ['required' => 'Teks pertanyaan wajib diisi.'],
        'skala'      => ['in_list'  => 'Skala harus depresi, kecemasan, atau stres.'],
    ];

    // Ambil semua pertanyaan aktif urut nomor
    public function getAktif(): array
    {
        return $this->where('aktif', 1)
                    ->orderBy('nomor', 'ASC')
                    ->findAll();
    }

    // Ambil semua (untuk admin)
    public function getAll(): array
    {
        return $this->orderBy('nomor', 'ASC')->findAll();
    }

    // Cek apakah nomor sudah dipakai (untuk validasi duplikat)
    public function nomorExists(int $nomor, ?int $excludeId = null): bool
    {
        $builder = $this->where('nomor', $nomor);
        if ($excludeId) $builder->where('id !=', $excludeId);
        return $builder->countAllResults() > 0;
    }

    // Statistik per skala
    public function getStatistikSkala(): array
    {
        return $this->select('skala, COUNT(*) as total, SUM(aktif) as aktif_count')
                    ->groupBy('skala')
                    ->findAll();
    }
}   