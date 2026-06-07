<?php $recentBlogs = $recentBlogs ?? []; $totalMahasiswa = $totalMahasiswa ?? 0; $totalTes = $totalTes ?? 0; ?>

<!-- HERO -->
<section class="hero-section">
  <div class="hero-blob hero-blob-1"></div>
  <div class="hero-blob hero-blob-2"></div>
  <div class="container position-relative" style="z-index:1">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <div class="section-badge"><i class="bi bi-heart-pulse"></i> Platform Monitoring Kesehatan Mental</div>
        <h1 class="hero-title mt-2">
          Jaga <span class="highlight">Kesehatan Mental</span><br>Mulai dari Sekarang
        </h1>
        <p class="hero-subtitle mt-3">Kenali kondisi mentalmu melalui tes DASS-21 terstandarisasi, dapatkan hasil instan, dan konsultasikan dengan Chatbot AI yang empatik — gratis & anonim.</p>
        <div class="d-flex gap-3 flex-wrap mt-4">
          <a href="<?= base_url('form') ?>" class="btn btn-primary-custom btn-lg px-5">
            <i class="bi bi-play-circle-fill me-2"></i>Mulai Tes Gratis
          </a>
          <a href="<?= base_url('services/konseling') ?>" class="btn btn-outline-green btn-lg px-4">
            <i class="bi bi-robot me-2"></i>Chatbot AI
          </a>
        </div>
        <div class="hero-stats mt-4">
          <div class="hero-stat">
            <span class="stat-num" data-counter="<?= $totalMahasiswa ?>" data-suffix="+">0+</span>
            <span class="stat-label">Pengguna</span>
          </div>
          <div class="hero-stat">
            <span class="stat-num" data-counter="<?= $totalTes ?>" data-suffix="+">0+</span>
            <span class="stat-label">Tes Selesai</span>
          </div>
          <div class="hero-stat">
            <span class="stat-num">24/7</span>
            <span class="stat-label">AI Siap Bantu</span>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="hero-card">
          <div class="pulse-icon" style="font-size:2.2rem">🧠</div>
          <h5 class="text-white fw-bold mb-2">Tes DASS-21</h5>
          <p class="text-white-50 small mb-3">Alat ukur psikologis terstandarisasi untuk mendeteksi tingkat Depresi, Kecemasan, dan Stres.</p>
          <?php foreach([['bi-person-lines-fill','Isi data diri singkat'],['bi-clipboard2-check','Jawab 21 pertanyaan'],['bi-bar-chart-line','Lihat hasil & rekomendasi'],['bi-robot','Konsultasi dengan AI']] as $s): ?>
          <div class="d-flex align-items-center gap-3 mb-2">
            <div style="width:32px;height:32px;background:rgba(255,255,255,.15);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
              <i class="bi <?= $s[0] ?> text-white" style="font-size:.85rem"></i>
            </div>
            <span class="text-white-50 small"><?= $s[1] ?></span>
          </div>
          <?php endforeach; ?>
          <a href="<?= base_url('form') ?>" class="btn btn-primary-custom w-100 mt-3">
            <i class="bi bi-arrow-right-circle me-2"></i>Mulai Sekarang
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PENJELASAN KESEHATAN MENTAL -->
<section class="section-pad">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-lg-7 text-center">
        <div class="section-badge"><i class="bi bi-book-open"></i> Edukasi</div>
        <h2 class="section-title mt-2">Apa Itu Kesehatan Mental?</h2>
        <p class="section-subtitle mx-auto">Kesehatan mental mencakup kesejahteraan emosional, psikologis, dan sosial yang memengaruhi cara kita berpikir, merasa, dan bertindak.</p>
      </div>
    </div>
    <div class="row g-4">
      <?php foreach([
        ['bi-emoji-smile','green','Sehat Mental','Mampu mengatasi tekanan, bekerja produktif, dan berkontribusi pada lingkungan sekitar.'],
        ['bi-exclamation-triangle','amber','Tanda Masalah','Perubahan mood ekstrem, menarik diri, atau kesulitan menjalankan aktivitas harian.'],
        ['bi-heart','coral','Pentingnya Deteksi Dini','Semakin cepat terdeteksi, semakin mudah ditangani. Tes rutin membantu pemantauan kondisimu.'],
        ['bi-people','teal','Kamu Tidak Sendiri','1 dari 8 orang di dunia mengalami gangguan mental. Mencari bantuan adalah langkah berani.'],
      ] as $info): ?>
      <div class="col-lg-3 col-md-6">
        <div class="card-mentality text-center">
          <div class="card-icon <?= $info[1] ?> mx-auto"><i class="bi <?= $info[0] ?>"></i></div>
          <h5 class="fw-bold mb-2" style="font-size:.95rem"><?= $info[2] ?></h5>
          <p class="text-muted small mb-0"><?= $info[3] ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- STATISTIK -->
<section class="section-pad stats-section">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-lg-7 text-center">
        <div class="section-badge"><i class="bi bi-globe-asia-australia"></i> Data Global</div>
        <h2 class="section-title mt-2">Fakta Kesehatan Mental</h2>
        <p class="section-subtitle mx-auto">Data dari WHO dan Kementerian Kesehatan RI.</p>
      </div>
    </div>
    <div class="row g-4 mb-5">
      <?php foreach([
        ['1 Miliar','Orang di dunia hidup dengan gangguan mental (WHO, 2022)','bi-globe','green'],
        ['19,86 Juta','Penduduk Indonesia mengalami gangguan jiwa (Riskesdas, 2018)','bi-flag','teal'],
        ['34,9%','Mahasiswa Indonesia mengalami kecemasan sedang-berat','bi-mortarboard','amber'],
        ['Rp 2.900 T','Kerugian ekonomi global akibat depresi & kecemasan per tahun','bi-cash-stack','coral'],
      ] as $s): ?>
      <div class="col-lg-3 col-md-6">
        <div class="stat-card">
          <div class="card-icon <?= $s[3] ?> mx-auto mb-2"><i class="bi <?= $s[2] ?>"></i></div>
          <span class="big-num"><?= $s[0] ?></span>
          <p class="big-label mt-2"><?= $s[1] ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="row g-4 align-items-center">
      <div class="col-lg-6">
        <h4 class="fw-bold mb-1">Prevalensi Masalah Mental Mahasiswa</h4>
        <p class="text-muted small mb-4">Berdasarkan penelitian di Indonesia (2020–2024)</p>
        <?php foreach([['Kecemasan',72],['Stres Akademik',68],['Burnout',54],['Depresi Ringan-Sedang',35]] as $b): ?>
        <div class="mb-3">
          <div class="d-flex justify-content-between mb-1">
            <span class="small fw-semibold"><?= $b[0] ?></span>
            <span class="small fw-bold text-green-main"><?= $b[1] ?>%</span>
          </div>
          <div class="tes-progress-bar"><div class="fill" style="width:<?= $b[1] ?>%"></div></div>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="col-lg-6">
        <div class="card-mentality bg-green-pale border-0">
          <h5 class="fw-bold mb-3 text-green-main"><i class="bi bi-lightbulb-fill me-2"></i>Mengapa Penting?</h5>
          <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
            <?php foreach(['Deteksi dini mencegah kondisi memburuk','Mahasiswa sehat mental lebih berprestasi','Stigma berkurang dengan edukasi & keterbukaan','Bantuan profesional tersedia dan efektif'] as $p): ?>
            <li class="d-flex align-items-start gap-2 small">
              <i class="bi bi-check-circle-fill text-green-main mt-1 flex-shrink-0"></i><span><?= $p ?></span>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- BLOG TERBARU -->
<?php if (!empty($recentBlogs)): ?>
<section class="section-pad">
  <div class="container">
    <div class="row justify-content-between align-items-end mb-4">
      <div class="col-auto">
        <div class="section-badge"><i class="bi bi-newspaper"></i> Artikel</div>
        <h2 class="section-title mb-0 mt-2">Berita & Informasi Terkini</h2>
      </div>
      <div class="col-auto">
        <a href="<?= base_url('blogs') ?>" class="btn btn-outline-green">Lihat Semua <i class="bi bi-arrow-right ms-1"></i></a>
      </div>
    </div>
    <div class="row g-4">
      <?php
      $icons = ['Stres'=>'bi-wind','Kecemasan'=>'bi-lightning','Depresi'=>'bi-cloud-rain','Tips'=>'bi-lightbulb','Trauma'=>'bi-bandaid'];
      foreach($recentBlogs as $blog):
      ?>
      <div class="col-lg-4 col-md-6">
        <a href="<?= base_url('blogs/' . esc($blog['slug'])) ?>" class="text-decoration-none">
          <div class="blog-card">

            <!-- ── Gambar atau icon default ── -->
            <?php if (!empty($blog['gambar'])): ?>
            <div style="height:180px;overflow:hidden">
              <img
                src="<?= esc($blog['gambar']) ?>"
                alt="<?= esc($blog['judul']) ?>"
                style="width:100%;height:100%;object-fit:cover;transition:transform .3s ease"
                onmouseover="this.style.transform='scale(1.05)'"
                onmouseout="this.style.transform='scale(1)'">
            </div>
            <?php else: ?>
            <div class="blog-img">
              <i class="bi <?= $icons[$blog['kategori']] ?? 'bi-journal-text' ?>"></i>
            </div>
            <?php endif; ?>

            <div class="blog-body">
              <span class="blog-category"><?= esc($blog['kategori']) ?></span>
              <h5 class="blog-title text-dark"><?= esc($blog['judul']) ?></h5>
              <p class="blog-excerpt"><?= esc(substr($blog['ringkasan'] ?? '', 0, 90)) ?>...</p>
              <div class="d-flex justify-content-between align-items-center mt-2">
                <span class="small text-muted">
                  <i class="bi bi-calendar3 me-1"></i><?= date('d M Y', strtotime($blog['created_at'])) ?>
                </span>
                <span class="small text-green-main fw-bold">
                  Baca <i class="bi bi-arrow-right"></i>
                </span>
              </div>
            </div>
          </div>
        </a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- CTA -->
<section class="section-pad" style="background:linear-gradient(135deg,var(--green-dark),var(--green-main))">
  <div class="container text-center">
    <div class="row justify-content-center">
      <div class="col-lg-7">
        <i class="bi bi-heart-pulse-fill text-white" style="font-size:3rem;opacity:.9"></i>
        <h2 class="text-white fw-bold mt-3 mb-3" style="font-size:2rem">Siap Cek Kondisi Mentalmu?</h2>
        <p class="text-white-50 mb-4">Tes DASS-21 hanya butuh 5–10 menit. Gratis, anonim, dan langsung dapat hasil beserta rekomendasi dari AI.</p>
        <a href="<?= base_url('form') ?>" class="btn btn-light btn-lg px-5 fw-bold rounded-pill shadow-lg" style="color:var(--green-main)">
          <i class="bi bi-play-circle-fill me-2"></i>Mulai Tes Sekarang
        </a>
      </div>
    </div>
  </div>
</section>