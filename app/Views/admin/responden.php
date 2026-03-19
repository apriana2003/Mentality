<?php $responden=$responden??[]; $total=$total??0; $page=$page??1; $perPage=$perPage??15; $search=$search??''; ?>

<div class="admin-table">
  <div class="table-header">
    <h6><i class="bi bi-people-fill me-2 text-green-main"></i>Data Responden
      <span class="badge bg-green-main ms-2"><?= number_format($total) ?></span>
    </h6>
    <!-- Search -->
    <form method="GET" class="d-flex gap-2">
      <input type="text" name="search" class="form-control form-control-sm rounded-pill" style="width:220px"
        placeholder="Cari nama / email / kampus..." value="<?= esc($search) ?>">
      <button class="btn btn-sm btn-primary-custom rounded-pill px-3">
        <i class="bi bi-search"></i>
      </button>
      <?php if($search): ?>
      <a href="<?= base_url('admin/mahasiswa') ?>" class="btn btn-sm btn-outline-secondary rounded-pill">Reset</a>
      <?php endif; ?>
    </form>
  </div>

  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Nama</th>
          <th>Email</th>
          <th>NIM</th>
          <th>Universitas</th>
          <th>Jenis Kelamin</th>
          <th>Usia</th>
          <th>Jumlah Tes</th>
          <th>Terdaftar</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if(empty($responden)): ?>
        <tr><td colspan="10" class="text-center text-muted py-5">
          <i class="bi bi-inbox fs-3 d-block mb-2"></i>
          <?= $search ? 'Tidak ada hasil untuk pencarian "'.esc($search).'"' : 'Belum ada data responden' ?>
        </td></tr>
        <?php else: ?>
        <?php foreach($responden as $i => $r): ?>
        <tr>
          <td class="text-muted"><?= ($page-1)*$perPage + $i + 1 ?></td>
          <td>
            <div class="d-flex align-items-center gap-2">
              <div style="width:32px;height:32px;background:var(--green-pale);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:700;color:var(--green-main);flex-shrink:0">
                <?= strtoupper(substr($r['nama'],0,1)) ?>
              </div>
              <span class="fw-semibold"><?= esc($r['nama']) ?></span>
            </div>
          </td>
          <td class="text-muted"><?= esc($r['email']) ?></td>
          <td class="text-muted"><?= esc($r['nim'] ?? '-') ?></td>
          <td><?= esc($r['universitas'] ?? '-') ?></td>
          <td>
            <span class="badge <?= $r['jenis_kelamin']==='L'?'badge-normal':'badge-ringan' ?>">
              <?= $r['jenis_kelamin']==='L' ? 'Laki-laki' : 'Perempuan' ?>
            </span>
          </td>
          <td><?= $r['usia'] ?> thn</td>
          <td>
            <span class="badge" style="background:#eff6ff;color:#1d4ed8;font-weight:700">
              <?= $r['jumlah_tes'] ?> tes
            </span>
          </td>
          <td class="text-muted" style="font-size:.78rem"><?= date('d M Y', strtotime($r['created_at'])) ?></td>
          <td>
            <div class="d-flex gap-1">
              <a href="<?= base_url('admin/mahasiswa/'.$r['id']) ?>" class="btn btn-sm btn-outline-green rounded-pill px-2" title="Detail">
                <i class="bi bi-eye"></i>
              </a>
              <button onclick="hapusResponden(<?= $r['id'] ?>, '<?= esc($r['nama']) ?>')"
                class="btn btn-sm rounded-pill px-2" style="background:#fee2e2;color:#991b1b;border:none" title="Hapus">
                <i class="bi bi-trash3"></i>
              </button>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <?php if($total > $perPage): $pages = ceil($total/$perPage); ?>
  <div class="d-flex justify-content-between align-items-center p-3 border-top">
    <span class="text-muted small">Menampilkan <?= min($perPage, $total-($page-1)*$perPage) ?> dari <?= number_format($total) ?> data</span>
    <div class="d-flex gap-1">
      <?php for($i=1;$i<=$pages;$i++): ?>
      <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"
        class="btn btn-sm <?= $i==$page?'btn-primary-custom':'btn-outline-secondary' ?> rounded-circle"
        style="width:32px;height:32px;padding:0;display:flex;align-items:center;justify-content:center;font-size:.78rem">
        <?= $i ?>
      </a>
      <?php endfor; ?>
    </div>
  </div>
  <?php endif; ?>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="modalHapus" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content rounded-4 border-0 shadow-lg">
      <div class="modal-body text-center p-4">
        <div style="width:56px;height:56px;background:#fee2e2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem">
          <i class="bi bi-trash3-fill text-danger fs-4"></i>
        </div>
        <h6 class="fw-bold mb-1">Hapus Responden?</h6>
        <p class="text-muted small mb-1">Kamu akan menghapus data:</p>
        <p class="fw-bold mb-3" id="namaHapus">-</p>
        <p class="text-muted small mb-4">Semua riwayat tes juga akan ikut terhapus!</p>
        <div class="d-flex gap-2">
          <button class="btn btn-light flex-fill rounded-3" data-bs-dismiss="modal">Batal</button>
          <a id="linkHapus" href="#" class="btn btn-danger flex-fill rounded-3">
            <i class="bi bi-trash3 me-1"></i>Hapus
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function hapusResponden(id, nama) {
  document.getElementById('namaHapus').textContent = nama;
  document.getElementById('linkHapus').href = '<?= base_url('admin/mahasiswa/delete/') ?>' + id;
  new bootstrap.Modal(document.getElementById('modalHapus')).show();
}
</script>
