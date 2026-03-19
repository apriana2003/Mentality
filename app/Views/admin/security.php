<?php $logs=$logs??[]; $total=$total??0; $summary=$summary??[]; ?>

<!-- Summary cards -->
<div class="row g-3 mb-4">
  <?php
  $sevCount = ['Low'=>0,'Medium'=>0,'High'=>0,'Critical'=>0];
  foreach($summary as $s) { if(isset($sevCount[$s['severity']])) $sevCount[$s['severity']] += $s['total']; }
  foreach([
    ['Critical','#fee2e2','#991b1b','bi-exclamation-octagon-fill'],
    ['High','#ffedd5','#9a3412','bi-exclamation-triangle-fill'],
    ['Medium','#fef9c3','#854d0e','bi-exclamation-circle-fill'],
    ['Low','#dcfce7','#166534','bi-info-circle-fill'],
  ] as $sv): ?>
  <div class="col-6 col-md-3">
    <div class="stat-card-admin">
      <div class="stat-icon mb-2" style="background:<?=$sv[1]?>;color:<?=$sv[2]?>">
        <i class="bi <?=$sv[3]?>"></i>
      </div>
      <div class="stat-num" style="color:<?=$sv[2]?>"><?= number_format($sevCount[$sv[0]]) ?></div>
      <div class="stat-label"><?=$sv[0]?></div>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<div class="admin-table">
  <div class="table-header">
    <h6><i class="bi bi-shield-exclamation me-2 text-danger"></i>Log Ancaman Keamanan
      <span class="badge bg-danger ms-2"><?= number_format($total) ?></span>
    </h6>
  </div>
  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr><th>Waktu</th><th>Jenis Ancaman</th><th>IP Address</th><th>Method</th><th>URI</th><th>Severity</th></tr>
      </thead>
      <tbody>
        <?php if(empty($logs)): ?>
        <tr><td colspan="6" class="text-center py-5 text-muted">
          <i class="bi bi-shield-check fs-3 d-block mb-2 text-success"></i>Tidak ada ancaman terdeteksi
        </td></tr>
        <?php else: ?>
        <?php foreach($logs as $l):
          $svCls = match($l['severity']) { 'Critical'=>'badge-severity-critical','High'=>'badge-severity-high','Medium'=>'badge-severity-medium',default=>'badge-severity-low' };
        ?>
        <tr>
          <td style="font-size:.78rem;color:#64748b;white-space:nowrap"><?= date('d M Y H:i:s', strtotime($l['created_at'])) ?></td>
          <td><span class="fw-semibold" style="font-size:.85rem"><?= esc($l['threat_type']) ?></span></td>
          <td><code style="font-size:.8rem"><?= esc($l['ip_address']) ?></code></td>
          <td><span class="badge" style="background:#eff6ff;color:#1d4ed8"><?= esc($l['method']) ?></span></td>
          <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:.78rem" title="<?= esc($l['uri']) ?>">
            <?= esc($l['uri']) ?>
          </td>
          <td><span class="badge <?= $svCls ?>"><?= $l['severity'] ?></span></td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
