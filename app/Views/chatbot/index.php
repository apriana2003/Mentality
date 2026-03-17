<?php $hasilTes = $hasilTes ?? null; ?>
<style>
body { overflow: hidden; }
main { height: calc(100vh - 72px); }
</style>

<div class="chat-wrapper">
  <!-- Header -->
  <div class="chat-header">
    <div class="position-relative">
      <div class="ai-avatar"><i class="bi bi-robot"></i></div>
      <div class="online-dot"></div>
    </div>
    <div>
      <div class="fw-bold" style="font-size:.95rem">Mentality AI</div>
      <div style="font-size:.75rem;opacity:.7">Konselor & Asisten Kesehatan Mental</div>
    </div>
    <div class="ms-auto d-flex gap-2">
      <?php if ($hasilTes): ?>
      <span class="badge" style="background:rgba(255,255,255,.2);font-size:.72rem;font-weight:600;padding:.4rem .8rem;border-radius:50px">
        <i class="bi bi-clipboard2-check me-1"></i>Data DASS-21 Tersedia
      </span>
      <?php endif; ?>
      <a href="<?= base_url('form') ?>" class="btn btn-sm" style="background:rgba(255,255,255,.15);color:white;border-radius:50px;font-size:.78rem">
        <i class="bi bi-clipboard2-pulse me-1"></i>Tes Dulu
      </a>
    </div>
  </div>

  <!-- Info DASS jika ada -->
  <?php if ($hasilTes): ?>
  <div style="background:var(--green-pale);padding:.75rem 1.5rem;border-bottom:1px solid var(--gray-200)">
    <div class="d-flex align-items-center gap-3 flex-wrap">
      <span style="font-size:.8rem;font-weight:700;color:var(--green-main)"><i class="bi bi-info-circle me-1"></i>Hasil tes kamu telah diketahui AI:</span>
      <?php foreach([
        ['Depresi',$hasilTes['kategori_depresi'],$hasilTes['skor_depresi']],
        ['Kecemasan',$hasilTes['kategori_kecemasan'],$hasilTes['skor_kecemasan']],
        ['Stres',$hasilTes['kategori_stres'],$hasilTes['skor_stres']],
      ] as $r): ?>
      <span class="badge" style="background:white;color:var(--gray-800);border:1px solid var(--gray-200);font-size:.75rem;font-weight:600;padding:.3rem .7rem">
        <?= $r[0] ?>: <strong class="text-green-main"><?= $r[1] ?></strong> (<?= $r[2] ?>)
      </span>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>

  <!-- Messages -->
  <div class="chat-messages" id="chatMessages">
    <!-- Pesan diisi oleh JavaScript -->
  </div>

  <!-- Suggestion chips -->
  <div id="suggestionChips" style="padding:.5rem 1.5rem;display:flex;gap:.5rem;flex-wrap:wrap;background:white;border-top:1px solid var(--gray-200)">
    <?php foreach([
      'Apa itu depresi?',
      'Cara mengatasi kecemasan',
      'Tips mengurangi stres kuliah',
      'Kapan harus ke psikolog?',
    ] as $chip): ?>
    <button class="btn btn-sm suggestion-chip" onclick="useSuggestion(this)"
      style="background:var(--green-pale);color:var(--green-main);border:none;border-radius:50px;font-size:.78rem;font-weight:600;padding:.3rem .85rem">
      <?= $chip ?>
    </button>
    <?php endforeach; ?>
  </div>

  <!-- Input -->
  <div class="chat-input-area">
    <div class="chat-input-wrap">
      <textarea id="chatInput" class="chat-input" placeholder="Ketik pesanmu di sini..." rows="1"></textarea>
      <button id="sendBtn" class="chat-send-btn" title="Kirim">
        <i class="bi bi-send-fill"></i>
      </button>
    </div>
    <p class="text-muted text-center mt-2 mb-0" style="font-size:.72rem">
      <i class="bi bi-shield-lock me-1"></i>Percakapan ini aman & anonim. AI bukan pengganti psikiater profesional.
    </p>
  </div>
</div>

<script>
const BASE_URL = '<?= base_url() ?>';

function useSuggestion(btn) {
  const input = document.getElementById('chatInput');
  input.value = btn.textContent.trim();
  document.getElementById('suggestionChips').style.display = 'none';
  Chatbot.send();
}
</script>
