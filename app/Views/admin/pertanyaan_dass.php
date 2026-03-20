<?php
$pertanyaan = $pertanyaan ?? [];
$statistik  = $statistik  ?? [];

// Map statistik ke array mudah
$statMap = [];
foreach ($statistik as $s) {
    $statMap[$s['skala']] = ['total' => $s['total'], 'aktif' => $s['aktif_count']];
}
$skalaColor = ['depresi'=>['#dbeafe','#1d4ed8','bi-cloud-rain'], 'kecemasan'=>['#fef9c3','#854d0e','bi-lightning-charge'], 'stres'=>['#ffedd5','#9a3412','bi-wind']];
?>

<!-- Statistik per skala -->
<div class="row g-3 mb-4">
  <?php foreach (['depresi','kecemasan','stres'] as $skala):
    $s   = $statMap[$skala] ?? ['total'=>0,'aktif'=>0];
    $clr = $skalaColor[$skala];
  ?>
  <div class="col-md-4">
    <div class="stat-card-admin d-flex align-items-center gap-3">
      <div class="stat-icon" style="background:<?= $clr[0] ?>;color:<?= $clr[1] ?>">
        <i class="bi <?= $clr[2] ?>"></i>
      </div>
      <div>
        <div class="stat-num" style="font-size:1.4rem;color:<?= $clr[1] ?>"><?= $s['aktif'] ?>/<?= $s['total'] ?></div>
        <div class="stat-label">Aktif — <?= ucfirst($skala) ?></div>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<!-- Tabel pertanyaan -->
<div class="admin-table">
  <div class="table-header">
    <h6><i class="bi bi-patch-question-fill me-2 text-green-main"></i>
      Pertanyaan DASS-21
      <span class="badge bg-green-main ms-2"><?= count($pertanyaan) ?></span>
    </h6>
    <button class="btn btn-primary-custom btn-sm px-3" onclick="openModal()">
      <i class="bi bi-plus-lg me-1"></i>Tambah Pertanyaan
    </button>
  </div>

  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th style="width:60px">No.</th>
          <th>Pertanyaan</th>
          <th style="width:120px">Skala</th>
          <th style="width:100px">Status</th>
          <th style="width:100px">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($pertanyaan)): ?>
        <tr><td colspan="5" class="text-center text-muted py-5">
          <i class="bi bi-inbox fs-3 d-block mb-2"></i>Belum ada pertanyaan
        </td></tr>
        <?php else: ?>
        <?php foreach ($pertanyaan as $p):
          $skalaClr = match($p['skala']) {
            'depresi'   => ['#dbeafe','#1d4ed8'],
            'kecemasan' => ['#fef9c3','#854d0e'],
            default     => ['#ffedd5','#9a3412'],
          };
        ?>
        <tr class="<?= !$p['aktif'] ? 'opacity-50' : '' ?>">
          <td>
            <div class="fw-bold text-center" style="width:32px;height:32px;background:<?= $p['aktif'] ? 'var(--green-pale)' : '#f1f5f9' ?>;color:<?= $p['aktif'] ? 'var(--green-main)' : '#94a3b8' ?>;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.85rem">
              <?= $p['nomor'] ?>
            </div>
          </td>
          <td>
            <span style="font-size:.88rem;line-height:1.5"><?= esc($p['pertanyaan']) ?></span>
          </td>
          <td>
            <span class="badge" style="background:<?= $skalaClr[0] ?>;color:<?= $skalaClr[1] ?>;font-size:.75rem;text-transform:capitalize">
              <?= $p['skala'] ?>
            </span>
          </td>
          <td>
            <div class="form-check form-switch mb-0">
              <input class="form-check-input" type="checkbox" role="switch"
                id="toggle_<?= $p['id'] ?>"
                <?= $p['aktif'] ? 'checked' : '' ?>
                onchange="togglePertanyaan(<?= $p['id'] ?>, this)"
                style="cursor:pointer">
            </div>
          </td>
          <td>
            <div class="d-flex gap-1">
              <button onclick='editPertanyaan(<?= json_encode($p) ?>)'
                class="btn btn-sm btn-outline-green rounded-pill px-2" title="Edit">
                <i class="bi bi-pencil"></i>
              </button>
              <button onclick="hapusPertanyaan(<?= $p['id'] ?>, <?= $p['nomor'] ?>)"
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

  <div class="p-3 border-top d-flex gap-3 flex-wrap" style="background:#f8fafc;font-size:.78rem;color:#64748b">
    <span><i class="bi bi-info-circle me-1"></i>Total aktif: <strong><?= array_sum(array_column($pertanyaan, 'aktif')) ?></strong> pertanyaan</span>
    <span>·</span>
    <span>Minimal <strong>7</strong> pertanyaan aktif per skala agar tes valid</span>
    <span>·</span>
    <span>Perubahan langsung berpengaruh ke halaman tes mahasiswa</span>
  </div>
</div>

<!-- Modal Form Tambah/Edit -->
<div class="modal fade" id="modalPertanyaan" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4 border-0 shadow-lg">
      <div class="modal-header border-0 px-4 pt-4 pb-0">
        <h5 class="modal-title fw-bold" id="modalTitle">Tambah Pertanyaan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="<?= base_url('admin/pertanyaan-dass/save') ?>" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="id" id="pId">
        <div class="modal-body px-4 py-3">
          <div class="row g-3">

            <div class="col-md-4">
              <label class="form-label-mentality">Nomor Soal <span class="text-danger">*</span></label>
              <input type="number" name="nomor" id="pNomor"
                class="form-control form-control-mentality"
                placeholder="1 – 99" min="1" max="99" required>
              <div class="form-text">Nomor urut unik</div>
            </div>

            <div class="col-md-8">
              <label class="form-label-mentality">Skala <span class="text-danger">*</span></label>
              <select name="skala" id="pSkala" class="form-select form-control-mentality" required>
                <option value="">-- Pilih Skala --</option>
                <option value="depresi">🔵 Depresi</option>
                <option value="kecemasan">🟡 Kecemasan</option>
                <option value="stres">🟠 Stres</option>
              </select>
            </div>

            <div class="col-12">
              <label class="form-label-mentality">Teks Pertanyaan <span class="text-danger">*</span></label>
              <textarea name="pertanyaan" id="pTeks"
                class="form-control form-control-mentality" rows="3"
                placeholder="Contoh: Saya merasa sulit untuk tenang"
                required></textarea>
              <div class="form-text">Awali dengan "Saya..." sesuai format DASS-21</div>
            </div>

            <div class="col-12">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="aktif" id="pAktif" value="1" checked>
                <label class="form-check-label fw-semibold" for="pAktif" style="font-size:.88rem">
                  Aktifkan pertanyaan ini di tes
                </label>
              </div>
            </div>

          </div>

          <!-- Preview skala -->
          <div id="skalaInfo" class="mt-3 p-3 rounded-3" style="background:#f8fafc;display:none">
            <p class="small mb-1 fw-bold" id="skalaTitle"></p>
            <p class="small text-muted mb-0" id="skalaDesc"></p>
          </div>

        </div>
        <div class="modal-footer border-0 px-4 pb-4">
          <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary-custom rounded-3 px-4">
            <i class="bi bi-save me-1"></i>Simpan Pertanyaan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="modalHapus" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content rounded-4 border-0 shadow-lg">
      <div class="modal-body text-center p-4">
        <div style="width:56px;height:56px;background:#fee2e2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem">
          <i class="bi bi-trash3-fill text-danger fs-4"></i>
        </div>
        <h6 class="fw-bold mb-1">Hapus Pertanyaan?</h6>
        <p class="text-muted small mb-4">Soal nomor <strong id="nomorHapus"></strong> akan dihapus permanen.</p>
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
const skalaInfo = {
  depresi:   { title: '🔵 Skala Depresi', desc: 'Mengukur kondisi emosi seperti rasa sedih, kehilangan harapan, dan tidak berharga. Soal DASS-21 untuk skala ini: 3,5,10,13,16,17,21' },
  kecemasan: { title: '🟡 Skala Kecemasan', desc: 'Mengukur respons fisik & kognitif terhadap ancaman. Soal DASS-21: 2,4,7,9,15,19,20' },
  stres:     { title: '🟠 Skala Stres', desc: 'Mengukur kesulitan rileks dan mudah terganggu. Soal DASS-21: 1,6,8,11,12,14,18' },
};

function openModal(reset = true) {
  if (reset) {
    document.getElementById('modalTitle').textContent = 'Tambah Pertanyaan Baru';
    document.getElementById('pId').value     = '';
    document.getElementById('pNomor').value  = '';
    document.getElementById('pSkala').value  = '';
    document.getElementById('pTeks').value   = '';
    document.getElementById('pAktif').checked = true;
    document.getElementById('skalaInfo').style.display = 'none';
  }
  new bootstrap.Modal(document.getElementById('modalPertanyaan')).show();
}

function editPertanyaan(p) {
  document.getElementById('modalTitle').textContent = 'Edit Pertanyaan No.' + p.nomor;
  document.getElementById('pId').value     = p.id;
  document.getElementById('pNomor').value  = p.nomor;
  document.getElementById('pSkala').value  = p.skala;
  document.getElementById('pTeks').value   = p.pertanyaan;
  document.getElementById('pAktif').checked = p.aktif == 1;
  updateSkalaInfo(p.skala);
  openModal(false);
}

function hapusPertanyaan(id, nomor) {
  document.getElementById('nomorHapus').textContent = nomor;
  document.getElementById('linkHapus').href = '<?= base_url('admin/pertanyaan-dass/delete/') ?>' + id;
  new bootstrap.Modal(document.getElementById('modalHapus')).show();
}

function updateSkalaInfo(val) {
  const info = document.getElementById('skalaInfo');
  if (val && skalaInfo[val]) {
    document.getElementById('skalaTitle').textContent = skalaInfo[val].title;
    document.getElementById('skalaDesc').textContent  = skalaInfo[val].desc;
    info.style.display = 'block';
  } else {
    info.style.display = 'none';
  }
}

document.getElementById('pSkala').addEventListener('change', function() {
  updateSkalaInfo(this.value);
});

async function togglePertanyaan(id, el) {
  try {
    const res  = await fetch('<?= base_url('admin/pertanyaan-dass/toggle/') ?>' + id, {
      method: 'POST',
      headers: { 'X-Requested-With': 'XMLHttpRequest', 'Content-Type': 'application/json' },
    });
    const data = await res.json();
    if (!data.success) {
      el.checked = !el.checked;
      alert(data.message || 'Gagal mengubah status.');
    }
  } catch(e) {
    el.checked = !el.checked;
    alert('Terjadi kesalahan koneksi.');
  }
}
</script>