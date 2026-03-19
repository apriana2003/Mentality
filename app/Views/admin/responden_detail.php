<?php $responden=$responden??[]; $riwayatTes=$riwayatTes??[]; ?>

<div class="mb-3">
  <a href="<?= base_url('admin/mahasiswa') ?>" class="btn btn-sm btn-outline-secondary rounded-pill">
    <i class="bi bi-arrow-left me-1"></i>Kembali
  </a>
</div>

<div class="row g-4">
  <!-- Profil -->
  <div class="col-lg-4">
    <div class="admin-table p-4 text-center">
      <div style="width:72px;height:72px;background:var(--green-pale);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.8rem;font-weight:800;color:var(--green-main);margin:0 auto 1rem">
        <?= strtoupper(substr($responden['nama'],0,1)) ?>
      </div>
      <h5 class="fw-bold mb-1"><?= esc($responden['nama']) ?></h5>
      <p class="text-muted small mb-3"><?= esc($responden['email']) ?></p>

      <div class="d-flex flex-column gap-2 text-start mt-3">
        <?php foreach([
          ['bi-mortarboard','NIM', $responden['nim'] ?? '-'],
          ['bi-building','Universitas', $responden['universitas'] ?? '-'],
          ['bi-gender-ambiguous','Jenis Kelamin', $responden['jenis_kelamin']==='L'?'Laki-laki':'Perempuan'],
          ['bi-calendar3','Usia', $responden['usia'].' tahun'],
          ['bi-clock','Terdaftar', date('d M Y H:i', strtotime($responden['created_at']))],
        ] as $info): ?>
        <div class="d-flex align-items-center gap-2 p-2 rounded-3" style="background:#f8fafc">
          <i class="bi <?= $info[0] ?> text-green-main" style="width:20px"></i>
          <div>
            <div style="font-size:.68rem;color:#64748b"><?= $info[1] ?></div>
            <div style="font-size:.85rem;font-weight:600"><?= esc($info[2]) ?></div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <div class="mt-4 pt-3 border-top">
        <div class="row g-2">
          <div class="col-6">
            <div style="background:var(--green-pale);border-radius:10px;padding:.75rem;text-align:center">
              <div class="fw-bold text-green-main" style="font-size:1.4rem"><?= count($riwayatTes) ?></div>
              <div style="font-size:.7rem;color:#64748b">Total Tes</div>
            </div>
          </div>
          <div class="col-6">
            <div style="background:#eff6ff;border-radius:10px;padding:.75rem;text-align:center">
              <div class="fw-bold" style="font-size:1.4rem;color:#1d4ed8">
                <?= !empty($riwayatTes) ? date('d/m/Y', strtotime($riwayatTes[0]['created_at'])) : '-' ?>
              </div>
              <div style="font-size:.7rem;color:#64748b">Tes Terakhir</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Riwayat Tes -->
  <div class="col-lg-8">
    <div class="admin-table">
      <div class="table-header">
        <h6><i class="bi bi-clipboard2-data-fill me-2 text-green-main"></i>Riwayat Tes DASS-21</h6>
      </div>

      <?php if(empty($riwayatTes)): ?>
      <div class="text-center py-5 text-muted">
        <i class="bi bi-clipboard2-x fs-3 d-block mb-2"></i>
        Belum pernah mengerjakan tes
      </div>
      <?php else: ?>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Depresi</th><th>Kecemasan</th><th>Stres</th>
              <th>Status</th><th>Tanggal</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($riwayatTes as $i => $t):
              $levels = ['Normal'=>0,'Ringan'=>1,'Sedang'=>2,'Berat'=>3,'Sangat Berat'=>4];
              $highest = max($levels[$t['kategori_depresi']],$levels[$t['kategori_kecemasan']],$levels[$t['kategori_stres']]);
              $status = match(true) {
                $highest===0 => ['Sehat','badge-normal'],
                $highest===1 => ['Perlu Perhatian','badge-ringan'],
                $highest===2 => ['Perlu Perhatian Lebih','badge-sedang'],
                default      => ['Butuh Bantuan Profesional','badge-berat'],
              };
            ?>
            <tr>
              <td class="text-muted"><?= $i+1 ?></td>
              <?php foreach([
                [$t['skor_depresi'],$t['kategori_depresi']],
                [$t['skor_kecemasan'],$t['kategori_kecemasan']],
                [$t['skor_stres'],$t['kategori_stres']],
              ] as $sk):
                $cls = match($sk[1]) {'Normal'=>'badge-normal','Ringan'=>'badge-ringan','Sedang'=>'badge-sedang','Berat'=>'badge-berat',default=>'badge-sangat-berat'};
              ?>
              <td>
                <span class="badge <?= $cls ?>"><?= $sk[1] ?></span>
                <span class="text-muted ms-1" style="font-size:.75rem">(<?= $sk[0] ?>)</span>
              </td>
              <?php endforeach; ?>
              <td><span class="badge <?= $status[1] ?>"><?= $status[0] ?></span></td>
              <td class="text-muted" style="font-size:.78rem"><?= date('d M Y H:i', strtotime($t['created_at'])) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>
