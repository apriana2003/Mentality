<?php
$fields       = $fields ?? [];
$defaultNames = ['nama','email','jenis_kelamin','usia']; // Field yang tidak bisa dihapus/ubah nama
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h5 class="fw-bold mb-1"><i class="bi bi-ui-checks me-2 text-green-main"></i>Kelola Field Form Kuesioner</h5>
    <p class="text-muted small mb-0">Atur field yang tampil di halaman Data Diri. Field <span class="badge" style="background:#fef9c3;color:#854d0e">Default</span> tidak bisa dihapus.</p>
  </div>
  <button class="btn btn-primary-custom btn-sm px-3" onclick="openModal()">
    <i class="bi bi-plus-lg me-1"></i>Tambah Field
  </button>
</div>

<!-- Tabel -->
<div class="admin-table">
  <div class="table-header">
    <h6><i class="bi bi-list-check me-2 text-green-main"></i>Daftar Field (<?= count($fields) ?>)</h6>
  </div>
  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th style="width:60px">Urutan</th>
          <th>Label</th>
          <th>Nama Field</th>
          <th>Tipe</th>
          <th>Placeholder</th>
          <th>Wajib</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($fields)): ?>
        <tr><td colspan="8" class="text-center text-muted py-5">
          <i class="bi bi-inbox fs-3 d-block mb-2"></i>Belum ada field
        </td></tr>
        <?php else: ?>
        <?php foreach ($fields as $f):
          $isDefault = in_array($f['name'], $defaultNames);
          $typeColor = match($f['type']) {
            'text'     => '#dbeafe:#1d4ed8',
            'email'    => '#dcfce7:#166534',
            'number'   => '#fef9c3:#854d0e',
            'select'   => '#f3e8ff:#7e22ce',
            'radio'    => '#ffedd5:#9a3412',
            'textarea' => '#f1f5f9:#475569',
            default    => '#f1f5f9:#475569',
          };
          [$bg, $clr] = explode(':', $typeColor);
        ?>
        <tr class="<?= !$f['aktif'] ? 'opacity-50' : '' ?>">
          <td class="text-center">
            <span class="fw-bold" style="color:var(--green-main)"><?= $f['urutan'] ?></span>
          </td>
          <td>
            <div class="fw-semibold"><?= esc($f['label']) ?></div>
            <?php if ($isDefault): ?>
            <span class="badge" style="background:#fef9c3;color:#854d0e;font-size:.65rem">Default</span>
            <?php endif; ?>
          </td>
          <td>
            <code style="font-size:.8rem;background:#f1f5f9;padding:.2rem .5rem;border-radius:4px;color:#1e293b">
              <?= esc($f['name']) ?>
            </code>
          </td>
          <td>
            <span class="badge" style="background:<?= $bg ?>;color:<?= $clr ?>;font-size:.75rem">
              <?= strtoupper($f['type']) ?>
            </span>
          </td>
          <td class="text-muted small"><?= esc($f['placeholder'] ?? '-') ?></td>
          <td>
            <?php if ($f['required']): ?>
            <span class="badge badge-normal">Wajib</span>
            <?php else: ?>
            <span class="badge badge-ringan">Opsional</span>
            <?php endif; ?>
          </td>
          <td>
            <div class="form-check form-switch mb-0">
              <input class="form-check-input" type="checkbox" role="switch"
                id="toggle_<?= $f['id'] ?>"
                <?= $f['aktif'] ? 'checked' : '' ?>
                onchange="toggleField(<?= $f['id'] ?>, this)"
                style="cursor:pointer">
            </div>
          </td>
          <td>
            <div class="d-flex gap-1">
              <!-- Tombol Edit -->
              <button
                onclick="editField(
                  <?= $f['id'] ?>,
                  '<?= esc(addslashes($f['label'])) ?>',
                  '<?= esc($f['name']) ?>',
                  '<?= $f['type'] ?>',
                  '<?= esc(addslashes($f['placeholder'] ?? '')) ?>',
                  <?= $f['required'] ?>,
                  <?= $f['aktif'] ?>,
                  <?= $f['urutan'] ?>,
                  <?= $f['options'] ? htmlspecialchars(json_encode($f['options']), ENT_QUOTES) : 'null' ?>,
                  <?= $isDefault ? 'true' : 'false' ?>
                )"
                class="btn btn-sm btn-outline-green rounded-pill px-2" title="Edit">
                <i class="bi bi-pencil"></i>
              </button>
              <!-- Tombol Hapus -->
              <?php if (!$isDefault): ?>
              <button onclick="hapusField(<?= $f['id'] ?>, '<?= esc(addslashes($f['label'])) ?>')"
                class="btn btn-sm rounded-pill px-2"
                style="background:#fee2e2;color:#991b1b;border:none" title="Hapus">
                <i class="bi bi-trash3"></i>
              </button>
              <?php else: ?>
              <button class="btn btn-sm rounded-pill px-2"
                style="background:#f1f5f9;color:#94a3b8;border:none;cursor:not-allowed"
                title="Field default tidak bisa dihapus" disabled>
                <i class="bi bi-lock"></i>
              </button>
              <?php endif; ?>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Preview Form -->
<div class="admin-table mt-4">
  <div class="table-header">
    <h6><i class="bi bi-eye me-2 text-green-main"></i>Preview Form Data Diri</h6>
    <a href="<?= base_url('form') ?>" target="_blank" class="btn btn-sm btn-outline-green">
      <i class="bi bi-box-arrow-up-right me-1"></i>Buka Form
    </a>
  </div>
  <div class="p-4">
    <div class="row g-3" style="max-width:600px">
      <?php foreach ($fields as $f): if (!$f['aktif']) continue; ?>
      <div class="col-<?= in_array($f['name'], ['nim','usia']) ? '6' : '12' ?>">
        <label class="form-label" style="font-size:.82rem;font-weight:700;color:#1f2937">
          <?= esc($f['label']) ?>
          <?php if ($f['required']): ?><span class="text-danger ms-1">*</span><?php endif; ?>
        </label>
        <?php if ($f['type'] === 'radio' && $f['options']): ?>
          <?php $opts = json_decode($f['options'], true) ?? []; ?>
          <div class="d-flex gap-3 flex-wrap">
            <?php foreach ($opts as $opt): ?>
            <div class="form-check">
              <input class="form-check-input" type="radio" disabled>
              <label class="form-check-label small"><?= esc($opt) ?></label>
            </div>
            <?php endforeach; ?>
          </div>
        <?php elseif ($f['type'] === 'select' && $f['options']): ?>
          <?php $opts = json_decode($f['options'], true) ?? []; ?>
          <select class="form-select form-select-sm" disabled style="max-width:300px">
            <option>-- Pilih --</option>
            <?php foreach ($opts as $opt): ?>
            <option><?= esc($opt) ?></option>
            <?php endforeach; ?>
          </select>
        <?php elseif ($f['type'] === 'textarea'): ?>
          <textarea class="form-control form-control-sm" disabled
            placeholder="<?= esc($f['placeholder'] ?? '') ?>" rows="2"></textarea>
        <?php else: ?>
          <input type="<?= $f['type'] ?>" class="form-control form-control-sm" disabled
            placeholder="<?= esc($f['placeholder'] ?? '') ?>">
        <?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<!-- ══ MODAL TAMBAH / EDIT ══ -->
<div class="modal fade" id="modalField" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4 border-0 shadow-lg">
      <div class="modal-header border-0 px-4 pt-4 pb-0">
        <h5 class="modal-title fw-bold" id="modalTitle">Tambah Field</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="<?= base_url('admin/form-fields/save') ?>" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="id" id="fieldId">
        <div class="modal-body px-4 py-3">
          <div class="row g-3">

            <div class="col-md-6">
              <label class="form-label-mentality">Label <span class="text-danger">*</span></label>
              <input type="text" name="label" id="fieldLabel"
                class="form-control form-control-mentality"
                placeholder="Contoh: Nama Lengkap" required>
              <div class="form-text">Teks yang tampil di atas input</div>
            </div>

            <div class="col-md-6">
              <label class="form-label-mentality">Nama Field <span class="text-danger">*</span></label>
              <input type="text" name="name" id="fieldName"
                class="form-control form-control-mentality"
                placeholder="Contoh: nama_lengkap" required>
              <div class="form-text" id="nameHelp">Huruf kecil & underscore saja</div>
            </div>

            <div class="col-md-6">
              <label class="form-label-mentality">Tipe Input <span class="text-danger">*</span></label>
              <select name="type" id="fieldType"
                class="form-select form-control-mentality"
                onchange="handleTypeChange(this.value)">
                <option value="text">Text</option>
                <option value="email">Email</option>
                <option value="number">Number</option>
                <option value="select">Select (Dropdown)</option>
                <option value="radio">Radio Button</option>
                <option value="textarea">Textarea</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label-mentality">Urutan Tampil</label>
              <input type="number" name="urutan" id="fieldUrutan"
                class="form-control form-control-mentality"
                placeholder="Contoh: 7" min="1" value="1">
            </div>

            <div class="col-12">
              <label class="form-label-mentality">Placeholder</label>
              <input type="text" name="placeholder" id="fieldPlaceholder"
                class="form-control form-control-mentality"
                placeholder="Teks bantuan di dalam input">
            </div>

            <!-- Opsi untuk select/radio -->
            <div class="col-12" id="optionsWrap" style="display:none">
              <label class="form-label-mentality">Opsi <span class="text-danger">*</span></label>
              <textarea name="options" id="fieldOptions"
                class="form-control form-control-mentality" rows="4"
                placeholder="Tulis satu opsi per baris:&#10;Laki-laki&#10;Perempuan"></textarea>
              <div class="form-text">Tulis satu opsi per baris</div>
            </div>

            <div class="col-md-6">
              <div class="form-check form-switch mt-1">
                <input class="form-check-input" type="checkbox" name="required"
                  id="fieldRequired" value="1" checked>
                <label class="form-check-label fw-semibold" for="fieldRequired"
                  style="font-size:.88rem">Wajib diisi</label>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-check form-switch mt-1">
                <input class="form-check-input" type="checkbox" name="aktif"
                  id="fieldAktif" value="1" checked>
                <label class="form-check-label fw-semibold" for="fieldAktif"
                  style="font-size:.88rem">Tampilkan di form</label>
              </div>
            </div>

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

<!-- Modal Hapus -->
<div class="modal fade" id="modalHapus" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content rounded-4 border-0 shadow-lg">
      <div class="modal-body text-center p-4">
        <div style="width:56px;height:56px;background:#fee2e2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem">
          <i class="bi bi-trash3-fill text-danger fs-4"></i>
        </div>
        <h6 class="fw-bold mb-1">Hapus Field?</h6>
        <p class="text-muted small mb-4">Field <strong id="namaHapus"></strong> akan dihapus permanen.</p>
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
// ── Buka modal tambah baru ────────────────────────────────────
function openModal() {
  document.getElementById('modalTitle').textContent   = 'Tambah Field Baru';
  document.getElementById('fieldId').value            = '';
  document.getElementById('fieldLabel').value         = '';
  document.getElementById('fieldName').value          = '';
  document.getElementById('fieldName').disabled       = false;
  document.getElementById('fieldType').value          = 'text';
  document.getElementById('fieldType').disabled       = false;
  document.getElementById('fieldPlaceholder').value   = '';
  document.getElementById('fieldOptions').value       = '';
  document.getElementById('fieldUrutan').value        = '<?= count($fields) + 1 ?>';
  document.getElementById('fieldRequired').checked    = true;
  document.getElementById('fieldAktif').checked       = true;
  document.getElementById('optionsWrap').style.display = 'none';
  document.getElementById('nameHelp').textContent     = 'Huruf kecil & underscore saja';

  new bootstrap.Modal(document.getElementById('modalField')).show();
}

// ── Edit field ────────────────────────────────────────────────
function editField(id, label, name, type, placeholder, required, aktif, urutan, optionsJson, isDefault) {
  document.getElementById('modalTitle').textContent   = 'Edit Field: ' + label;
  document.getElementById('fieldId').value            = id;
  document.getElementById('fieldLabel').value         = label;
  document.getElementById('fieldName').value          = name;
  document.getElementById('fieldName').disabled       = isDefault;
  document.getElementById('fieldType').value          = type;
  document.getElementById('fieldType').disabled       = isDefault;
  document.getElementById('fieldPlaceholder').value   = placeholder;
  document.getElementById('fieldUrutan').value        = urutan;
  document.getElementById('fieldRequired').checked    = required == 1;
  document.getElementById('fieldAktif').checked       = aktif == 1;

  // Isi opsi jika ada
  if (optionsJson) {
    try {
      const opts = JSON.parse(optionsJson);
      document.getElementById('fieldOptions').value = Array.isArray(opts) ? opts.join('\n') : '';
    } catch(e) {
      document.getElementById('fieldOptions').value = '';
    }
  } else {
    document.getElementById('fieldOptions').value = '';
  }

  handleTypeChange(type);

  if (isDefault) {
    document.getElementById('nameHelp').textContent = '🔒 Nama field default tidak bisa diubah';
  } else {
    document.getElementById('nameHelp').textContent = 'Huruf kecil & underscore saja';
  }

  new bootstrap.Modal(document.getElementById('modalField')).show();
}

// ── Show/hide opsi untuk select & radio ───────────────────────
function handleTypeChange(type) {
  const wrap = document.getElementById('optionsWrap');
  wrap.style.display = ['select','radio'].includes(type) ? 'block' : 'none';
}

// ── Auto-generate nama field dari label ──────────────────────
document.getElementById('fieldLabel').addEventListener('input', function() {
  const nameField = document.getElementById('fieldName');
  if (!nameField.disabled) {
    nameField.value = this.value
      .toLowerCase()
      .replace(/[^a-z0-9\s]/g, '')
      .trim()
      .replace(/\s+/g, '_');
  }
});

// ── Toggle aktif via AJAX ─────────────────────────────────────
async function toggleField(id, el) {
  try {
    const res  = await fetch('<?= base_url('admin/form-fields/toggle/') ?>' + id, {
      method  : 'POST',
      headers : {
        'X-Requested-With' : 'XMLHttpRequest',
        'Content-Type'     : 'application/json',
      },
    });
    const data = await res.json();
    if (!data.success) el.checked = !el.checked;
  } catch(e) {
    el.checked = !el.checked;
    alert('Terjadi kesalahan koneksi.');
  }
}

// ── Hapus field ───────────────────────────────────────────────
function hapusField(id, label) {
  document.getElementById('namaHapus').textContent = label;
  document.getElementById('linkHapus').href = '<?= base_url('admin/form-fields/delete/') ?>' + id;
  new bootstrap.Modal(document.getElementById('modalHapus')).show();
}
</script>