<?php $blogs=$blogs??[]; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <h6 class="fw-bold mb-0"><i class="bi bi-journal-richtext me-2 text-green-main"></i>Kelola Blog (<?= count($blogs) ?>)</h6>
  <button class="btn btn-primary-custom btn-sm px-3" onclick="openModal()">
    <i class="bi bi-plus-lg me-1"></i>Tambah Artikel
  </button>
</div>

<div class="row g-3">
  <?php if(empty($blogs)): ?>
  <div class="col-12 text-center py-5 text-muted">
    <i class="bi bi-journal-x fs-3 d-block mb-2"></i>Belum ada artikel
  </div>
  <?php else: ?>
  <?php foreach($blogs as $b): ?>
  <div class="col-lg-4 col-md-6">
    <div class="admin-table p-3 h-100">
      <div class="d-flex align-items-start justify-content-between mb-2">
        <span class="badge" style="background:var(--green-pale);color:var(--green-main);font-size:.72rem"><?= esc($b['kategori']) ?></span>
        <span class="badge <?= $b['published']?'badge-normal':'badge-sedang' ?>">
          <?= $b['published']?'Terbit':'Draft' ?>
        </span>
      </div>
      <h6 class="fw-bold mb-1" style="font-size:.9rem;line-height:1.4"><?= esc($b['judul']) ?></h6>
      <p class="text-muted small mb-3"><?= esc(substr($b['ringkasan']??'',0,80)) ?>...</p>
      <div class="d-flex gap-2 mt-auto">
        <button onclick="editBlog(<?= htmlspecialchars(json_encode($b), ENT_QUOTES) ?>)"
          class="btn btn-sm btn-outline-green rounded-pill flex-fill">
          <i class="bi bi-pencil me-1"></i>Edit
        </button>
        <a href="<?= base_url('admin/blogs/delete/'.$b['id']) ?>"
          onclick="return confirm('Yakin hapus artikel ini?')"
          class="btn btn-sm rounded-pill" style="background:#fee2e2;color:#991b1b;border:none">
          <i class="bi bi-trash3"></i>
        </a>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
  <?php endif; ?>
</div>

<!-- Modal Form Blog -->
<div class="modal fade" id="modalBlog" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow-lg">
      <div class="modal-header border-0 pb-0 px-4 pt-4">
        <h5 class="modal-title fw-bold" id="modalTitle">Tambah Artikel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="<?= base_url('admin/blogs/save') ?>" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="id" id="blogId">
        <div class="modal-body px-4">
          <div class="mb-3">
            <label class="form-label-mentality">Judul Artikel</label>
            <input type="text" name="judul" id="blogJudul" class="form-control form-control-mentality" required>
          </div>
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label-mentality">Kategori</label>
              <select name="kategori" id="blogKategori" class="form-select form-control-mentality">
                <?php foreach(['Stres','Kecemasan','Depresi','Trauma','Tips','Umum'] as $k): ?>
                <option value="<?=$k?>"><?=$k?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label-mentality">Status</label>
              <select name="published" id="blogPublished" class="form-select form-control-mentality">
                <option value="1">Terbit</option>
                <option value="0">Draft</option>
              </select>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label-mentality">Ringkasan</label>
            <textarea name="ringkasan" id="blogRingkasan" class="form-control form-control-mentality" rows="2"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label-mentality">Konten (HTML diperbolehkan)</label>
            <textarea name="konten" id="blogKonten" class="form-control form-control-mentality" rows="6" required></textarea>
          </div>
        </div>
        <div class="modal-footer border-0 px-4 pb-4">
          <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary-custom rounded-3 px-4">
            <i class="bi bi-save me-1"></i>Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function openModal(reset = true) {
  if (reset) {
    document.getElementById('modalTitle').textContent = 'Tambah Artikel';
    document.getElementById('blogId').value = '';
    document.getElementById('blogJudul').value = '';
    document.getElementById('blogRingkasan').value = '';
    document.getElementById('blogKonten').value = '';
    document.getElementById('blogKategori').value = 'Umum';
    document.getElementById('blogPublished').value = '1';
  }
  new bootstrap.Modal(document.getElementById('modalBlog')).show();
}

function editBlog(b) {
  document.getElementById('modalTitle').textContent = 'Edit Artikel';
  document.getElementById('blogId').value      = b.id;
  document.getElementById('blogJudul').value   = b.judul;
  document.getElementById('blogRingkasan').value = b.ringkasan || '';
  document.getElementById('blogKonten').value  = b.konten;
  document.getElementById('blogKategori').value = b.kategori;
  document.getElementById('blogPublished').value = b.published;
  openModal(false);
}
</script>
