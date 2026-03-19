<?php
$hasil  = $hasil  ?? [];
$status = $status ?? ['label'=>'Sehat','color'=>'success','icon'=>'bi-emoji-smile','desc'=>''];
$colorMap = ['Normal'=>'success','Ringan'=>'warning','Sedang'=>'orange','Berat'=>'danger','Sangat Berat'=>'danger'];
?>

<!-- HASIL HERO -->
<section class="section-pad-sm" style="background:var(--gray-50)">
  <div class="container">

    <!-- Breadcrumb -->
    <div class="d-flex align-items-center gap-2 mb-4" style="font-size:.85rem">
      <span class="badge rounded-pill text-white bg-green-main px-3 py-2">1. Data Diri ✓</span>
      <i class="bi bi-arrow-right text-muted"></i>
      <span class="badge rounded-pill text-white bg-green-main px-3 py-2">2. Tes DASS-21 ✓</span>
      <i class="bi bi-arrow-right text-muted"></i>
      <span class="badge rounded-pill bg-white px-3 py-2" style="color:var(--green-main);border:2px solid var(--green-main)">3. Hasil ✓</span>
    </div>

    <div class="row g-4 align-items-start">

      <!-- Kiri: Status Umum -->
      <div class="col-lg-5">
        <div class="hasil-hero">
          <div class="position-relative" style="z-index:1">
            <p class="text-white-50 small mb-2">Hasil Tes untuk</p>
            <h4 class="text-white fw-bold mb-1"><?= esc($hasil['nama'] ?? 'Peserta') ?></h4>
            <p class="text-white-50 small mb-4"><?= esc($hasil['email'] ?? '') ?></p>

            <div class="mb-3">
              <i class="bi <?= $status['icon'] ?> text-white" style="font-size:2.5rem;opacity:.9"></i>
            </div>
            <h2 class="text-white fw-bold mb-2" style="font-size:1.8rem"><?= $status['label'] ?></h2>
            <p class="text-white-50 small"><?= $status['desc'] ?></p>

            <!-- Tiga skor -->
            <div class="row g-3 mt-3">
              <?php
              $scores = [
                ['Depresi',$hasil['skor_depresi'],$hasil['kategori_depresi']],
                ['Kecemasan',$hasil['skor_kecemasan'],$hasil['kategori_kecemasan']],
                ['Stres',$hasil['skor_stres'],$hasil['kategori_stres']],
              ];
              foreach($scores as $sc):
                $ringColor = match($sc[2]) {
                  'Normal' => 'success',
                  'Ringan' => 'warning',
                  default  => 'danger',
                };
              ?>
              <div class="col-4">
                <div class="score-ring <?= $ringColor ?>">
                  <?= $sc[1] ?>
                  <span class="ring-label">/42</span>
                </div>
                <p class="text-white small text-center mb-0" style="font-size:.75rem"><?= $sc[0] ?></p>
                <p class="text-white-50 text-center mb-0" style="font-size:.7rem"><?= $sc[2] ?></p>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

        <!-- Tombol aksi -->
        <div class="d-flex gap-2 mt-3">
          <a href="<?= base_url('services/konseling') ?>" class="btn btn-primary-custom flex-fill">
            <i class="bi bi-robot me-2"></i>Konsultasi AI
          </a>
          <a href="<?= base_url('form') ?>" class="btn btn-outline-green flex-fill">
            <i class="bi bi-arrow-repeat me-2"></i>Tes Ulang
          </a>
        </div>
      </div>

      <!-- Kanan: Detail & Saran -->
      <div class="col-lg-7">

        <!-- Detail per subskala -->
        <div class="card-mentality mb-4">
          <h5 class="fw-bold mb-3"><i class="bi bi-bar-chart-fill me-2 text-green-main"></i>Detail Hasil DASS-21</h5>
          <?php
          $info = [
            'Depresi' => [
              'Normal'      => 'Tidak ada tanda-tanda depresi signifikan.',
              'Ringan'      => 'Ada sedikit tanda depresi. Perhatikan pola tidur dan aktivitas.',
              'Sedang'      => 'Depresi sedang terdeteksi. Pertimbangkan berbicara dengan konselor.',
              'Berat'       => 'Depresi berat. Sangat disarankan berkonsultasi dengan psikolog.',
              'Sangat Berat'=> 'Depresi sangat berat. Segera cari bantuan profesional.',
            ],
            'Kecemasan' => [
              'Normal'      => 'Tingkat kecemasan dalam batas normal.',
              'Ringan'      => 'Kecemasan ringan. Teknik relaksasi bisa membantu.',
              'Sedang'      => 'Kecemasan sedang yang perlu diperhatikan.',
              'Berat'       => 'Kecemasan berat yang mengganggu aktivitas harian.',
              'Sangat Berat'=> 'Kecemasan parah. Segera cari bantuan profesional.',
            ],
            'Stres' => [
              'Normal'      => 'Tingkat stres terkendali dengan baik.',
              'Ringan'      => 'Sedikit stres yang wajar dialami.',
              'Sedang'      => 'Stres sedang. Manajemen waktu dan istirahat diperlukan.',
              'Berat'       => 'Stres berat yang membutuhkan perhatian serius.',
              'Sangat Berat'=> 'Stres sangat berat. Segera cari dukungan profesional.',
            ],
          ];
          foreach($scores as $sc):
            $cat = $sc[2];
            $clr = $colorMap[$cat] ?? 'secondary';
          ?>
          <div class="d-flex align-items-start gap-3 mb-3 pb-3 border-bottom">
            <div class="text-center flex-shrink-0" style="width:64px">
              <div class="fw-bold" style="font-size:1.4rem;color:var(--<?= $clr == 'orange' ? 'coral' : $clr ?>,var(--green-main))"><?= $sc[1] ?></div>
              <div style="font-size:.65rem;color:var(--gray-400)">/42</div>
            </div>
            <div class="flex-grow-1">
              <div class="d-flex align-items-center gap-2 mb-1">
                <strong style="font-size:.9rem"><?= $sc[0] ?></strong>
                <span class="badge" style="font-size:.7rem;background:<?= $cat=='Normal'?'var(--green-pale)':($cat=='Ringan'?'var(--amber-light)':'var(--red-light)') ?>;color:<?= $cat=='Normal'?'var(--green-main)':($cat=='Ringan'?'#92400e':'var(--red)') ?>"><?= $cat ?></span>
              </div>
              <p class="text-muted small mb-0"><?= $info[$sc[0]][$cat] ?? '' ?></p>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <!-- Saran -->
        <div class="card-mentality mb-4">
          <h5 class="fw-bold mb-3"><i class="bi bi-lightbulb-fill me-2 text-green-main"></i>Saran & Rekomendasi</h5>
          <?php
          $saranList = [
            ['bi-moon-stars','Istirahat cukup 7–9 jam per malam dan jaga pola tidur yang teratur.'],
            ['bi-bicycle','Olahraga ringan minimal 30 menit, 3x seminggu untuk meningkatkan mood.'],
            ['bi-chat-heart','Ceritakan perasaanmu kepada orang yang kamu percaya.'],
            ['bi-journal-bookmark','Coba journaling — tulis apa yang kamu rasakan setiap hari.'],
            ['bi-robot','Gunakan Chatbot AI kami untuk konsultasi kapan saja.'],
          ];
          if (in_array($status['label'], ['Butuh Bantuan Profesional', 'Perlu Perhatian Lebih'])) {
            array_unshift($saranList, ['bi-hospital','Segera hubungi profesional kesehatan mental atau kunjungi konselor kampus.']);
          }
          foreach($saranList as $s): ?>
          <div class="saran-card mb-2 d-flex align-items-start gap-3">
            <i class="bi <?= $s[0] ?> text-green-main mt-1 flex-shrink-0"></i>
            <span class="small"><?= $s[1] ?></span>
          </div>
          <?php endforeach; ?>
        </div>

        <!-- Hotline -->
        <?php if (in_array($status['label'], ['Butuh Bantuan Profesional', 'Perlu Perhatian Lebih'])): ?>
        <div class="alert border-danger rounded-3 d-flex gap-3">
          <i class="bi bi-telephone-fill text-danger fs-4 flex-shrink-0"></i>
          <div>
            <strong class="d-block mb-1">Butuh Bantuan Segera?</strong>
            <p class="small mb-1">Into The Light Indonesia: <strong>119 ext 8</strong></p>
            <p class="small mb-0">RSJ Soeharto Heerdjan: <strong>021-500-454</strong></p>
          </div>
        </div>
        <?php endif; ?>

      </div>
    </div>
  </div>
</section>

<!-- Simpan hasil tes ke localStorage otomatis -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  if (typeof SesiManager !== 'undefined') {
    SesiManager.saveAfterTes(
      <?= (int)$hasil['mahasiswa_id'] ?>,
      '<?= esc(addslashes($hasil['nama'])) ?>',
      <?= (int)$hasil['id'] ?>,
      <?= (int)$hasil['skor_depresi'] ?>,
      <?= (int)$hasil['skor_kecemasan'] ?>,
      <?= (int)$hasil['skor_stres'] ?>,
      '<?= esc($hasil['kategori_depresi']) ?>',
      '<?= esc($hasil['kategori_kecemasan']) ?>',
      '<?= esc($hasil['kategori_stres']) ?>'
    );
  }
});
</script>