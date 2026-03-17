<?php
// app/Models/HasilTesModel.php
namespace App\Models;

use CodeIgniter\Model;

class HasilTesModel extends Model
{
    protected $table         = 'hasil_tes';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'mahasiswa_id','skor_depresi','skor_kecemasan','skor_stres',
        'kategori_depresi','kategori_kecemasan','kategori_stres','jawaban_json',
    ];
    protected $useTimestamps = false;
    protected $returnType    = 'array';

    // Kategori DASS-21
    public function kategorisasiDepresi(int $skor): string
    {
        return match(true) {
            $skor <= 9  => 'Normal',
            $skor <= 13 => 'Ringan',
            $skor <= 20 => 'Sedang',
            $skor <= 27 => 'Berat',
            default     => 'Sangat Berat',
        };
    }

    public function kategorisasiKecemasan(int $skor): string
    {
        return match(true) {
            $skor <= 7  => 'Normal',
            $skor <= 9  => 'Ringan',
            $skor <= 14 => 'Sedang',
            $skor <= 19 => 'Berat',
            default     => 'Sangat Berat',
        };
    }

    public function kategorisasiStres(int $skor): string
    {
        return match(true) {
            $skor <= 14 => 'Normal',
            $skor <= 18 => 'Ringan',
            $skor <= 25 => 'Sedang',
            $skor <= 33 => 'Berat',
            default     => 'Sangat Berat',
        };
    }

    // Tentukan status umum untuk UI
    public function getStatusUmum(string $kd, string $kk, string $ks): array
    {
        $levels  = ['Normal'=>0,'Ringan'=>1,'Sedang'=>2,'Berat'=>3,'Sangat Berat'=>4];
        $highest = max($levels[$kd], $levels[$kk], $levels[$ks]);

        return match(true) {
            $highest === 0 => [
                'label' => 'Sehat',
                'color' => 'success',
                'icon'  => 'bi-emoji-smile',
                'desc'  => 'Kondisi mentalmu saat ini baik. Pertahankan gaya hidup sehatmu!',
            ],
            $highest === 1 => [
                'label' => 'Perlu Perhatian',
                'color' => 'warning',
                'icon'  => 'bi-emoji-neutral',
                'desc'  => 'Ada beberapa tanda ringan yang perlu kamu perhatikan. Coba bicara dengan orang yang kamu percaya.',
            ],
            $highest === 2 => [
                'label' => 'Perlu Perhatian Lebih',
                'color' => 'orange',
                'icon'  => 'bi-emoji-frown',
                'desc'  => 'Kondisimu membutuhkan perhatian lebih. Pertimbangkan konsultasi dengan konselor kampus.',
            ],
            default => [
                'label' => 'Butuh Bantuan Profesional',
                'color' => 'danger',
                'icon'  => 'bi-heart-pulse',
                'desc'  => 'Hasil menunjukkan kamu sangat membutuhkan bantuan profesional segera. Hubungi psikolog atau psikiater.',
            ],
        };
    }

    public function getWithMahasiswa(int $id): array|null
    {
        return $this->select('hasil_tes.*, mahasiswa.nama, mahasiswa.email, mahasiswa.universitas')
                    ->join('mahasiswa', 'mahasiswa.id = hasil_tes.mahasiswa_id')
                    ->where('hasil_tes.id', $id)
                    ->first();
    }
}
