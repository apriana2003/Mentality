<?php $hasil=$hasil??[]; $total=$total??0; $page=$page??1; $perPage=$perPage??15; $search=$search??''; $filter=$filter??''; ?>

<div class="admin-table">
  <div class="table-header">
    <h6><i class="bi bi-clipboard2-data-fill me-2 text-green-main"></i>Hasil Tes DASS-21
      <span class="badge bg-green-main ms-2"><?= number_format($total) ?></span>
    </h6>
    <form method="GET" class="d-flex gap-2 flex-wrap">
      <input type="text" name="search" class="form-control form-control-sm rounded-pill" style="width:200px"
        placeholder="Cari nama / email..." value="<?= esc($search) ?>">
      <select name="filter" class="form-select form-select-sm rounded-pill" style="width:160px">
        <option value="">Semua Kategori</option>
        <?php foreach(['Normal','Ringan','Sedang','Berat','Sangat Berat'] as $k): ?>
        <option value="<?= $k ?>" <?= $filter===$k?'selected':'' ?>><?= $k ?></option>
        <?php endforeach; ?>
      </select>
      <button class="btn btn-sm btn-primary-custom rounded-pill px-3"><i class="bi bi-search"></i></button>
      <?php if($search||$filter): ?>
      <a href="<?= base_url('admin/hasil-tes') ?>" class="btn btn-sm btn-outline-secondary rounded-pill">Reset</a>
      <?php endif; ?>
    </form>
  </div>

  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th><th>Nama</th><th>Universitas</th>
          <th>Depresi</th><th>Kecemasan</th><th>Stres</th>
          <th>Status Umum</th><th>Tanggal</th>
        </tr>
      </thead>
      <tbody>
        <?php if(empty($hasil)): ?>
        <tr><td colspan="8" class="text-center text-muted py-5">
          <i class="bi bi-inbox fs-3 d-block mb-2"></i>Tidak ada data
        </td></tr>
        <?php else: ?>
        <?php foreach($hasil as $i => $h):
          $levels = ['Normal'=>0,'Ringan'=>1,'Sedang'=>2,'Berat'=>3,'Sangat Berat'=>4];
          $highest = max($levels[$h['kategori_depresi']],$levels[$h['kategori_kecemasan']],$levels[$h['kategori_stres']]);
          $status = match(true) {
            $highest===0 => ['Sehat','badge-normal'],
            $highest===1 => ['Perlu Perhatian','badge-ringan'],
            $highest===2 => ['Perlu Perhatian Lebih','badge-sedang'],
            default      => ['Butuh Bantuan Profesional','badge-berat'],
          };
        ?>
        <tr>
          <td class="text-muted"><?= ($page-1)*$perPage+$i+1 ?></td>
          <td>
            <div class="fw-semibold"><?= esc($h['nama']) ?></div>
            <div style="font-size:.75rem;color:#64748b"><?= esc($h['email']) ?></div>
          </td>
          <td class="text-muted"><?= esc($h['universitas']??'-') ?></td>
          <?php foreach([
            [$h['skor_depresi'],$h['kategori_depresi']],
            [$h['skor_kecemasan'],$h['kategori_kecemasan']],
            [$h['skor_stres'],$h['kategori_stres']],
          ] as $sk):
            $cls=match($sk[1]){'Normal'=>'badge-normal','Ringan'=>'badge-ringan','Sedang'=>'badge-sedang','Berat'=>'badge-berat',default=>'badge-sangat-berat'};
          ?>
          <td>
            <span class="badge <?= $cls ?>"><?= $sk[1] ?></span>
            <span style="font-size:.72rem;color:#64748b"> (<?= $sk[0] ?>)</span>
          </td>
          <?php endforeach; ?>
          <td><span class="badge <?= $status[1] ?>"><?= $status[0] ?></span></td>
          <td style="font-size:.78rem;color:#64748b"><?= date('d M Y H:i', strtotime($h['created_at'])) ?></td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <?php if($total > $perPage): $pages = ceil($total/$perPage); ?>
  <div class="d-flex justify-content-between align-items-center p-3 border-top">
    <span class="text-muted small">Menampilkan <?= min($perPage, $total-($page-1)*$perPage) ?> dari <?= number_format($total) ?> data</span>
    <div class="d-flex gap-1">
      <?php for($i=1;$i<=$pages;$i++): ?>
      <a href="?page=<?=$i?>&search=<?=urlencode($search)?>&filter=<?=urlencode($filter)?>"
        class="btn btn-sm <?=$i==$page?'btn-primary-custom':'btn-outline-secondary'?> rounded-circle"
        style="width:32px;height:32px;padding:0;display:flex;align-items:center;justify-content:center;font-size:.78rem">
        <?=$i?>
      </a>
      <?php endfor; ?>
    </div>
  </div>
  <?php endif; ?>
</div>
