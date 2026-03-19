<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($title ?? 'Admin Mentality') ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="<?= base_url('css/mentality.css') ?>" rel="stylesheet">
  <style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f1f5f9; }

    /* Sidebar */
    .admin-sidebar {
      width: 240px; min-height: 100vh;
      background: linear-gradient(180deg, #0f4c2a 0%, #071f12 100%);
      position: fixed; top: 0; left: 0; z-index: 100;
      display: flex; flex-direction: column;
      transition: all .3s ease;
    }
    .sidebar-brand {
      padding: 1.25rem 1.5rem;
      border-bottom: 1px solid rgba(255,255,255,.08);
    }
    .sidebar-brand .brand-text { font-size: 1.1rem; font-weight: 800; color: white; }
    .sidebar-brand .brand-sub  { font-size: .7rem; color: rgba(255,255,255,.4); }

    .sidebar-menu { padding: .75rem 0; flex: 1; }
    .sidebar-menu .menu-label {
      font-size: .65rem; font-weight: 700; letter-spacing: 1px;
      color: rgba(255,255,255,.3); padding: .75rem 1.5rem .3rem;
      text-transform: uppercase;
    }
    .sidebar-link {
      display: flex; align-items: center; gap: .75rem;
      padding: .65rem 1.5rem;
      color: rgba(255,255,255,.6);
      font-size: .85rem; font-weight: 600;
      text-decoration: none;
      transition: all .2s ease;
      border-left: 3px solid transparent;
    }
    .sidebar-link:hover { color: white; background: rgba(255,255,255,.07); }
    .sidebar-link.active {
      color: white;
      background: rgba(255,255,255,.1);
      border-left-color: #00c96b;
    }
    .sidebar-link i { font-size: 1rem; width: 20px; text-align: center; }

    .sidebar-footer {
      padding: 1rem 1.5rem;
      border-top: 1px solid rgba(255,255,255,.08);
    }

    /* Main content */
    .admin-main {
      margin-left: 240px;
      min-height: 100vh;
      display: flex; flex-direction: column;
    }
    .admin-topbar {
      background: white;
      padding: .85rem 1.75rem;
      border-bottom: 1px solid #e2e8f0;
      display: flex; align-items: center; justify-content: space-between;
      position: sticky; top: 0; z-index: 99;
    }
    .admin-content { padding: 1.75rem; flex: 1; }

    /* Cards */
    .stat-card-admin {
      background: white;
      border-radius: 14px;
      padding: 1.4rem;
      border: 1px solid #e2e8f0;
      transition: all .2s ease;
    }
    .stat-card-admin:hover { box-shadow: 0 4px 20px rgba(0,0,0,.08); transform: translateY(-2px); }
    .stat-icon {
      width: 48px; height: 48px;
      border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.3rem;
    }
    .stat-num { font-size: 1.8rem; font-weight: 800; line-height: 1; }
    .stat-label { font-size: .78rem; color: #64748b; font-weight: 500; }

    /* Table */
    .admin-table { background: white; border-radius: 14px; overflow: hidden; border: 1px solid #e2e8f0; }
    .admin-table .table { margin: 0; }
    .admin-table .table th {
      background: #f8fafc; font-size: .75rem; font-weight: 700;
      text-transform: uppercase; letter-spacing: .5px; color: #64748b;
      border-bottom: 1px solid #e2e8f0; padding: .85rem 1rem;
    }
    .admin-table .table td { padding: .85rem 1rem; font-size: .85rem; vertical-align: middle; border-color: #f1f5f9; }
    .admin-table .table tr:hover td { background: #f8fafc; }
    .table-header {
      padding: 1.25rem 1.5rem;
      border-bottom: 1px solid #e2e8f0;
      display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .75rem;
    }
    .table-header h6 { font-weight: 700; margin: 0; }

    /* Badge kategori */
    .badge-normal     { background: #dcfce7; color: #166534; }
    .badge-ringan     { background: #fef9c3; color: #854d0e; }
    .badge-sedang     { background: #ffedd5; color: #9a3412; }
    .badge-berat      { background: #fee2e2; color: #991b1b; }
    .badge-sangat-berat { background: #fce7f3; color: #831843; }

    @media (max-width: 768px) {
      .admin-sidebar { width: 100%; min-height: auto; position: relative; }
      .admin-main { margin-left: 0; }
    }
  </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="admin-sidebar">
  <div class="sidebar-brand">
    <div class="d-flex align-items-center gap-2">
      <div class="brand-icon brand-icon-sm"><i class="bi bi-heart-pulse-fill"></i></div>
      <div>
        <div class="brand-text">Mentality</div>
        <div class="brand-sub">Admin Panel</div>
      </div>
    </div>
  </div>

  <nav class="sidebar-menu">
    <div class="menu-label">Utama</div>
    <a href="<?= base_url('admin') ?>" class="sidebar-link <?= ($activePage??'')==='dashboard'?'active':'' ?>">
      <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <div class="menu-label">Data</div>
    <a href="<?= base_url('admin/mahasiswa') ?>" class="sidebar-link <?= ($activePage??'')==='responden'?'active':'' ?>">
      <i class="bi bi-people-fill"></i> Data Responden
    </a>
    <a href="<?= base_url('admin/hasil-tes') ?>" class="sidebar-link <?= ($activePage??'')==='hasil_tes'?'active':'' ?>">
      <i class="bi bi-clipboard2-data-fill"></i> Hasil Tes
    </a>

    <div class="menu-label">Konten</div>
    <a href="<?= base_url('admin/blogs') ?>" class="sidebar-link <?= ($activePage??'')==='blogs'?'active':'' ?>">
      <i class="bi bi-journal-richtext"></i> Kelola Blog
    </a>

    <div class="menu-label">Keamanan</div>
    <a href="<?= base_url('admin/security-logs') ?>" class="sidebar-link <?= ($activePage??'')==='security'?'active':'' ?>">
      <i class="bi bi-shield-exclamation"></i> Security Logs
    </a>
  </nav>

  <div class="sidebar-footer">
    <a href="<?= base_url('/') ?>" class="sidebar-link" style="border-radius:8px;padding:.5rem .75rem">
      <i class="bi bi-globe"></i> Lihat Website
    </a>
    <a href="<?= base_url('admin/logout') ?>" class="sidebar-link" style="border-radius:8px;padding:.5rem .75rem;color:rgba(255,100,100,.7)">
      <i class="bi bi-box-arrow-left"></i> Logout
    </a>
  </div>
</aside>

<!-- MAIN -->
<div class="admin-main">
  <!-- Topbar -->
  <div class="admin-topbar">
    <div>
      <h6 class="fw-bold mb-0" style="font-size:.95rem"><?= esc($title ?? 'Admin') ?></h6>
      <p class="text-muted mb-0" style="font-size:.75rem"><?= date('l, d F Y') ?></p>
    </div>
    <div class="d-flex align-items-center gap-3">
      <div class="d-flex align-items-center gap-2">
        <div style="width:34px;height:34px;background:var(--green-pale);border-radius:50%;display:flex;align-items:center;justify-content:center">
          <i class="bi bi-person-fill text-green-main"></i>
        </div>
        <div>
          <div style="font-size:.82rem;font-weight:700"><?= esc(session()->get('admin_nama')) ?></div>
          <div style="font-size:.7rem;color:#64748b">Administrator</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Flash messages -->
  <div class="px-4 pt-3">
    <?php foreach(['success'=>'success','error'=>'danger','info'=>'info'] as $k=>$c): ?>
      <?php if($msg = session()->getFlashdata($k)): ?>
      <div class="alert alert-<?= $c ?> alert-dismissible fade show rounded-3" role="alert">
        <?= esc($msg) ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>

  <!-- Content -->
  <div class="admin-content">
    <?= $content ?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</body>
</html>
