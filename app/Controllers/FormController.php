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
        $fields = (new FormFieldModel())->getAktif();
        $data   = [];
        $errors = [];

        // Field yang tersimpan di tabel mahasiswa
        $mahasiswaFields = ['nama', 'email', 'nim', 'universitas', 'jenis_kelamin', 'usia'];

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

            // Handle radio jenis_kelamin — simpan L/P
            if ($name === 'jenis_kelamin') {
                $value = ($value === 'Laki-laki' || $value === 'L') ? 'L' : 'P';
            }

            // Hanya simpan field yang ada di tabel mahasiswa
            if (in_array($name, $mahasiswaFields)) {
                $data[$name] = $value;
            }
        }

        // Kembalikan error validasi manual
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Validasi via Model CI4
        $model = new MahasiswaModel();
        if (!$model->validate($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        // Simpan
        $id = $model->insert($data);

        if (!$id) {
            return redirect()->back()->withInput()
                ->with('errors', ['general' => 'Gagal menyimpan data. Silakan coba lagi.']);
        }

        session()->set('mahasiswa_id', $id);
        session()->set('mahasiswa_nama', $data['nama'] ?? '');

        return redirect()->to('/tes')->with('success', 'Data berhasil disimpan. Mulai tes sekarang!');
    }
}