<?php $blogs=$blogs??[]; $page=$page??1; $total=$total??0; $limit=$limit??6; ?>

<section class="section-pad-sm" style="background:linear-gradient(135deg,var(--green-dark),var(--green-main))">
  <div class="container text-center py-4">
    <div class="section-badge" style="background:rgba(255,255,255,.15);color:white"><i class="bi bi-newspaper"></i> Blog</div>
    <h1 class="text-white fw-bold mt-2" style="font-size:2.2rem">Blog Kesehatan Mental</h1>
    <p class="text-white-50 mx-auto" style="max-width:560px">Artikel, tips, dan informasi terkini seputar kesehatan mental untuk mendukung kesejahteraan mahasiswa.</p>
  </div>
</section>

<section class="section-pad" style="background:var(--gray-50)">
  <div class="container">
    <?php if (empty($blogs)): ?>
    <div class="text-center py-5 text-muted">
      <i class="bi bi-journal-x fs-3 d-block mb-2"></i>Belum ada artikel.
    </div>
    <?php else: ?>
    <div class="row g-4">
      <?php
      $icons = ['Stres'=>'bi-wind','Kecemasan'=>'bi-lightning','Depresi'=>'bi-cloud-rain','Tips'=>'bi-lightbulb','Trauma'=>'bi-bandaid'];
      foreach($blogs as $blog): ?>
      <div class="col-lg-4 col-md-6">
        <a href="<?= base_url('blogs/' . esc($blog['slug'])) ?>" class="text-decoration-none">
          <div class="blog-card">
            <!-- Gambar atau ikon default -->
              <?php if ($blog['gambar']): ?>
              <div style="height:180px;overflow:hidden">
                <img src="<?= esc($blog['gambar']) ?>"                alt="<?= esc($blog['judul']) ?>"
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
              <p class="blog-excerpt"><?= esc(substr($blog['ringkasan'] ?? '', 0, 100)) ?>...</p>
              <div class="d-flex justify-content-between align-items-center mt-3">
                <span class="small text-muted"><i class="bi bi-calendar3 me-1"></i><?= date('d M Y', strtotime($blog['created_at'])) ?></span>
                <span class="small text-green-main fw-bold">Baca <i class="bi bi-arrow-right"></i></span>
              </div>
            </div>
          </div>
        </a>
      </div>
      <?php endforeach; ?>
    </div>

    <?php if ($total > $limit): $pages = ceil($total / $limit); ?>
    <div class="d-flex justify-content-center mt-5 gap-2">
      <?php for($i=1;$i<=$pages;$i++): ?>
      <a href="?page=<?=$i?>" class="btn btn-sm <?=$i==$page?'btn-primary-custom':'btn-outline-green'?> rounded-circle"
        style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;padding:0"><?=$i?></a>
      <?php endfor; ?>
    </div>
    <?php endif; ?>
    <?php endif; ?>
  </div>
</section>