<?php
// app/Controllers/TesController.php
namespace App\Controllers;

use App\Models\HasilTesModel;

class TesController extends BaseController
{
    // Pertanyaan DASS-21 dengan mapping subskala
    private array $questions = [
        1  => ['text' => 'Saya merasa sulit untuk tenang',                          'skala' => 'stres'],
        2  => ['text' => 'Saya menyadari mulut terasa kering',                      'skala' => 'kecemasan'],
        3  => ['text' => 'Saya tidak dapat merasakan perasaan positif sama sekali', 'skala' => 'depresi'],
        4  => ['text' => 'Saya mengalami gangguan pernapasan (napas cepat, sesak)', 'skala' => 'kecemasan'],
        5  => ['text' => 'Saya merasa sulit untuk memulai sesuatu',                 'skala' => 'depresi'],
        6  => ['text' => 'Saya cenderung bereaksi berlebihan terhadap situasi',     'skala' => 'stres'],
        7  => ['text' => 'Saya mengalami tremor (gemetar)',                         'skala' => 'kecemasan'],
        8  => ['text' => 'Saya merasa banyak menghabiskan energi karena cemas',     'skala' => 'stres'],
        9  => ['text' => 'Saya khawatir dengan situasi panik yang mempermalukan',   'skala' => 'kecemasan'],
        10 => ['text' => 'Saya merasa tidak ada yang bisa diharapkan ke depan',     'skala' => 'depresi'],
        11 => ['text' => 'Saya merasa gelisah',                                     'skala' => 'stres'],
        12 => ['text' => 'Saya merasa sulit untuk rileks',                          'skala' => 'stres'],
        13 => ['text' => 'Saya merasa sedih dan menderita',                         'skala' => 'depresi'],
        14 => ['text' => 'Saya tidak toleran dengan hal yang menghambat aktivitas', 'skala' => 'stres'],
        15 => ['text' => 'Saya merasa hampir panik',                                'skala' => 'kecemasan'],
        16 => ['text' => 'Saya tidak mampu antusias dengan apapun',                 'skala' => 'depresi'],
        17 => ['text' => 'Saya merasa diri saya tidak berharga',                    'skala' => 'depresi'],
        18 => ['text' => 'Saya merasa mudah tersinggung',                           'skala' => 'stres'],
        19 => ['text' => 'Saya menyadari detak jantung yang tidak biasa',           'skala' => 'kecemasan'],
        20 => ['text' => 'Saya merasa takut tanpa alasan yang jelas',               'skala' => 'kecemasan'],
        21 => ['text' => 'Saya merasa hidup tidak berarti',                         'skala' => 'depresi'],
    ];

    public function index(): string
    {
        if (!session()->get('mahasiswa_id')) {
            return redirect()->to('/form')->with('info', 'Silakan isi data diri terlebih dahulu.');
        }
        return view('layouts/main', [
            'content'   => view('tes/index', ['questions' => $this->questions]),
            'title'     => 'Tes Mental DASS-21 - Mentality',
        ]);
    }

    public function submit(): \CodeIgniter\HTTP\ResponseInterface
    {
        $mahasiswaId = session()->get('mahasiswa_id');
        if (!$mahasiswaId) {
            return redirect()->to('/form');
        }

        $jawaban     = $this->request->getPost('jawaban') ?? [];
        $jawabanBersih = [];

        // Validasi: semua 21 soal harus dijawab
        for ($i = 1; $i <= 21; $i++) {
            $val = (int) ($jawaban[$i] ?? -1);
            if ($val < 0 || $val > 3) {
                return redirect()->back()->with('error', "Pertanyaan nomor {$i} belum dijawab.");
            }
            $jawabanBersih[$i] = $val;
        }

        // Hitung skor per subskala (jumlah × 2)
        $skorDepresi   = 0;
        $skorKecemasan = 0;
        $skorStres     = 0;

        foreach ($this->questions as $no => $q) {
            match($q['skala']) {
                'depresi'   => $skorDepresi   += $jawabanBersih[$no],
                'kecemasan' => $skorKecemasan += $jawabanBersih[$no],
                'stres'     => $skorStres     += $jawabanBersih[$no],
            };
        }

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

        // Simpan di session untuk chatbot
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
            'content' => view('hasil/index', compact('hasil', 'status')),
            'title'   => 'Hasil Tes - Mentality',
        ]);
    }
}
