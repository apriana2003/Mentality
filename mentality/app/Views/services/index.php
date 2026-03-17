<!-- SERVICES HEADER -->
<section class="section-pad-sm" style="background:linear-gradient(135deg,var(--green-dark),var(--green-main))">
  <div class="container text-center py-4">
    <div class="section-badge" style="background:rgba(255,255,255,.15);color:white"><i class="bi bi-grid"></i> Layanan Kami</div>
    <h1 class="text-white fw-bold mt-2" style="font-size:2.2rem">Layanan Kesehatan Mental</h1>
    <p class="text-white-50 mx-auto" style="max-width:560px">Kenali berbagai masalah kesehatan mental yang umum dialami dan temukan layanan konseling AI yang tepat.</p>
  </div>
</section>

<!-- MASALAH UMUM -->
<section class="section-pad">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-lg-7 text-center">
        <div class="section-badge"><i class="bi bi-info-circle"></i> Edukasi</div>
        <h2 class="section-title mt-2">Masalah Kesehatan Mental Umum</h2>
        <p class="section-subtitle mx-auto">Klik kartu untuk mempelajari lebih lanjut dan mulai konseling dengan AI.</p>
      </div>
    </div>

    <div class="row g-4">
      <?php
      $layanan = [
        ['bi-wind','amber','Stres','Tekanan berlebih akibat tuntutan akademik, pekerjaan, atau kehidupan sosial yang melebihi kapasitas koping seseorang.','Stres ringan wajar dialami, namun stres berkepanjangan bisa merusak kesehatan fisik dan mental.'],
        ['bi-lightning-charge','coral','Gangguan Kecemasan','Kekhawatiran berlebihan, gelisah, atau ketakutan intens yang mengganggu aktivitas sehari-hari tanpa alasan jelas.','Termasuk GAD, panic disorder, dan social anxiety yang sangat umum di kalangan mahasiswa.'],
        ['bi-cloud-rain','blue','Depresi','Perasaan sedih mendalam, kehilangan minat, dan kelelahan yang berlangsung lebih dari 2 minggu.','Bukan sekadar rasa sedih biasa — depresi adalah kondisi medis yang memerlukan perhatian serius.'],
        ['bi-bandaid','purple','Trauma & PTSD','Respons psikologis terhadap kejadian yang sangat menyakitkan atau mengancam jiwa.','Bisa muncul setelah kecelakaan, kehilangan, kekerasan, atau peristiwa traumatis lainnya.'],
        ['bi-graph-down','teal','Gangguan Mood','Perubahan suasana hati yang ekstrem dan tidak terduga, termasuk bipolar disorder.','Memengaruhi energi, aktivitas, dan kemampuan menjalani kehidupan sehari-hari.'],
        ['bi-dash-circle','green','Sering Blank / Disosiatif','Perasaan terputus dari diri sendiri atau lingkungan, pikiran kosong, atau susah berkonsentrasi.','Sering diabaikan namun bisa menjadi tanda kondisi yang memerlukan perhatian.'],
        ['bi-people','amber','Hubungan & Keluarga','Konflik dalam hubungan romantis, keluarga, atau pertemanan yang berdampak pada kesehatan mental.','Dukungan sosial sangat penting — masalah hubungan adalah salah satu pemicu stres terbesar.'],
      ];
      foreach($layanan as $l): ?>
      <div class="col-lg-4 col-md-6">
        <div class="service-card h-100">
          <div class="card-header-custom" style="background:var(--green-pale)">
            <i class="bi <?= $l[0] ?>" style="color:var(--green-main);font-size:2.5rem"></i>
          </div>
          <div class="card-body">
            <h5 class="card-title"><?= $l[2] ?></h5>
            <p class="card-text"><?= $l[3] ?></p>
            <p class="card-text text-muted" style="font-size:.8rem"><?= $l[4] ?></p>
            <a href="<?= base_url('services/konseling') ?>" class="card-link">
              Konsultasi AI <i class="bi bi-arrow-right"></i>
            </a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>

      <!-- Tes Mental Card -->
      <div class="col-lg-4 col-md-6">
        <div class="service-card h-100" style="background:linear-gradient(135deg,var(--green-dark),var(--green-main));border-color:transparent">
          <div class="card-header-custom" style="background:rgba(255,255,255,.1)">
            <i class="bi bi-clipboard2-pulse" style="color:white;font-size:2.5rem"></i>
          </div>
          <div class="card-body">
            <h5 class="card-title text-white">Tes DASS-21</h5>
            <p class="card-text text-white-50">Tidak yakin apa yang kamu rasakan? Mulai dengan tes terstandarisasi DASS-21 untuk mengetahui kondisi mentalmu.</p>
            <a href="<?= base_url('form') ?>" class="btn btn-light btn-sm rounded-pill mt-2 fw-bold" style="color:var(--green-main)">
              <i class="bi bi-play-fill me-1"></i>Mulai Tes
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CARA KERJA -->
<section class="section-pad stats-section">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-lg-7 text-center">
        <div class="section-badge"><i class="bi bi-diagram-3"></i> Alur</div>
        <h2 class="section-title mt-2">Bagaimana Cara Kerjanya?</h2>
      </div>
    </div>
    <div class="row g-4 justify-content-center">
      <?php foreach([
        ['1','bi-person-fill-add','green','Isi Data Diri','Masukkan nama, email, dan informasi dasar. Anonim dan aman.'],
        ['2','bi-clipboard2-check-fill','teal','Kerjakan Tes DASS-21','Jawab 21 pertanyaan singkat tentang kondisimu 1 minggu terakhir.'],
        ['3','bi-bar-chart-fill','amber','Lihat Hasil Instan','Skor dan kategori ditampilkan langsung dengan penjelasan lengkap.'],
        ['4','bi-robot','coral','Chat dengan AI','Diskusikan hasilmu dengan Mentality AI yang sudah tahu kondisimu.'],
      ] as $step): ?>
      <div class="col-lg-3 col-md-6">
        <div class="card-mentality text-center">
          <div style="width:48px;height:48px;background:var(--green-main);color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.2rem;font-weight:800;margin:0 auto 1rem"><?= $step[0] ?></div>
          <div class="card-icon <?= $step[2] ?> mx-auto"><i class="bi <?= $step[1] ?>"></i></div>
          <h6 class="fw-bold mt-3 mb-1"><?= $step[3] ?></h6>
          <p class="text-muted small mb-0"><?= $step[4] ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-5">
      <a href="<?= base_url('form') ?>" class="btn btn-primary-custom btn-lg px-5">
        <i class="bi bi-play-circle-fill me-2"></i>Mulai Sekarang — Gratis
      </a>
    </div>
  </div>
</section>
