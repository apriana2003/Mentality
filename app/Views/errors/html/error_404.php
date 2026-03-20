<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 - Halaman Tidak Ditemukan | Mentality</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: linear-gradient(135deg, #0f4c2a 0%, #1a6b3c 50%, #0d9488 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      position: relative;
    }

    body::before {
      content: '';
      position: absolute; inset: 0;
      background-image:
        linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
      background-size: 40px 40px;
    }

    .blob {
      position: absolute;
      border-radius: 50%;
      filter: blur(80px);
      opacity: .15;
      animation: blobFloat 8s ease-in-out infinite;
    }
    .blob-1 { width: 400px; height: 400px; background: #00c96b; top: -100px; right: -50px; }
    .blob-2 { width: 300px; height: 300px; background: #0d9488; bottom: -80px; left: 5%; animation-delay: -4s; }

    @keyframes blobFloat {
      0%,100% { transform: translateY(0); }
      50%      { transform: translateY(-25px); }
    }

    .error-card {
      position: relative;
      z-index: 1;
      background: rgba(255,255,255,.08);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255,255,255,.15);
      border-radius: 24px;
      padding: 3rem 2.5rem;
      text-align: center;
      max-width: 520px;
      width: 90%;
      box-shadow: 0 25px 60px rgba(0,0,0,.3);
      animation: cardIn .6s cubic-bezier(.34,1.56,.64,1);
    }
    @keyframes cardIn {
      from { opacity:0; transform: translateY(40px) scale(.95); }
      to   { opacity:1; transform: translateY(0) scale(1); }
    }

    .icon-wrap {
      width: 100px; height: 100px;
      background: rgba(255,255,255,.12);
      border-radius: 28px;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 1.5rem;
      font-size: 3rem;
      color: white;
      animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
      0%,100% { transform: translateY(0); }
      50%      { transform: translateY(-10px); }
    }

    .error-code {
      font-size: 5rem;
      font-weight: 800;
      line-height: 1;
      background: linear-gradient(135deg, #ffffff, #86efac);
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

    /* Suggestions */
    .suggestions {
      background: rgba(255,255,255,.07);
      border-radius: 12px;
      padding: 1rem 1.25rem;
      margin-bottom: 2rem;
      text-align: left;
    }
    .suggestions .label {
      font-size: .72rem;
      font-weight: 700;
      color: #86efac;
      text-transform: uppercase;
      letter-spacing: .5px;
      margin-bottom: .75rem;
    }
    .suggestions a {
      display: flex;
      align-items: center;
      gap: .6rem;
      color: rgba(255,255,255,.7);
      text-decoration: none;
      font-size: .85rem;
      padding: .4rem 0;
      transition: color .2s;
    }
    .suggestions a:hover { color: #86efac; }
    .suggestions a i { color: #86efac; width: 18px; }

    .btn-home {
      background: white;
      color: #0f4c2a;
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
      box-shadow: 0 4px 20px rgba(0,0,0,.2);
    }
    .btn-home:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(0,0,0,.3);
      color: #0f4c2a;
    }

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
  </style>
</head>
<body>

  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>

  <div class="error-card">

    <div class="icon-wrap">
      <i class="bi bi-compass"></i>
    </div>

    <div class="error-code">404</div>
    <h1 class="error-title">Halaman Tidak Ditemukan</h1>
    <p class="error-desc">
      Sepertinya halaman yang kamu cari tidak ada atau sudah dipindahkan.
      Jangan khawatir, kamu masih bisa mengakses layanan kami!
    </p>

    <!-- Saran halaman -->
    <div class="suggestions">
      <div class="label"><i class="bi bi-map me-1"></i>Mungkin kamu mencari:</div>
      <a href="/"><i class="bi bi-house-fill"></i> Beranda</a>
      <a href="/form"><i class="bi bi-clipboard2-pulse-fill"></i> Mulai Tes Mental</a>
      <a href="/services/konseling"><i class="bi bi-robot"></i> Konseling AI</a>
      <a href="/blogs"><i class="bi bi-journal-text"></i> Blog Kesehatan Mental</a>
    </div>

    <a href="/" class="btn-home">
      <i class="bi bi-house-fill"></i> Kembali ke Beranda
    </a>

    <div class="security-badge">
      <i class="bi bi-shield-check-fill"></i>
      Mentality — Platform Monitoring Kesehatan Mental
    </div>

  </div>

</body>
</html>