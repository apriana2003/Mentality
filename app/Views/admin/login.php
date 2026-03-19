<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin - Mentality</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
  <link href="<?= base_url('css/mentality.css') ?>" rel="stylesheet">
  <style>
    body { background: linear-gradient(135deg, #0f4c2a 0%, #1a6b3c 50%, #0d9488 100%); min-height: 100vh; display: flex; align-items: center; font-family: 'Plus Jakarta Sans', sans-serif; }
  </style>
</head>
<body>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-5 col-sm-8">

      <!-- Logo -->
      <div class="text-center mb-4">
        <div class="brand-icon mx-auto mb-3" style="width:56px;height:56px;font-size:1.5rem">
          <i class="bi bi-heart-pulse-fill"></i>
        </div>
        <h4 class="text-white fw-bold mb-0">Mentality</h4>
        <p class="text-white-50 small">Admin Panel</p>
      </div>

      <!-- Card -->
      <div class="bg-white rounded-4 shadow-lg p-4">
        <h5 class="fw-bold mb-1">Selamat Datang 👋</h5>
        <p class="text-muted small mb-4">Masuk untuk mengelola sistem Mentality.</p>

        <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger rounded-3 small">
          <i class="bi bi-exclamation-triangle me-2"></i><?= esc(session()->getFlashdata('error')) ?>
        </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/login') ?>" method="POST">
          <?= csrf_field() ?>

          <div class="mb-3">
            <label class="form-label-mentality">Email</label>
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
              <input type="email" name="email" class="form-control form-control-mentality border-start-0 ps-0"
                placeholder="admin@mentality.id" value="<?= esc(old('email')) ?>" required>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label-mentality">Password</label>
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
              <input type="password" name="password" id="passwordInput"
                class="form-control form-control-mentality border-start-0 border-end-0 ps-0"
                placeholder="••••••••" required>
              <span class="input-group-text bg-light border-start-0" style="cursor:pointer" onclick="togglePass()">
                <i class="bi bi-eye" id="eyeIcon"></i>
              </span>
            </div>
          </div>

          <button type="submit" class="btn btn-primary-custom w-100 py-2">
            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
          </button>
        </form>

        <div class="text-center mt-3">
          <a href="<?= base_url('/') ?>" class="small text-muted">
            <i class="bi bi-arrow-left me-1"></i>Kembali ke Website
          </a>
        </div>
      </div>

      <p class="text-center text-white-50 small mt-3">
        <i class="bi bi-shield-check me-1"></i>Akses terbatas untuk administrator
      </p>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePass() {
  const input = document.getElementById('passwordInput');
  const icon  = document.getElementById('eyeIcon');
  if (input.type === 'password') {
    input.type = 'text';
    icon.className = 'bi bi-eye-slash';
  } else {
    input.type = 'password';
    icon.className = 'bi bi-eye';
  }
}
</script>
</body>
</html>
