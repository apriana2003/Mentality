<?php
// app/Controllers/AdminController.php
namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\MahasiswaModel;
use App\Models\HasilTesModel;
use App\Models\BlogModel;
use App\Models\SecurityLogModel;

class AdminController extends BaseController
{
    // ── Login ─────────────────────────────────────────────────
    // SEBELUM: public function login(): string
// SESUDAH:
public function login(): string|\CodeIgniter\HTTP\ResponseInterface
{
    if (session()->get('admin_logged_in')) {
        return redirect()->to('/admin');
    }
    return view('admin/login', ['title' => 'Login Admin - Mentality']);
}

    public function doLogin(): \CodeIgniter\HTTP\ResponseInterface
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $adminModel = new AdminModel();
        $admin      = $adminModel->where('email', $email)->first();

        if (!$admin || !password_verify($password, $admin['password'])) {
            return redirect()->back()->withInput()
                ->with('error', 'Email atau password salah!');
        }

        session()->set([
            'admin_logged_in' => true,
            'admin_id'        => $admin['id'],
            'admin_nama'      => $admin['nama'],
            'admin_email'     => $admin['email'],
        ]);

        return redirect()->to('/admin')->with('success', 'Selamat datang, ' . $admin['nama'] . '!');
    }

    public function logout(): \CodeIgniter\HTTP\ResponseInterface
    {
        session()->destroy();
        return redirect()->to('/admin/login')->with('info', 'Berhasil logout.');
    }

    // ── Dashboard ─────────────────────────────────────────────
    public function dashboard(): string
    {
        $mahasiswaModel = new MahasiswaModel();
        $hasilModel     = new HasilTesModel();
        $secModel       = new SecurityLogModel();
        $blogModel      = new BlogModel();

        // Statistik ringkasan
        $stats = [
            'total_responden' => $mahasiswaModel->countAll(),
            'total_tes'       => $hasilModel->countAll(),
            'total_blogs'     => $blogModel->where('published', 1)->countAllResults(),
            'total_threats'   => $secModel->countAll(),
        ];

        // Distribusi kategori
        $db = \Config\Database::connect();
        $distribusi = [
            'depresi'   => $db->query("SELECT kategori_depresi as kategori, COUNT(*) as total FROM hasil_tes GROUP BY kategori_depresi")->getResultArray(),
            'kecemasan' => $db->query("SELECT kategori_kecemasan as kategori, COUNT(*) as total FROM hasil_tes GROUP BY kategori_kecemasan")->getResultArray(),
            'stres'     => $db->query("SELECT kategori_stres as kategori, COUNT(*) as total FROM hasil_tes GROUP BY kategori_stres")->getResultArray(),
        ];

        // Data tes terbaru (5)
        $tesTerbaru = $db->query("
            SELECT ht.*, m.nama, m.universitas
            FROM hasil_tes ht
            JOIN mahasiswa m ON m.id = ht.mahasiswa_id
            ORDER BY ht.created_at DESC
            LIMIT 5
        ")->getResultArray();

        // Ancaman terbaru (5)
        $threatsTerbaru = $secModel->orderBy('created_at', 'DESC')->findAll(5);

        return view('admin/layout', [
            'content'       => view('admin/dashboard', compact('stats','distribusi','tesTerbaru','threatsTerbaru')),
            'title'         => 'Dashboard - Admin Mentality',
            'activePage'    => 'dashboard',
        ]);
    }

    // ── Data Responden ────────────────────────────────────────
    public function mahasiswa(): string
    {
        $mahasiswaModel = new MahasiswaModel();
        $db = \Config\Database::connect();

        $search  = $this->request->getGet('search') ?? '';
        $perPage = 15;
        $page    = (int)($this->request->getGet('page') ?? 1);

        $builder = $db->table('mahasiswa m')
            ->select('m.*, (SELECT COUNT(*) FROM hasil_tes ht WHERE ht.mahasiswa_id = m.id) as jumlah_tes')
            ->orderBy('m.created_at', 'DESC');

        if ($search) {
            $builder->groupStart()
                ->like('m.nama', $search)
                ->orLike('m.email', $search)
                ->orLike('m.universitas', $search)
                ->groupEnd();
        }

        $total      = $builder->countAllResults(false);
        $responden  = $builder->limit($perPage, ($page - 1) * $perPage)->get()->getResultArray();

        return view('admin/layout', [
            'content'    => view('admin/responden', compact('responden','total','page','perPage','search')),
            'title'      => 'Data Responden - Admin Mentality',
            'activePage' => 'responden',
        ]);
    }

    // ── Detail Responden ──────────────────────────────────────
   public function respondenDetail(int $id): string|\CodeIgniter\HTTP\ResponseInterface
{
    $db = \Config\Database::connect();

    $responden = $db->table('mahasiswa')->where('id', $id)->get()->getRowArray();
    
    // Bagian ini yang menyebabkan error jika tetap menggunakan : string
    if (!$responden) {
        return redirect()->to('/admin/mahasiswa')->with('error', 'Data tidak ditemukan.');
    }

    $riwayatTes = $db->table('hasil_tes')
        ->where('mahasiswa_id', $id)
        ->orderBy('created_at', 'DESC')
        ->get()->getResultArray();

    return view('admin/layout', [
        'content'    => view('admin/responden_detail', compact('responden','riwayatTes')),
        'title'      => 'Detail Responden - Admin Mentality',
        'activePage' => 'responden',
    ]);
}

    // ── Hapus Responden ───────────────────────────────────────
    public function respondenDelete(int $id): \CodeIgniter\HTTP\ResponseInterface
    {
        $model = new MahasiswaModel();
        $model->delete($id);
        return redirect()->to('/admin/mahasiswa')->with('success', 'Data responden berhasil dihapus.');
    }

    // ── Hasil Tes ─────────────────────────────────────────────
    public function hasilTes(): string
    {
        $db      = \Config\Database::connect();
        $search  = $this->request->getGet('search') ?? '';
        $filter  = $this->request->getGet('filter') ?? '';
        $perPage = 15;
        $page    = (int)($this->request->getGet('page') ?? 1);

        $builder = $db->table('hasil_tes ht')
            ->select('ht.*, m.nama, m.email, m.universitas, m.jenis_kelamin, m.usia')
            ->join('mahasiswa m', 'm.id = ht.mahasiswa_id')
            ->orderBy('ht.created_at', 'DESC');

        if ($search) {
            $builder->groupStart()
                ->like('m.nama', $search)
                ->orLike('m.email', $search)
                ->groupEnd();
        }

        if ($filter) {
            $builder->groupStart()
                ->where('ht.kategori_depresi', $filter)
                ->orWhere('ht.kategori_kecemasan', $filter)
                ->orWhere('ht.kategori_stres', $filter)
                ->groupEnd();
        }

        $total  = $builder->countAllResults(false);
        $hasil  = $builder->limit($perPage, ($page - 1) * $perPage)->get()->getResultArray();

        return view('admin/layout', [
            'content'    => view('admin/hasil_tes', compact('hasil','total','page','perPage','search','filter')),
            'title'      => 'Hasil Tes - Admin Mentality',
            'activePage' => 'hasil_tes',
        ]);
    }

    // ── Security Logs ─────────────────────────────────────────
    public function securityLogs(): string
    {
        $model   = new SecurityLogModel();
        $perPage = 20;
        $page    = (int)($this->request->getGet('page') ?? 1);

        $logs    = $model->orderBy('created_at','DESC')->findAll($perPage, ($page-1)*$perPage);
        $total   = $model->countAll();
        $summary = $model->getThreatSummary();

        return view('admin/layout', [
            'content'    => view('admin/security', compact('logs','total','page','perPage','summary')),
            'title'      => 'Security Logs - Admin Mentality',
            'activePage' => 'security',
        ]);
    }

    // ── Blog Management ───────────────────────────────────────
    public function blogs(): string
    {
        $model = new BlogModel();
        $blogs = $model->orderBy('created_at','DESC')->findAll();

        return view('admin/layout', [
            'content'    => view('admin/blogs', compact('blogs')),
            'title'      => 'Kelola Blog - Admin Mentality',
            'activePage' => 'blogs',
        ]);
    }

    public function blogsSave(): \CodeIgniter\HTTP\ResponseInterface
    {
        $model = new BlogModel();
        $id    = $this->request->getPost('id');
        $judul = $this->request->getPost('judul');

        $data = [
            'judul'     => $judul,
            'slug'      => $id ? $model->find($id)['slug'] : $model->generateSlug($judul),
            'ringkasan' => $this->request->getPost('ringkasan'),
            'konten'    => $this->request->getPost('konten'),
            'kategori'  => $this->request->getPost('kategori'),
            'published' => $this->request->getPost('published') ? 1 : 0,
        ];

        $id ? $model->update($id, $data) : $model->insert($data);

        return redirect()->to('/admin/blogs')
            ->with('success', $id ? 'Artikel berhasil diperbarui.' : 'Artikel berhasil ditambahkan.');
    }

    public function blogsDelete(int $id): \CodeIgniter\HTTP\ResponseInterface
    {
        (new BlogModel())->delete($id);
        return redirect()->to('/admin/blogs')->with('success', 'Artikel berhasil dihapus.');
    }
}
