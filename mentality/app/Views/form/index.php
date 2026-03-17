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

            <!-- Validation errors -->
            <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger rounded-3 mb-4">
              <strong><i class="bi bi-exclamation-triangle me-2"></i>Harap perbaiki:</strong>
              <ul class="mb-0 mt-1">
                <?php foreach((array)session()->getFlashdata('errors') as $err): ?>
                <li><?= esc($err) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
            <?php endif; ?>

            <form action="<?= base_url('form/submit') ?>" method="POST" id="formDiri">
              <?= csrf_field() ?>

              <div class="row g-3">
                <div class="col-12">
                  <label class="form-label-mentality">Nama Lengkap <span class="text-danger">*</span></label>
                  <input type="text" name="nama" class="form-control form-control-mentality"
                    placeholder="Contoh: Budi Santoso"
                    value="<?= esc(old('nama')) ?>" required>
                </div>

                <div class="col-12">
                  <label class="form-label-mentality">Alamat Email <span class="text-danger">*</span></label>
                  <input type="email" name="email" class="form-control form-control-mentality"
                    placeholder="contoh@email.com"
                    value="<?= esc(old('email')) ?>" required>
                </div>

                <div class="col-md-6">
                  <label class="form-label-mentality">NIM (Opsional)</label>
                  <input type="text" name="nim" class="form-control form-control-mentality"
                    placeholder="Nomor Induk Mahasiswa"
                    value="<?= esc(old('nim')) ?>">
                </div>

                <div class="col-md-6">
                  <label class="form-label-mentality">Usia <span class="text-danger">*</span></label>
                  <input type="number" name="usia" class="form-control form-control-mentality"
                    placeholder="Usia dalam tahun" min="15" max="99"
                    value="<?= esc(old('usia')) ?>" required>
                </div>

                <div class="col-12">
                  <label class="form-label-mentality">Perguruan Tinggi (Opsional)</label>
                  <input type="text" name="universitas" class="form-control form-control-mentality"
                    placeholder="Nama universitas / kampus kamu"
                    value="<?= esc(old('universitas')) ?>">
                </div>

                <div class="col-12">
                  <label class="form-label-mentality">Jenis Kelamin <span class="text-danger">*</span></label>
                  <div class="d-flex gap-3 mt-1">
                    <?php foreach([['L','Laki-laki','bi-gender-male'],['P','Perempuan','bi-gender-female']] as $jk): ?>
                    <div class="flex-fill">
                      <input type="radio" name="jenis_kelamin" id="jk_<?= $jk[0] ?>" value="<?= $jk[0] ?>"
                        class="d-none jk-radio" <?= old('jenis_kelamin') == $jk[0] ? 'checked' : '' ?> required>
                      <label for="jk_<?= $jk[0] ?>" class="jk-label d-flex align-items-center justify-content-center gap-2 p-3 rounded-3 border fw-semibold" style="cursor:pointer;transition:all .2s">
                        <i class="bi <?= $jk[2] ?>"></i><?= $jk[1] ?>
                      </label>
                    </div>
                    <?php endforeach; ?>
                  </div>
                </div>
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

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
.jk-radio:checked + .jk-label {
  background: var(--green-pale);
  border-color: var(--green-main) !important;
  color: var(--green-main);
}
.jk-label:hover { border-color: var(--green-main) !important; }
</style>
