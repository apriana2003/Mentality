<?php
// app/Controllers/AdminController.php
namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\MahasiswaModel;
use App\Models\HasilTesModel;
use App\Models\BlogModel;
use App\Models\SecurityLogModel;
use App\Models\FormFieldModel;

class AdminController extends BaseController
{
    // ══════════════════════════════════════════════════════════
    // AUTH
    // ══════════════════════════════════════════════════════════

    public function login(): string
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

        $admin = (new AdminModel())->where('email', $email)->first();

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

    // ══════════════════════════════════════════════════════════
    // DASHBOARD
    // ══════════════════════════════════════════════════════════

    public function dashboard(): string
    {
        $db = \Config\Database::connect();

        $stats = [
            'total_responden' => (new MahasiswaModel())->countAll(),
            'total_tes'       => (new HasilTesModel())->countAll(),
            'total_blogs'     => (new BlogModel())->where('published', 1)->countAllResults(),
            'total_threats'   => (new SecurityLogModel())->countAll(),
        ];

        $distribusi = [
            'depresi'   => $db->query("SELECT kategori_depresi as kategori, COUNT(*) as total FROM hasil_tes GROUP BY kategori_depresi")->getResultArray(),
            'kecemasan' => $db->query("SELECT kategori_kecemasan as kategori, COUNT(*) as total FROM hasil_tes GROUP BY kategori_kecemasan")->getResultArray(),
            'stres'     => $db->query("SELECT kategori_stres as kategori, COUNT(*) as total FROM hasil_tes GROUP BY kategori_stres")->getResultArray(),
        ];

        $tesTerbaru = $db->query("
            SELECT ht.*, m.nama, m.universitas
            FROM hasil_tes ht
            JOIN mahasiswa m ON m.id = ht.mahasiswa_id
            ORDER BY ht.created_at DESC LIMIT 5
        ")->getResultArray();

        $threatsTerbaru = (new SecurityLogModel())->orderBy('created_at','DESC')->findAll(5);

        return view('admin/layout', [
            'content'        => view('admin/dashboard', compact('stats','distribusi','tesTerbaru','threatsTerbaru')),
            'title'          => 'Dashboard - Admin Mentality',
            'activePage'     => 'dashboard',
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // DATA RESPONDEN
    // ══════════════════════════════════════════════════════════

    public function mahasiswa(): string
    {
        $db      = \Config\Database::connect();
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

        $total     = $builder->countAllResults(false);
        $responden = $builder->limit($perPage, ($page - 1) * $perPage)->get()->getResultArray();

        return view('admin/layout', [
            'content'    => view('admin/responden', compact('responden','total','page','perPage','search')),
            'title'      => 'Data Responden - Admin Mentality',
            'activePage' => 'responden',
        ]);
    }

    public function respondenDetail(int $id): string
    {
        $db        = \Config\Database::connect();
        $responden = $db->table('mahasiswa')->where('id', $id)->get()->getRowArray();

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

    public function respondenDelete(int $id): \CodeIgniter\HTTP\ResponseInterface
    {
        (new MahasiswaModel())->delete($id);
        return redirect()->to('/admin/mahasiswa')->with('success', 'Data responden berhasil dihapus.');
    }

    // ══════════════════════════════════════════════════════════
    // HASIL TES
    // ══════════════════════════════════════════════════════════

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

        $total = $builder->countAllResults(false);
        $hasil = $builder->limit($perPage, ($page - 1) * $perPage)->get()->getResultArray();

        return view('admin/layout', [
            'content'    => view('admin/hasil_tes', compact('hasil','total','page','perPage','search','filter')),
            'title'      => 'Hasil Tes - Admin Mentality',
            'activePage' => 'hasil_tes',
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // KELOLA FORM KUESIONER (CRUD Field)
    // ══════════════════════════════════════════════════════════

    public function formFields(): string
    {
        $fields = (new FormFieldModel())->getAll();

        return view('admin/layout', [
            'content'    => view('admin/form_fields', compact('fields')),
            'title'      => 'Kelola Form Kuesioner - Admin Mentality',
            'activePage' => 'form_fields',
        ]);
    }

    public function formFieldsSave(): \CodeIgniter\HTTP\ResponseInterface
    {
        $model = new FormFieldModel();
        $id    = $this->request->getPost('id');

        $data = [
            'label'       => $this->request->getPost('label'),
            'name'        => strtolower(str_replace(' ', '_', $this->request->getPost('name'))),
            'type'        => $this->request->getPost('type'),
            'placeholder' => $this->request->getPost('placeholder'),
            'required'    => $this->request->getPost('required') ? 1 : 0,
            'aktif'       => $this->request->getPost('aktif') ? 1 : 0,
            'urutan'      => (int)$this->request->getPost('urutan'),
        ];

        // Handle options untuk select/radio
        $optionsRaw = $this->request->getPost('options');
        if (!empty($optionsRaw)) {
            $opts = array_filter(array_map('trim', explode("\n", $optionsRaw)));
            $data['options'] = json_encode(array_values($opts));
        } else {
            $data['options'] = null;
        }

        // Validasi nama field tidak boleh duplikat saat tambah baru
        if (!$id) {
            $existing = $model->where('name', $data['name'])->first();
            if ($existing) {
                return redirect()->back()->withInput()
                    ->with('error', 'Nama field "' . $data['name'] . '" sudah digunakan!');
            }
        }

        if ($id) {
            // Field default tidak boleh ubah nama & type
            $existing = $model->find($id);
            if ($existing && $model->isDefault($existing['name'])) {
                unset($data['name'], $data['type']);
            }
            $model->update($id, $data);
            $msg = 'Field berhasil diperbarui.';
        } else {
            $model->insert($data);
            $msg = 'Field berhasil ditambahkan.';
        }

        return redirect()->to('/admin/form-fields')->with('success', $msg);
    }

    public function formFieldsDelete(int $id): \CodeIgniter\HTTP\ResponseInterface
    {
        $model = new FormFieldModel();
        $field = $model->find($id);

        if (!$field) {
            return redirect()->to('/admin/form-fields')->with('error', 'Field tidak ditemukan.');
        }

        // Field default tidak boleh dihapus
        if ($model->isDefault($field['name'])) {
            return redirect()->to('/admin/form-fields')
                ->with('error', 'Field "' . $field['label'] . '" adalah field wajib dan tidak dapat dihapus!');
        }

        $model->delete($id);
        return redirect()->to('/admin/form-fields')->with('success', 'Field berhasil dihapus.');
    }

    public function formFieldsToggle(int $id): \CodeIgniter\HTTP\ResponseInterface
    {
        $model = new FormFieldModel();
        $field = $model->find($id);

        if (!$field) {
            return $this->response->setJSON(['success' => false]);
        }

        $newStatus = $field['aktif'] ? 0 : 1;
        $model->update($id, ['aktif' => $newStatus]);

        return $this->response->setJSON([
            'success' => true,
            'aktif'   => $newStatus,
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // SECURITY LOGS
    // ══════════════════════════════════════════════════════════

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

    // ══════════════════════════════════════════════════════════
    // KELOLA BLOG
    // ══════════════════════════════════════════════════════════

    public function blogs(): string
    {
        $blogs = (new BlogModel())->orderBy('created_at','DESC')->findAll();

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