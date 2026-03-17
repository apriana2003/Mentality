<?php
// app/Controllers/FormController.php
namespace App\Controllers;

use App\Models\MahasiswaModel;

class FormController extends BaseController
{
    public function index(): string
    {
        return view('layouts/main', [
            'content' => view('form/index'),
            'title'   => 'Data Diri - Mentality',
        ]);
    }

    public function submit(): \CodeIgniter\HTTP\ResponseInterface
    {
        $model = new MahasiswaModel();

        $data = [
            'nama'          => $this->request->getPost('nama'),
            'email'         => $this->request->getPost('email'),
            'nim'           => $this->request->getPost('nim'),
            'universitas'   => $this->request->getPost('universitas'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'usia'          => (int) $this->request->getPost('usia'),
        ];

        if (!$model->validate($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        $id = $model->insert($data);
        session()->set('mahasiswa_id', $id);
        session()->set('mahasiswa_nama', $data['nama']);

        return redirect()->to('/tes')->with('success', 'Data berhasil disimpan. Mulai tes sekarang!');
    }
}
