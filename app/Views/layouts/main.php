<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Mentality - Platform Monitoring Kesehatan Mental Mahasiswa">
  <title><?= esc($title ?? 'Mentality') ?></title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
  <link href="<?= base_url('css/mentality.css') ?>" rel="stylesheet">
  <script>
    const BASE_URL = '<?= base_url() ?>';
  </script>
   <?= base_url() ?>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg sticky-top" id="mainNavbar">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="<?= base_url('/') ?>">
      <div class="brand-icon"><i class="bi bi-heart-pulse-fill"></i></div>
      <span class="brand-text">Mentality</span>
    </a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav mx-auto gap-1">
        <li class="nav-item">
          <a class="nav-link <?= (uri_string() == '' ? 'active' : '') ?>" href="<?= base_url('/') ?>">
            <i class="bi bi-house me-1"></i>Beranda
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= (str_starts_with(uri_string(), 'services') ? 'active' : '') ?>" href="<?= base_url('services') ?>">
            <i class="bi bi-grid me-1"></i>Layanan
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= (str_starts_with(uri_string(), 'blogs') ? 'active' : '') ?>" href="<?= base_url('blogs') ?>">
            <i class="bi bi-journal-text me-1"></i>Blog
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= (uri_string() == 'form' || uri_string() == 'tes' ? 'active' : '') ?>" href="<?= base_url('form') ?>">
            <i class="bi bi-clipboard2-pulse me-1"></i>Tes Mental
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= (str_starts_with(uri_string(), 'services/konseling') ? 'active' : '') ?>" href="<?= base_url('services/konseling') ?>">
            <i class="bi bi-robot me-1"></i>Konseling AI
          </a>
        </li>
      </ul>
      <a href="<?= base_url('form') ?>" class="btn btn-primary-custom px-4">
        <i class="bi bi-play-circle me-2"></i>Mulai Tes
      </a>
    </div>
  </div>
</nav>

<!-- FLASH MESSAGES -->
<?php foreach (['success'=>'success','error'=>'danger','info'=>'info'] as $key => $cls): ?>
  <?php if ($msg = session()->getFlashdata($key)): ?>
  <div class="alert-floating alert alert-<?= $cls ?> alert-dismissible fade show shadow" role="alert">
    <i class="bi bi-<?= $key=='success'?'check-circle-fill':($key=='error'?'exclamation-triangle-fill':'info-circle-fill') ?> me-2"></i>
    <?= esc($msg) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
  <?php endif; ?>
<?php endforeach; ?>

<!-- KONTEN -->
<main><?= $content ?></main>

<!-- FOOTER -->
<footer class="footer-main">
  <div class="container">
    <div class="row g-4 py-5">
      <div class="col-lg-4 col-md-6">
        <div class="d-flex align-items-center gap-2 mb-3">
          <div class="brand-icon brand-icon-sm"><i class="bi bi-heart-pulse-fill"></i></div>
          <span class="brand-text text-white fs-5">Mentality</span>
        </div>
        <p class="text-white-50 small lh-lg">Platform monitoring kesehatan mental mahasiswa berbasis web. Kami hadir membantu kamu mengenali dan menjaga kondisi mentalmu.</p>
        <div class="d-flex gap-3 mt-3">
          <a href="#" class="footer-social"><i class="bi bi-instagram"></i></a>
          <a href="#" class="footer-social"><i class="bi bi-twitter-x"></i></a>
          <a href="#" class="footer-social"><i class="bi bi-youtube"></i></a>
        </div>
      </div>
      <div class="col-lg-2 col-md-3 col-6">
        <h6 class="text-white fw-bold mb-3">Menu</h6>
        <ul class="list-unstyled footer-links">
          <li><a href="<?= base_url('/') ?>">Beranda</a></li>
          <li><a href="<?= base_url('services') ?>">Layanan</a></li>
          <li><a href="<?= base_url('blogs') ?>">Blog</a></li>
          <li><a href="<?= base_url('services/konseling') ?>">Konseling AI</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-md-3 col-6">
        <h6 class="text-white fw-bold mb-3">Tes Mental</h6>
        <ul class="list-unstyled footer-links">
          <li><a href="<?= base_url('form') ?>">Isi Data Diri</a></li>
          <li><a href="<?= base_url('tes') ?>">Tes DASS-21</a></li>
          <li><a href="<?= base_url('services/konseling') ?>">Chatbot AI</a></li>
        </ul>
      </div>
      <div class="col-lg-4 col-md-6">
        <h6 class="text-white fw-bold mb-3"><i class="bi bi-telephone-fill me-2 text-danger"></i>Butuh Bantuan Segera?</h6>
        <div class="crisis-card p-3 rounded-3">
          <p class="small text-white-50 mb-2">Hotline Kesehatan Mental Indonesia:</p>
          <p class="text-white fw-semibold mb-1"><i class="bi bi-telephone me-2 text-success"></i>Call Center — 112</p>
          <p class="text-white fw-semibold mb-0"><i class="bi bi-telephone me-2 text-success"></i>0618360542 — RS Jiwa (RSJ) Prof. Dr. Muhammad Ildrem</p>
        </div>
      </div>
    </div>
    <hr class="border-secondary opacity-25">
    <div class="row align-items-center py-3">
      <div class="col-md-6 text-center text-md-start">
        <p class="text-white-50 small mb-0">&copy; <?= date('Y') ?> Mentality. Dibuat untuk skripsi sistem informasi STMIK TIME oleh Apriana 2245046  .</p>
      </div>
      <div class="col-md-6 text-center text-md-end">
        <p class="text-white-50 small mb-0"><i class="bi bi-shield-check me-1 text-success"></i>Dilindungi AI Security Monitor</p>
      </div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('js/mentality.js') ?>"></script>
</body>
</html>
