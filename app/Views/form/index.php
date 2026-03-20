<?php
$fields = $fields ?? [];
// Cek apakah ada sesi sebelumnya (dari localStorage yang dikirim via JS)
?>

<section class="form-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-7 col-md-9">

        <!-- Breadcrumb -->
        <nav class="mb-4">
          <div class="d-flex align-items-center gap-2" style="font-size:.85rem">
            <span class="badge rounded-pill bg-green-main text-white px-3 py-2">1. Data Diri</span>
            <i class="bi bi-arrow-right text-muted"></i>
            <span class="badge rounded-pill text-muted px-3 py-2" style="background:var(--gray-200)">2. Tes DASS-21</span>
            <i class="bi bi-arrow-right text-muted"></i>
            <span class="badge rounded-pill text-muted px-3 py-2" style="background:var(--gray-200)">3. Hasil</span>
          </div>
        </nav>

        <div class="form-card">
          <!-- Header -->
          <div class="form-card-header">
            <div class="d-flex align-items-center gap-3">
              <div class="brand-icon brand-icon-sm"><i class="bi bi-person-fill"></i></div>
              <div>
                <h4 class="mb-0 fw-bold">Data Diri Peserta</h4>
                <p class="mb-0 text-white-50 small">Informasi ini digunakan untuk mempersonalisasi hasil tes kamu.</p>
              </div>
            </div>
          </div>

          <!-- Body -->
          <div class="form-card-body">

            <?php if (empty($fields)): ?>
            <!-- Pesan jika field kosong -->
            <div class="alert alert-warning rounded-3">
              <i class="bi bi-exclamation-triangle me-2"></i>
              Form belum dikonfigurasi. Silakan hubungi administrator.
            </div>

            <?php else: ?>

            <!-- Validation errors -->
            <?php if ($errs = session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger rounded-3 mb-4">
              <strong><i class="bi bi-exclamation-triangle me-2"></i>Harap perbaiki:</strong>
              <ul class="mb-0 mt-1">
                <?php foreach((array)$errs as $err): ?>
                <li><?= esc($err) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
            <?php endif; ?>

            <form action="<?= base_url('form/submit') ?>" method="POST" id="formDiri">
              <?= csrf_field() ?>

              <div class="row g-3">
                <?php foreach ($fields as $field):
                  $name        = esc($field['name']);
                  $label       = esc($field['label']);
                  $type        = $field['type'];
                  $placeholder = esc($field['placeholder'] ?? '');
                  $required    = (bool)$field['required'];
                  $oldVal      = esc(old($field['name']) ?? '');
                  $options     = $field['options'] ? json_decode($field['options'], true) : [];

                  // Kolom setengah untuk nim & usia
                  $colClass = in_array($field['name'], ['nim','usia']) ? 'col-md-6' : 'col-12';
                ?>
                <div class="<?= $colClass ?>">
                  <label class="form-label-mentality" for="field_<?= $name ?>">
                    <?= $label ?>
                    <?php if ($required): ?><span class="text-danger ms-1">*</span><?php endif; ?>
                    <?php if (!$required): ?><span class="text-muted ms-1" style="font-size:.75rem">(Opsional)</span><?php endif; ?>
                  </label>

                  <?php if ($type === 'radio' && !empty($options)): ?>
                  <!-- Radio buttons -->
                  <div class="d-flex gap-3 mt-1 flex-wrap">
                    <?php foreach ($options as $opt): ?>
                    <div class="flex-fill" style="min-width:120px">
                      <input type="radio" name="<?= $name ?>" id="<?= $name ?>_<?= esc(str_replace(' ','_',$opt)) ?>"
                        value="<?= esc($opt) ?>" class="d-none radio-custom"
                        <?= old($field['name']) === $opt ? 'checked' : '' ?>
                        <?= $required ? 'required' : '' ?>>
                      <label for="<?= $name ?>_<?= esc(str_replace(' ','_',$opt)) ?>"
                        class="d-flex align-items-center justify-content-center gap-2 p-3 rounded-3 border fw-semibold"
                        style="cursor:pointer;transition:all .2s;font-size:.88rem">
                        <?= esc($opt) ?>
                      </label>
                    </div>
                    <?php endforeach; ?>
                  </div>

                  <?php elseif ($type === 'select' && !empty($options)): ?>
                  <!-- Select dropdown -->
                  <select name="<?= $name ?>" id="field_<?= $name ?>"
                    class="form-select form-control-mentality"
                    <?= $required ? 'required' : '' ?>>
                    <option value="">-- Pilih <?= $label ?> --</option>
                    <?php foreach ($options as $opt): ?>
                    <option value="<?= esc($opt) ?>" <?= old($field['name']) === $opt ? 'selected' : '' ?>>
                      <?= esc($opt) ?>
                    </option>
                    <?php endforeach; ?>
                  </select>

                  <?php elseif ($type === 'textarea'): ?>
                  <!-- Textarea -->
                  <textarea name="<?= $name ?>" id="field_<?= $name ?>"
                    class="form-control form-control-mentality"
                    placeholder="<?= $placeholder ?>"
                    rows="3"
                    <?= $required ? 'required' : '' ?>><?= $oldVal ?></textarea>

                  <?php else: ?>
                  <!-- Text / Email / Number -->
                  <input type="<?= $type ?>" name="<?= $name ?>" id="field_<?= $name ?>"
                    class="form-control form-control-mentality"
                    placeholder="<?= $placeholder ?>"
                    value="<?= $oldVal ?>"
                    <?= $type === 'number' ? 'min="1" max="99"' : '' ?>
                    <?= $required ? 'required' : '' ?>>
                  <?php endif; ?>

                </div>
                <?php endforeach; ?>
              </div>

              <!-- Info privasi -->
              <div class="alert alert-light border mt-4 rounded-3" style="font-size:.82rem">
                <i class="bi bi-shield-check text-green-main me-2"></i>
                Data kamu <strong>tidak akan dibagikan</strong> ke pihak ketiga dan hanya digunakan untuk keperluan tes kesehatan mental ini.
              </div>

              <button type="submit" class="btn btn-primary-custom w-100 btn-lg mt-2">
                <i class="bi bi-arrow-right-circle me-2"></i>Lanjut ke Tes DASS-21
              </button>
            </form>

            <?php endif; ?>

          </div><!-- end form-card-body -->
        </div><!-- end form-card -->

      </div>
    </div>
  </div>
</section>

<style>
.radio-custom:checked + label {
  background: var(--green-pale);
  border-color: var(--green-main) !important;
  color: var(--green-main);
}
.radio-custom + label:hover { border-color: var(--green-main) !important; }
</style>

<!-- Auto-save draft saat form diisi & simpan flag pending setelah submit -->
<script>
// Dipanggil dari FormController via flash data setelah redirect ke /tes
<?php if (session()->getFlashdata('save_pending')): ?>
const _pending = <?= json_encode(session()->getFlashdata('save_pending')) ?>;
if (_pending) {
  SesiManager.saveAfterFormSubmit(_pending.nama, _pending.email);
}
<?php endif; ?>
</script>