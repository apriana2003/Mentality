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
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    html, body {
      height: 100%;
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: #f1f5f9;
      overflow-x: hidden;
    }

    .admin-wrapper { display: flex; min-height: 100vh; width: 100%; }

    /* ── Sidebar ── */
    .admin-sidebar {
      width: 240px;
      flex-shrink: 0;
      background: linear-gradient(180deg, #0f4c2a 0%, #071f12 100%);
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0; left: 0;
      height: 100vh;
      overflow-y: auto;
      z-index: 1050;
      transition: transform .3s ease;
    }

    /* ── Main area ── */
    .admin-main {
      flex: 1;
      margin-left: 240px;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      width: calc(100% - 240px);
      overflow-x: hidden;
    }

    /* ── Topbar ── */
    .admin-topbar {
      background: white;
      padding: .85rem 1.5rem;
      border-bottom: 1px solid #e2e8f0;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 99;
      width: 100%;
    }

    .admin-content { padding: 1.5rem; flex: 1; width: 100%; overflow-x: hidden; }

    /* ── Sidebar elements ── */
    .sidebar-brand {
      padding: 1.25rem 1.5rem;
      border-bottom: 1px solid rgba(255,255,255,.08);
      flex-shrink: 0;
    }
    .sidebar-brand .brand-text { font-size: 1.1rem; font-weight: 800; color: white; }
    .sidebar-brand .brand-sub  { font-size: .7rem; color: rgba(255,255,255,.4); }

    .sidebar-menu { padding: .75rem 0; flex: 1; }
    .sidebar-menu .menu-label {
      font-size: .65rem; font-weight: 700; letter-spacing: 1px;
      color: rgba(255,255,255,.3);
      padding: .75rem 1.5rem .3rem;
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
    .sidebar-link.active { color: white; background: rgba(255,255,255,.1); border-left-color: #00c96b; }
    .sidebar-link i { font-size: 1rem; width: 20px; text-align: center; flex-shrink: 0; }

    .sidebar-footer {
      padding: 1rem 1.5rem;
      border-top: 1px solid rgba(255,255,255,.08);
      flex-shrink: 0;
    }

    /* ── Overlay untuk mobile ── */
    .sidebar-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,.5);
      z-index: 1040;
    }
    .sidebar-overlay.show { display: block; }

    /* ── Cards & Tables ── */
    .stat-card-admin {
      background: white; border-radius: 14px; padding: 1.25rem;
      border: 1px solid #e2e8f0; transition: all .2s ease; height: 100%;
    }
    .stat-card-admin:hover { box-shadow: 0 4px 20px rgba(0,0,0,.08); transform: translateY(-2px); }
    .stat-icon {
      width: 46px; height: 46px; border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.2rem; flex-shrink: 0;
    }
    .stat-num { font-size: 1.8rem; font-weight: 800; line-height: 1; }
    .stat-label { font-size: .78rem; color: #64748b; font-weight: 500; margin-top: .25rem; }

    .admin-table {
      background: white; border-radius: 14px; overflow: hidden;
      border: 1px solid #e2e8f0; width: 100%;
    }
    .admin-table .table { margin: 0; width: 100%; }
    .admin-table .table th {
      background: #f8fafc; font-size: .72rem; font-weight: 700;
      text-transform: uppercase; letter-spacing: .5px; color: #64748b;
      border-bottom: 1px solid #e2e8f0; padding: .8rem 1rem; white-space: nowrap;
    }
    .admin-table .table td {
      padding: .8rem 1rem; font-size: .84rem;
      vertical-align: middle; border-color: #f1f5f9;
    }
    .admin-table .table tr:hover td { background: #f8fafc; }
    .table-header {
      padding: 1rem 1.25rem; border-bottom: 1px solid #e2e8f0;
      display: flex; align-items: center; justify-content: space-between;
      flex-wrap: wrap; gap: .75rem;
    }
    .table-header h6 { font-weight: 700; margin: 0; font-size: .9rem; }

    .badge-normal       { background: #dcfce7 !important; color: #166534 !important; }
    .badge-ringan       { background: #fef9c3 !important; color: #854d0e !important; }
    .badge-sedang       { background: #ffedd5 !important; color: #9a3412 !important; }
    .badge-berat        { background: #fee2e2 !important; color: #991b1b !important; }
    .badge-sangat-berat { background: #fce7f3 !important; color: #831843 !important; }
    .badge-severity-low      { background: #dcfce7; color: #166534; }
    .badge-severity-medium   { background: #fef9c3; color: #854d0e; }
    .badge-severity-high     { background: #ffedd5; color: #9a3412; }
    .badge-severity-critical { background: #fee2e2; color: #991b1b; }

    /* ── Tombol hamburger (mobile only) ── */
    .btn-sidebar-toggle {
      display: none;
      background: none;
      border: none;
      font-size: 1.3rem;
      color: #1a6b3c;
      cursor: pointer;
      padding: .25rem .5rem;
      margin-right: .5rem;
    }

    /* ── Responsive ── */
    @media (max-width: 991px) {
      .admin-sidebar { width: 220px; }
      .admin-main { margin-left: 220px; width: calc(100% - 220px); }
    }

    @media (max-width: 767px) {
      /* Sembunyikan sidebar di mobile */
      .admin-sidebar {
        transform: translateX(-100%);
        width: 260px;
      }
      .admin-sidebar.open {
        transform: translateX(0);
      }
      .admin-main {
        margin-left: 0;
        width: 100%;
      }
      .btn-sidebar-toggle {
        display: inline-flex;
        align-items: center;
      }
    }
  </style>
</head>
<body>

<!-- Overlay untuk menutup sidebar di mobile -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<div class="admin-wrapper">

  <!-- ── SIDEBAR ── -->
  <aside class="admin-sidebar" id="adminSidebar">
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

      <div class="menu-label">Kuesioner</div>
      <a href="<?= base_url('admin/pertanyaan-dass') ?>" class="sidebar-link <?= ($activePage??'')==='pertanyaan_dass'?'active':'' ?>">
        <i class="bi bi-patch-question-fill"></i> Pertanyaan DASS-21
      </a>
      <a href="<?= base_url('admin/form-fields') ?>" class="sidebar-link <?= ($activePage??'')=== 'form_fields'?'active':'' ?>">
        <i class="bi bi-ui-checks"></i> Field Kuesioner
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
      <a href="<?= base_url('/') ?>" class="sidebar-link" style="border-radius:8px;padding:.5rem .75rem;margin-bottom:.25rem">
        <i class="bi bi-globe"></i> Lihat Website
      </a>
      <a href="<?= base_url('admin/logout') ?>" class="sidebar-link" style="border-radius:8px;padding:.5rem .75rem;color:rgba(255,120,120,.8)">
        <i class="bi bi-box-arrow-left"></i> Logout
      </a>
    </div>
  </aside>

  <!-- ── MAIN ── -->
  <div class="admin-main">

    <!-- Topbar -->
    <div class="admin-topbar">
      <div class="d-flex align-items-center">
        <!-- Tombol hamburger (mobile) -->
        <button class="btn-sidebar-toggle" onclick="toggleSidebar()">
          <i class="bi bi-list"></i>
        </button>
        <div>
          <h6 class="fw-bold mb-0" style="font-size:.92rem"><?= esc($title ?? 'Admin') ?></h6>
          <p class="text-muted mb-0" style="font-size:.73rem"><?= date('l, d F Y') ?></p>
        </div>
      </div>
      <div class="d-flex align-items-center gap-2">
        <div style="width:34px;height:34px;background:#e8f5ee;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0">
          <i class="bi bi-person-fill" style="color:#1a6b3c"></i>
        </div>
        <div class="d-none d-md-block">
          <div style="font-size:.82rem;font-weight:700;line-height:1.2"><?= esc(session()->get('admin_nama') ?? 'Admin') ?></div>
          <div style="font-size:.7rem;color:#64748b">Administrator</div>
        </div>
      </div>
    </div>

    <!-- Flash messages -->
    <?php foreach(['success'=>'success','error'=>'danger','info'=>'info'] as $k=>$c): ?>
      <?php if($msg = session()->getFlashdata($k)): ?>
      <div class="mx-3 mt-3">
        <div class="alert alert-<?= $c ?> alert-dismissible fade show rounded-3 mb-0" role="alert">
          <?= esc($msg) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      </div>
      <?php endif; ?>
    <?php endforeach; ?>

    <!-- Page content -->
    <div class="container-fluid p-3">
      <?= $content ?>
    </div>

  </div><!-- end admin-main -->

</div><!-- end admin-wrapper -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
  const sidebar  = document.getElementById('adminSidebar');
  const overlay  = document.getElementById('sidebarOverlay');
  sidebar.classList.toggle('open');
  overlay.classList.toggle('show');
}

function closeSidebar() {
  document.getElementById('adminSidebar').classList.remove('open');
  document.getElementById('sidebarOverlay').classList.remove('show');
}

// Tutup sidebar otomatis saat klik menu di mobile
document.querySelectorAll('.sidebar-link').forEach(link => {
  link.addEventListener('click', () => {
    if (window.innerWidth <= 767) closeSidebar();
  });
});
</script>
</body>
</html>