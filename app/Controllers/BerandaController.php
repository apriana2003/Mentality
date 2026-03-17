<?php
// app/Controllers/BerandaController.php
namespace App\Controllers;

use App\Models\BlogModel;
use App\Models\HasilTesModel;
use App\Models\MahasiswaModel;

class BerandaController extends BaseController
{
    public function index(): string
    {
        $blogModel    = new BlogModel();
        $hasilModel   = new HasilTesModel();
        $mahasiswaModel = new MahasiswaModel();

        $data = [
            'title'         => 'Beranda',
            'recentBlogs'   => $blogModel->getPublished(3),
            'totalMahasiswa'=> $mahasiswaModel->countAll(),
            'totalTes'      => $hasilModel->countAll(),
        ];

        return view('layouts/main', ['content' => view('beranda/index', $data), 'title' => 'Beranda - Mentality']);
    }
}
