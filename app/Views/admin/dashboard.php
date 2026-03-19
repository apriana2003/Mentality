<?php
$stats       = $stats       ?? [];
$distribusi  = $distribusi  ?? [];
$tesTerbaru  = $tesTerbaru  ?? [];
$threatsTerbaru = $threatsTerbaru ?? [];
?>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
  <?php foreach([
    ['total_responden','Total Responden','bi-people-fill','#dcfce7','#166534'],
    ['total_tes',      'Total Tes Selesai','bi-clipboard2-check-fill','#dbeafe','#1d4ed8'],
    ['total_blogs',    'Artikel Dipublikasi','bi-journal-richtext','#fef9c3','#854d0e'],
    ['total_threats',  'Ancaman Terdeteksi','bi-shield-exclamation','#fee2e2','#991b1b'],
  ] as $s): ?>
  <div class="col-lg-3 col-md-6">
    <div class="stat-card-admin">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="stat-icon" style="background:<?= $s[3] ?>;color:<?= $s[4] ?>">
          <i class="bi <?= $s[1] === 'Total Responden' ? $s[0] : '' ?> <?= $s[1] ?>"></i>
          <i class="bi <?= $s[2] ?>"></i>
        </div>
      </div>
      <div class="stat-num text-dark"><?= number_format($stats[$s[0]] ?? 0) ?></div>
      <div class="stat-label mt-1"><?= $s[1] ?></div>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<div class="row g-4 mb-4">
  <!-- Chart Distribusi -->
  <div class="col-lg-8">
    <div class="admin-table">
      <div class="table-header">
        <h6><i class="bi bi-bar-chart-fill me-2 text-green-main"></i>Distribusi Hasil DASS-21</h6>
      </div>
      <div class="p-4">
        <div style="position: relative; height: 300px;"> 
          <canvas id="chartDASS"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Quick Stats -->
  <div class="col-lg-4">
    <div class="admin-table h-100">
      <div class="table-header">
        <h6><i class="bi bi-shield-exclamation me-2 text-danger"></i>Ancaman Terbaru</h6>
      </div>
      <div class="p-3">
        <?php if(empty($threatsTerbaru)): ?>
        <div class="text-center py-3 text-muted small">
          <i class="bi bi-shield-check fs-4 d-block mb-2 text-success"></i>Tidak ada ancaman terdeteksi
        </div>
        <?php else: ?>
        <?php foreach($threatsTerbaru as $t): ?>
        <div class="d-flex align-items-start gap-2 mb-3 pb-3 border-bottom">
          <div style="width:8px;height:8px;border-radius:50%;margin-top:6px;flex-shrink:0;background:<?= $t['severity']==='Critical'?'#dc2626':($t['severity']==='High'?'#f97316':'#f59e0b') ?>"></div>
          <div>
            <div style="font-size:.8rem;font-weight:700"><?= esc($t['threat_type']) ?></div>
            <div style="font-size:.72rem;color:#64748b"><?= esc($t['ip_address']) ?> · <?= date('d/m H:i', strtotime($t['created_at'])) ?></div>
          </div>
          <span class="badge ms-auto" style="font-size:.65rem;background:<?= $t['severity']==='Critical'?'#fee2e2':($t['severity']==='High'?'#ffedd5':'#fef9c3') ?>;color:<?= $t['severity']==='Critical'?'#991b1b':($t['severity']==='High'?'#9a3412':'#854d0e') ?>"><?= $t['severity'] ?></span>
        </div>
        <?php endforeach; ?>
        <a href="<?= base_url('admin/security-logs') ?>" class="btn btn-sm btn-outline-green w-100 mt-1">Lihat Semua</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- Tabel Tes Terbaru -->
<div class="admin-table">
  <div class="table-header">
    <h6><i class="bi bi-clock-history me-2 text-green-main"></i>Tes Terbaru</h6>
    <a href="<?= base_url('admin/hasil-tes') ?>" class="btn btn-sm btn-outline-green">Lihat Semua</a>
  </div>
  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Nama</th><th>Universitas</th>
          <th>Depresi</th><th>Kecemasan</th><th>Stres</th><th>Waktu</th>
        </tr>
      </thead>
      <tbody>
        <?php if(empty($tesTerbaru)): ?>
        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data tes</td></tr>
        <?php else: ?>
        <?php foreach($tesTerbaru as $t): ?>
        <tr>
          <td class="fw-semibold"><?= esc($t['nama']) ?></td>
          <td class="text-muted"><?= esc($t['universitas'] ?? '-') ?></td>
          <?php foreach(['kategori_depresi','kategori_kecemasan','kategori_stres'] as $k):
            $cls = match($t[$k]) { 'Normal'=>'badge-normal','Ringan'=>'badge-ringan','Sedang'=>'badge-sedang','Berat'=>'badge-berat',default=>'badge-sangat-berat' };
          ?>
          <td><span class="badge <?= $cls ?>"><?= $t[$k] ?></span></td>
          <?php endforeach; ?>
          <td class="text-muted" style="font-size:.78rem"><?= date('d M Y H:i', strtotime($t['created_at'])) ?></td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
// Chart distribusi DASS-21
const labels  = ['Normal','Ringan','Sedang','Berat','Sangat Berat'];
const colors  = ['#22c55e','#eab308','#f97316','#ef4444','#a855f7'];

function mapData(raw) {
  return labels.map(l => {
    const found = raw.find(r => r.kategori === l);
    return found ? parseInt(found.total) : 0;
  });
}

const distribusi = <?= json_encode($distribusi) ?>;

new Chart(document.getElementById('chartDASS'), {
  type: 'bar',
  data: {
    labels,
    datasets: [
      { label: 'Depresi',   data: mapData(distribusi.depresi),   backgroundColor: '#86efac' },
      { label: 'Kecemasan', data: mapData(distribusi.kecemasan), backgroundColor: '#93c5fd' },
      { label: 'Stres',     data: mapData(distribusi.stres),     backgroundColor: '#fca5a5' },
    ]
  },
  options: {
    responsive: true,
    plugins: { legend: { position: 'top' } },
    scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
  }
});
</script>
