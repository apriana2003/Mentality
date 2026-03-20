<?php
$questions = $questions ?? [];
$total     = count($questions);
?>

<!-- HEADER -->
<div style="background:linear-gradient(135deg,var(--green-dark),var(--green-main));padding:2rem 0">
  <div class="container">
    <!-- Breadcrumb -->
    <div class="d-flex align-items-center gap-2 mb-3" style="font-size:.85rem">
      <a href="<?= base_url('form') ?>" class="badge rounded-pill text-white px-3 py-2" style="background:rgba(255,255,255,.2)">1. Data Diri ✓</a>
      <i class="bi bi-arrow-right text-white-50"></i>
      <span class="badge rounded-pill bg-white px-3 py-2" style="color:var(--green-main)">2. Tes DASS-21</span>
      <i class="bi bi-arrow-right text-white-50"></i>
      <span class="badge rounded-pill text-white px-3 py-2" style="background:rgba(255,255,255,.2)">3. Hasil</span>
    </div>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div>
        <h2 class="text-white fw-bold mb-1">Tes Kesehatan Mental DASS-21</h2>
        <p class="text-white-50 small mb-0">
          Hei, <strong class="text-white"><?= esc(session()->get('mahasiswa_nama') ?? 'Peserta') ?></strong>!
          Jawab setiap pertanyaan sesuai kondisimu <strong>1 minggu terakhir</strong>.
        </p>
      </div>
      <div class="text-end">
        <span class="text-white fw-bold" id="tesProgressCount">0/<?= $total ?></span>
        <p class="text-white-50 small mb-0">pertanyaan terjawab</p>
      </div>
    </div>

    <!-- Progress bar -->
    <div class="tes-progress-bar mt-3">
      <div class="fill" id="tesProgressFill" style="width:0%"></div>
    </div>
  </div>
</div>

<!-- PANDUAN JAWABAN -->
<div style="background:var(--green-pale);padding:.75rem 0;border-bottom:1px solid var(--gray-200)">
  <div class="container">
    <div class="d-flex flex-wrap gap-3 justify-content-center" style="font-size:.8rem">
      <span><strong>0</strong> = Tidak pernah</span>
      <span class="text-muted">|</span>
      <span><strong>1</strong> = Kadang-kadang</span>
      <span class="text-muted">|</span>
      <span><strong>2</strong> = Cukup sering</span>
      <span class="text-muted">|</span>
      <span><strong>3</strong> = Hampir selalu</span>
    </div>
  </div>
</div>

<!-- FORM PERTANYAAN -->
<div style="background:var(--gray-50);padding:2.5rem 0;min-height:60vh">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <form action="<?= base_url('tes/submit') ?>" method="POST" id="tesForm">
          <?= csrf_field() ?>

          <?php foreach ($questions as $i => $q): ?>
          <div class="question-card fade-in-up">
            <div class="d-flex align-items-start gap-2 mb-3">
              <span class="question-num"><?= $q['nomor'] ?></span>
              <span class="question-text"><?= esc($q['pertanyaan']) ?></span>
            </div>

            <!-- Badge skala kecil -->
            <?php
            $skalaClr = match($q['skala']) {
              'depresi'   => ['#dbeafe','#1d4ed8'],
              'kecemasan' => ['#fef9c3','#854d0e'],
              default     => ['#ffedd5','#9a3412'],
            };
            ?>
            <span class="badge mb-2" style="background:<?= $skalaClr[0] ?>;color:<?= $skalaClr[1] ?>;font-size:.65rem;text-transform:capitalize">
              <?= $q['skala'] ?>
            </span>

            <div class="dass-options">
              <?php foreach([0=>'Tidak Pernah',1=>'Kadang-kadang',2=>'Cukup Sering',3=>'Hampir Selalu'] as $val => $label): ?>
              <div class="dass-option">
                <input type="radio"
                  name="jawaban[<?= $q['nomor'] ?>]"
                  id="q<?= $q['nomor'] ?>_<?= $val ?>"
                  value="<?= $val ?>">
                <label for="q<?= $q['nomor'] ?>_<?= $val ?>"><?= $val ?> — <?= $label ?></label>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
          <?php endforeach; ?>

          <div class="text-center mt-4">
            <p class="text-muted small mb-3">
              <i class="bi bi-info-circle me-1"></i>
              Pastikan semua <?= $total ?> pertanyaan sudah dijawab sebelum submit.
            </p>
            <button type="submit" class="btn btn-primary-custom btn-lg px-5">
              <i class="bi bi-send-fill me-2"></i>Lihat Hasil Tes
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<style>
.fade-in-up { opacity:0; transform:translateY(20px); transition:opacity .5s ease, transform .5s ease; }
.fade-in-up.visible { opacity:1; transform:translateY(0); }
</style>
<script>
const cards = document.querySelectorAll('.question-card');
const obs = new IntersectionObserver(entries => {
  entries.forEach(e => { if(e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); }});
}, { threshold: 0.1 });
cards.forEach(c => obs.observe(c));
</script>

<!-- Simpan flag tes pending ke localStorage -->
<script>
<?php if (session()->getFlashdata('save_pending')): ?>
const _p = <?= json_encode(session()->getFlashdata('save_pending')) ?>;
if (typeof SesiManager !== 'undefined' && _p) {
  SesiManager.saveAfterFormSubmit(_p.nama, _p.email);
}
<?php endif; ?>
</script>