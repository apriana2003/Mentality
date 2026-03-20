<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>403 - Akses Diblokir | Mentality</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: #0f4c2a;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      position: relative;
    }

    /* Animated background blobs */
    .blob {
      position: absolute;
      border-radius: 50%;
      filter: blur(80px);
      opacity: .15;
      animation: blobFloat 8s ease-in-out infinite;
    }
    .blob-1 { width: 500px; height: 500px; background: #dc2626; top: -150px; right: -100px; }
    .blob-2 { width: 350px; height: 350px; background: #f97316; bottom: -100px; left: -50px; animation-delay: -4s; }
    .blob-3 { width: 250px; height: 250px; background: #1a6b3c; top: 50%; left: 50%; animation-delay: -2s; }

    @keyframes blobFloat {
      0%,100% { transform: translateY(0) scale(1); }
      50%      { transform: translateY(-30px) scale(1.05); }
    }

    /* Grid pattern overlay */
    body::before {
      content: '';
      position: absolute; inset: 0;
      background-image:
        linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
      background-size: 40px 40px;
      z-index: 0;
    }

    /* Card utama */
    .error-card {
      position: relative;
      z-index: 1;
      background: rgba(255,255,255,.06);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(255,255,255,.12);
      border-radius: 24px;
      padding: 3rem 2.5rem;
      text-align: center;
      max-width: 520px;
      width: 90%;
      box-shadow: 0 25px 60px rgba(0,0,0,.4);
      animation: cardIn .6s cubic-bezier(.34,1.56,.64,1);
    }
    @keyframes cardIn {
      from { opacity:0; transform: translateY(40px) scale(.95); }
      to   { opacity:1; transform: translateY(0) scale(1); }
    }

    /* Shield icon */
    .shield-wrap {
      width: 100px; height: 100px;
      background: linear-gradient(135deg, #dc2626, #f97316);
      border-radius: 28px;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 1.5rem;
      font-size: 2.8rem;
      color: white;
      box-shadow: 0 8px 32px rgba(220,38,38,.4);
      animation: pulse 2.5s ease-in-out infinite;
    }
    @keyframes pulse {
      0%,100% { box-shadow: 0 8px 32px rgba(220,38,38,.4); }
      50%      { box-shadow: 0 8px 48px rgba(220,38,38,.7); }
    }

    /* Kode error besar */
    .error-code {
      font-size: 5rem;
      font-weight: 800;
      line-height: 1;
      background: linear-gradient(135deg, #f87171, #fb923c);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin-bottom: .5rem;
      letter-spacing: -2px;
    }

    .error-title {
      font-size: 1.4rem;
      font-weight: 700;
      color: white;
      margin-bottom: .75rem;
    }

    .error-desc {
      color: rgba(255,255,255,.6);
      font-size: .9rem;
      line-height: 1.7;
      margin-bottom: 2rem;
    }

    /* Info detail */
    .threat-info {
      background: rgba(220,38,38,.15);
      border: 1px solid rgba(220,38,38,.3);
      border-radius: 12px;
      padding: 1rem 1.25rem;
      margin-bottom: 2rem;
      text-align: left;
    }
    .threat-info .label {
      font-size: .7rem;
      font-weight: 700;
      color: #f87171;
      text-transform: uppercase;
      letter-spacing: .5px;
      margin-bottom: .5rem;
    }
    .threat-info .detail {
      font-size: .82rem;
      color: rgba(255,255,255,.7);
      display: flex;
      align-items: center;
      gap: .5rem;
      margin-bottom: .3rem;
    }
    .threat-info .detail i { color: #f87171; flex-shrink: 0; }

    /* Tombol */
    .btn-home {
      background: linear-gradient(135deg, #1a6b3c, #2d9155);
      color: white;
      border: none;
      border-radius: 50px;
      padding: .75rem 2rem;
      font-weight: 700;
      font-size: .9rem;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: .5rem;
      transition: all .25s ease;
      box-shadow: 0 4px 20px rgba(26,107,60,.4);
    }
    .btn-home:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(26,107,60,.5);
      color: white;
    }

    .btn-back {
      background: rgba(255,255,255,.1);
      color: rgba(255,255,255,.7);
      border: 1px solid rgba(255,255,255,.15);
      border-radius: 50px;
      padding: .75rem 1.5rem;
      font-weight: 600;
      font-size: .9rem;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: .5rem;
      transition: all .25s ease;
      cursor: pointer;
    }
    .btn-back:hover {
      background: rgba(255,255,255,.15);
      color: white;
    }

    /* Footer info */
    .security-badge {
      margin-top: 2rem;
      font-size: .72rem;
      color: rgba(255,255,255,.3);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: .4rem;
    }
    .security-badge i { color: #22c55e; }

    /* Countdown */
    #countdown { color: #f87171; font-weight: 700; }
  </style>
</head>
<body>

  <!-- Background blobs -->
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>
  <div class="blob blob-3"></div>

  <!-- Card error -->
  <div class="error-card">

    <div class="shield-wrap">
      <i class="bi bi-shield-x"></i>
    </div>

    <div class="error-code">403</div>
    <h1 class="error-title">Akses Diblokir!</h1>
    <p class="error-desc">
      Sistem keamanan <strong style="color:white">Mentality AI Security</strong> mendeteksi
      aktivitas mencurigakan dari permintaan kamu dan telah memblokir akses ini secara otomatis.
    </p>

    <!-- Detail ancaman -->
    <div class="threat-info">
      <div class="label"><i class="bi bi-exclamation-triangle-fill me-1"></i>Detail Kejadian</div>
      <div class="detail">
        <i class="bi bi-geo-alt-fill"></i>
        <span>IP Address: <strong><?= $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1' ?></strong></span>
      </div>
      <div class="detail">
        <i class="bi bi-clock-fill"></i>
        <span>Waktu: <strong><?= date('d M Y, H:i:s') ?></strong></span>
      </div>
      <div class="detail">
        <i class="bi bi-link-45deg"></i>
        <span>URL: <strong style="word-break:break-all"><?= esc(substr($_SERVER['REQUEST_URI'] ?? '/', 0, 60)) ?>...</strong></span>
      </div>
      <div class="detail">
        <i class="bi bi-database-fill-x"></i>
        <span>Aktivitas ini telah <strong>dicatat</strong> di sistem log.</span>
      </div>
    </div>

    <!-- Tombol aksi -->
    <div class="d-flex gap-3 justify-content-center flex-wrap">
      <a href="/" class="btn-home">
        <i class="bi bi-house-fill"></i> Kembali ke Beranda
      </a>
      <button onclick="history.back()" class="btn-back">
        <i class="bi bi-arrow-left"></i> Halaman Sebelumnya
      </button>
    </div>

    <!-- Redirect countdown -->
    <p style="color:rgba(255,255,255,.4);font-size:.78rem;margin-top:1.25rem">
      Redirect otomatis dalam <span id="countdown">10</span> detik...
    </p>

    <div class="security-badge">
      <i class="bi bi-shield-check-fill"></i>
      Dilindungi oleh Mentality AI Security Monitor
    </div>

  </div>

  <script>
    // Countdown redirect
    let sec = 10;
    const el = document.getElementById('countdown');
    const timer = setInterval(() => {
      sec--;
      el.textContent = sec;
      if (sec <= 0) {
        clearInterval(timer);
        window.location.href = '/';
      }
    }, 1000);
  </script>

</body>
</html>