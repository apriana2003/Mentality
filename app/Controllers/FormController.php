<?php
// app/Controllers/FormController.php
namespace App\Controllers;

use App\Models\MahasiswaModel;
use App\Models\FormFieldModel;

class FormController extends BaseController
{
    public function index(): string
    {
        $fields = (new FormFieldModel())->getAktif();

        return view('layouts/main', [
            'content' => view('form/index', ['fields' => $fields]),
            'title'   => 'Data Diri - Mentality',
        ]);
    }

    public function submit(): \CodeIgniter\HTTP\ResponseInterface
    {
        $fields          = (new FormFieldModel())->getAktif();
        $data            = [];
        $errors          = [];
        $mahasiswaFields = ['nama','email','nim','universitas','jenis_kelamin','usia'];

        foreach ($fields as $field) {
            $name  = $field['name'];
            $value = $this->request->getPost($name);

            // Validasi wajib
            if ($field['required'] && ($value === null || $value === '')) {
                $errors[$name] = $field['label'] . ' wajib diisi.';
                continue;
            }

            // Sanitasi
            if (is_string($value)) {
                $value = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
            }

            // Konversi number
            if ($field['type'] === 'number' && $value !== null) {
                $value = (int) $value;
            }

            // Handle radio jenis_kelamin
            if ($name === 'jenis_kelamin') {
                $value = ($value === 'Laki-laki' || $value === 'L') ? 'L' : 'P';
            }

            if (in_array($name, $mahasiswaFields)) {
                $data[$name] = $value;
            }
        }

        // Kembalikan error validasi field
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Validasi model CI4
        $model = new MahasiswaModel();
        if (!$model->validate($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        // ── Cek duplikat email ────────────────────────────────────
        $existing = $model->where('email', $data['email'])->first();

        if ($existing) {
            // Tandai field email sebagai error supaya highlight merah
            return redirect()->back()->withInput()->with('errors', [
                'email' => 'Email ' . $data['email'] . ' sudah digunakan oleh responden lain. Silakan gunakan email yang berbeda.',
            ]);
        }

        // ── Insert data baru ──────────────────────────────────────
        $id = $model->insert($data);

        if (!$id) {
            return redirect()->back()->withInput()
                ->with('errors', ['general' => 'Gagal menyimpan data. Silakan coba lagi.']);
        }

        // Simpan ke session
        session()->set('mahasiswa_id', $id);
        session()->set('mahasiswa_nama', $data['nama'] ?? '');

        // Kirim data untuk localStorage pending flag
        session()->setFlashdata('save_pending', [
            'nama'  => $data['nama']  ?? '',
            'email' => $data['email'] ?? '',
        ]);

        return redirect()->to('/tes')->with('success', 'Data berhasil disimpan. Mulai tes sekarang!');
    }
}