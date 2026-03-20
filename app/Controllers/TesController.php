<?php
// app/Controllers/TesController.php
namespace App\Controllers;

use App\Models\HasilTesModel;
use App\Models\PertanyaanDassModel;

class TesController extends BaseController
{
    public function index(): string
    {
        if (!session()->get('mahasiswa_id')) {
            return redirect()->to('/form')->with('info', 'Silakan isi data diri terlebih dahulu.');
        }

        // Ambil pertanyaan dari database (aktif saja)
        $pertanyaanModel = new PertanyaanDassModel();
        $questions       = $pertanyaanModel->getAktif();

        if (empty($questions)) {
            return redirect()->to('/form')->with('error', 'Pertanyaan tes belum dikonfigurasi. Hubungi administrator.');
        }

        return view('layouts/main', [
            'content'   => view('tes/index', ['questions' => $questions]),
            'title'     => 'Tes Mental DASS-21 - Mentality',
        ]);
    }

    public function submit(): \CodeIgniter\HTTP\ResponseInterface
    {
        $mahasiswaId = session()->get('mahasiswa_id');
        if (!$mahasiswaId) return redirect()->to('/form');

        // Ambil pertanyaan aktif dari DB
        $pertanyaanModel = new PertanyaanDassModel();
        $questions       = $pertanyaanModel->getAktif();

        if (empty($questions)) {
            return redirect()->to('/tes')->with('error', 'Pertanyaan tidak ditemukan.');
        }

        $jawaban       = $this->request->getPost('jawaban') ?? [];
        $jawabanBersih = [];

        // Validasi semua pertanyaan aktif harus dijawab
        foreach ($questions as $q) {
            $no  = $q['nomor'];
            $val = isset($jawaban[$no]) ? (int)$jawaban[$no] : -1;

            if ($val < 0 || $val > 3) {
                return redirect()->back()->with('error', "Pertanyaan nomor {$no} belum dijawab.");
            }
            $jawabanBersih[$no] = $val;
        }

        // Hitung skor per subskala
        $skorDepresi   = 0;
        $skorKecemasan = 0;
        $skorStres     = 0;

        foreach ($questions as $q) {
            $val = $jawabanBersih[$q['nomor']];
            match($q['skala']) {
                'depresi'   => $skorDepresi   += $val,
                'kecemasan' => $skorKecemasan += $val,
                'stres'     => $skorStres     += $val,
            };
        }

        // Kalikan 2 sesuai standar DASS-21
        $skorDepresi   *= 2;
        $skorKecemasan *= 2;
        $skorStres     *= 2;

        $model = new HasilTesModel();

        $id = $model->insert([
            'mahasiswa_id'       => $mahasiswaId,
            'skor_depresi'       => $skorDepresi,
            'skor_kecemasan'     => $skorKecemasan,
            'skor_stres'         => $skorStres,
            'kategori_depresi'   => $model->kategorisasiDepresi($skorDepresi),
            'kategori_kecemasan' => $model->kategorisasiKecemasan($skorKecemasan),
            'kategori_stres'     => $model->kategorisasiStres($skorStres),
            'jawaban_json'       => json_encode($jawabanBersih),
        ]);

        session()->set('hasil_tes_id', $id);

        return redirect()->to("/tes/hasil/{$id}");
    }

    public function hasil(int $id): string
    {
        $model  = new HasilTesModel();
        $hasil  = $model->getWithMahasiswa($id);

        if (!$hasil) {
            return redirect()->to('/')->with('error', 'Hasil tes tidak ditemukan.');
        }

        $status = $model->getStatusUmum(
            $hasil['kategori_depresi'],
            $hasil['kategori_kecemasan'],
            $hasil['kategori_stres']
        );

        return view('layouts/main', [
            'content' => view('hasil/index', compact('hasil','status')),
            'title'   => 'Hasil Tes - Mentality',
        ]);
    }
}