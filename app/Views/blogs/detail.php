<?php $blog = $blog ?? []; ?>

<section class="section-pad" style="background:var(--gray-50)">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">

        <a href="<?= base_url('blogs') ?>" class="d-inline-flex align-items-center gap-2 text-green-main fw-semibold mb-4 small">
          <i class="bi bi-arrow-left"></i> Kembali ke Blog
        </a>

        <article class="card-mentality p-0 overflow-hidden">

          <!-- Gambar header artikel -->
          <?php if ($blog['gambar']): ?>
          <div style="height:280px;overflow:hidden">
            <img src="<?= esc($blog['gambar']) ?>"
              alt="<?= esc($blog['judul']) ?>"
              style="width:100%;height:100%;object-fit:cover">
          </div>
          <?php else: ?>
          <?php $icons=['Stres'=>'bi-wind','Kecemasan'=>'bi-lightning','Depresi'=>'bi-cloud-rain','Tips'=>'bi-lightbulb','Trauma'=>'bi-bandaid']; ?>
          <div class="blog-img rounded-0" style="height:220px">
            <i class="bi <?= $icons[$blog['kategori']] ?? 'bi-journal-text' ?>"></i>
          </div>
          <?php endif; ?>

          <div class="p-4">
            <span class="blog-category mb-2"><?= esc($blog['kategori']) ?></span>
            <h1 class="fw-bold mb-2" style="font-size:1.6rem;line-height:1.3"><?= esc($blog['judul']) ?></h1>
            <p class="text-muted small mb-4">
              <i class="bi bi-calendar3 me-1"></i><?= date('d F Y', strtotime($blog['created_at'])) ?>
            </p>

            <div class="blog-content" style="line-height:1.9;color:var(--gray-800)">
              <?= $blog['konten'] ?>
            </div>

            <hr class="my-4">
            <div class="d-flex gap-3 flex-wrap">
              <a href="<?= base_url('form') ?>" class="btn btn-primary-custom">
                <i class="bi bi-clipboard2-pulse me-2"></i>Coba Tes Mental
              </a>
              <a href="<?= base_url('services/konseling') ?>" class="btn btn-outline-green">
                <i class="bi bi-robot me-2"></i>Konsultasi AI
              </a>
            </div>
          </div>

        </article>

      </div>
    </div>
  </div>
</section>