<?php $blogs = $blogs ?? []; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <h5 class="fw-bold mb-0"><i class="bi bi-journal-richtext me-2 text-green-main"></i>Kelola Blog (<?= count($blogs) ?>)</h5>
  <a href="<?= base_url('admin/blogs/create') ?>" class="btn btn-primary-custom btn-sm px-3">
    <i class="bi bi-plus-lg me-1"></i>Tambah Artikel
  </a>
</div>

<div class="row g-3">
  <?php if (empty($blogs)): ?>
  <div class="col-12 text-center py-5 text-muted">
    <i class="bi bi-journal-x fs-3 d-block mb-2"></i>Belum ada artikel
  </div>
  <?php else: ?>
  <?php foreach ($blogs as $b): ?>
  <div class="col-lg-4 col-md-6">
    <div class="admin-table p-0 h-100 overflow-hidden">

      <!-- Gambar -->
      <div style="height:160px;overflow:hidden;position:relative;background:var(--green-pale)">
        <?php if ($b['gambar']): ?>
        <img src="<?= esc($b['gambar']) ?>"
            alt="<?= esc($b['judul']) ?>"
            style="width:100%;height:100%;object-fit:cover">
        <?php else: ?>
          <?php $icons=['Stres'=>'bi-wind','Kecemasan'=>'bi-lightning','Depresi'=>'bi-cloud-rain','Tips'=>'bi-lightbulb','Trauma'=>'bi-bandaid']; ?>
          <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:2.5rem;color:var(--green-main)">
            <i class="bi <?= $icons[$b['kategori']] ?? 'bi-journal-text' ?>"></i>
          </div>
        <?php endif; ?>
        <!-- Badge status -->
        <span class="badge position-absolute" style="top:10px;right:10px;background:<?= $b['published']?'#166534':'#854d0e' ?>;color:white">
          <?= $b['published'] ? 'Terbit' : 'Draft' ?>
        </span>
      </div>

      <div class="p-3">
        <span class="badge mb-2" style="background:var(--green-pale);color:var(--green-main);font-size:.72rem"><?= esc($b['kategori']) ?></span>
        <h6 class="fw-bold mb-1" style="font-size:.9rem;line-height:1.4"><?= esc($b['judul']) ?></h6>
        <p class="text-muted small mb-3"><?= esc(substr($b['ringkasan'] ?? '', 0, 80)) ?>...</p>
        <div class="d-flex gap-2">
          <a href="<?= base_url('admin/blogs/edit/' . $b['id']) ?>"
            class="btn btn-sm btn-outline-green rounded-pill flex-fill">
            <i class="bi bi-pencil me-1"></i>Edit
          </a>
          <a href="<?= base_url('blogs/' . $b['slug']) ?>" target="_blank"
            class="btn btn-sm rounded-pill" style="background:#eff6ff;color:#1d4ed8;border:none" title="Preview">
            <i class="bi bi-eye"></i>
          </a>
          <a href="<?= base_url('admin/blogs/delete/' . $b['id']) ?>"
            onclick="return confirm('Yakin hapus artikel ini?')"
            class="btn btn-sm rounded-pill" style="background:#fee2e2;color:#991b1b;border:none" title="Hapus">
            <i class="bi bi-trash3"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
  <?php endif; ?>
</div>