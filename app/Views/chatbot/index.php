<?php $hasilTes = $hasilTes ?? null; ?>

<style>
body { overflow: hidden; }
main { height: calc(100vh - 72px); }

@media (max-width: 767px) {
  body { overflow: hidden; }
  main { height: calc(100dvh - 60px); }
  .chat-wrapper {
    height: calc(100dvh - 60px) !important;
  }
  .chat-input-area {
    padding-bottom: calc(1rem + env(safe-area-inset-bottom, 0px));
  }
  #suggestionChips {
    flex-wrap: nowrap;
    overflow-x: auto;
    padding-bottom: .5rem;
  }
  #suggestionChips::-webkit-scrollbar { display: none; }
}
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
    <div class="ms-auto d-flex gap-2 align-items-center">
      <?php if ($hasilTes): ?>
      <div id="hasilTesData" data-hasil='<?= json_encode([
          "depresi"   => $hasilTes["kategori_depresi"],
          "kecemasan" => $hasilTes["kategori_kecemasan"],
          "stres"     => $hasilTes["kategori_stres"],
          "skor_d"    => $hasilTes["skor_depresi"],
          "skor_k"    => $hasilTes["skor_kecemasan"],
          "skor_s"    => $hasilTes["skor_stres"],
      ]) ?>' style="display:none"></div>
      <?php endif; ?>
      <a href="<?= base_url('form') ?>" class="btn btn-sm" style="background:rgba(255,255,255,.15);color:white;border-radius:50px;font-size:.78rem">
        <i class="bi bi-clipboard2-pulse me-1"></i>Tes Dulu
      </a>
      <!-- Tombol Hapus Chat -->
      <button id="clearChatBtn" onclick="clearChat()" class="btn btn-sm" title="Hapus semua percakapan"
        style="background:rgba(255,80,80,.25);color:white;border:1px solid rgba(255,100,100,.4);border-radius:50px;font-size:.78rem">
        <i class="bi bi-trash3 me-1"></i><span class="d-none d-md-inline">Hapus Chat</span>
      </button>
    </div>
  </div>

  <!-- Info DASS jika ada -->
  <?php if ($hasilTes): ?>
  <div style="background:var(--green-pale);padding:.75rem 1.5rem;border-bottom:1px solid var(--gray-200)">
    <div class="d-flex align-items-center gap-3 flex-wrap">
      <span style="font-size:.8rem;font-weight:700;color:var(--green-main)">
        <i class="bi bi-info-circle me-1"></i>Hasil tes kamu telah diketahui AI:
      </span>
      <?php foreach([
        ['Depresi',   $hasilTes['kategori_depresi'],   $hasilTes['skor_depresi']],
        ['Kecemasan', $hasilTes['kategori_kecemasan'], $hasilTes['skor_kecemasan']],
        ['Stres',     $hasilTes['kategori_stres'],     $hasilTes['skor_stres']],
      ] as $r): ?>
      <span class="badge" style="background:white;color:var(--gray-800);border:1px solid var(--gray-200);font-size:.75rem;font-weight:600;padding:.3rem .7rem">
        <?= $r[0] ?>: <strong class="text-green-main"><?= esc($r[1]) ?></strong> (<?= $r[2] ?>)
      </span>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>

  <!-- Messages -->
  <div class="chat-messages" id="chatMessages">
    <!-- Diisi oleh JavaScript -->
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
      <?= esc($chip) ?>
    </button>
    <?php endforeach; ?>
  </div>

  <!-- Input area -->
  <div class="chat-input-area">
    <div class="chat-input-wrap ">
      <textarea
        id="chatInput"
        class="chat-input overflow-y-hidden"
        placeholder="Ketik pesanmu di sini... (Enter = kirim, Shift+Enter = baris baru)"
        rows="1"
      ></textarea>
      <button id="sendBtn" class="chat-send-btn" title="Kirim pesan">
        <i class="bi bi-send-fill"></i>
      </button>
    </div>
    <p class="text-muted text-center mt-2 mb-0" style="font-size:.72rem">
      <i class="bi bi-shield-lock me-1"></i>Percakapan ini aman & anonim. AI bukan pengganti psikiater profesional.
    </p>
  </div>

</div>

<!-- Modal Konfirmasi Hapus Chat -->
<div class="modal fade" id="modalHapusChat" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content rounded-4 border-0 shadow-lg">
      <div class="modal-body text-center p-4">
        <div style="width:56px;height:56px;background:#fee2e2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem">
          <i class="bi bi-trash3-fill text-danger fs-4"></i>
        </div>
        <h6 class="fw-bold mb-1">Hapus Semua Percakapan?</h6>
        <p class="text-muted small mb-4">Riwayat chat akan dihapus permanen dan tidak bisa dikembalikan.</p>
        <div class="d-flex gap-2">
          <button class="btn btn-light flex-fill rounded-3" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-danger flex-fill rounded-3" id="confirmClearBtn" onclick="confirmClearChat()">
            <i class="bi bi-trash3 me-1"></i>Hapus
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// ── Suggestion chip ───────────────────────────────────────
function useSuggestion(btn) {
  const input = document.getElementById('chatInput');
  input.value = btn.textContent.trim();
  document.getElementById('suggestionChips').style.display = 'none';
  input.focus();
  Chatbot.send();
}

// ── Hapus chat: tampilkan modal konfirmasi ────────────────
function clearChat() {
  const modal = new bootstrap.Modal(document.getElementById('modalHapusChat'));
  modal.show();
}

// ── Konfirmasi hapus: panggil endpoint + reset UI ─────────
async function confirmClearChat() {
  const btn = document.getElementById('confirmClearBtn');
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Menghapus...';

  try {
    const res = await fetch(BASE_URL + 'chatbot/clear', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
    });
    const data = await res.json();

    if (data.success) {
      // Tutup modal
      bootstrap.Modal.getInstance(document.getElementById('modalHapusChat')).hide();

      // Bersihkan tampilan pesan
      const container = document.getElementById('chatMessages');
      container.innerHTML = '';

      // Reset session chatbot di JS
      Chatbot.sessionToken = null;
      Chatbot._initialized = false;

      // Tampilkan kembali suggestion chips
      document.getElementById('suggestionChips').style.display = 'flex';

      // Tampilkan pesan sambutan ulang
      Chatbot.appendMessage('ai', 'Chat telah dihapus. Halo lagi! 👋 Ada yang ingin kamu ceritakan?');
    } else {
      alert('Gagal menghapus chat. Coba lagi.');
    }
  } catch (err) {
    console.error(err);
    alert('Terjadi kesalahan. Coba lagi.');
  } finally {
    btn.disabled = false;
    btn.innerHTML = '<i class="bi bi-trash3 me-1"></i>Hapus';
  }
}

// ── Fallback init ─────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
  if (typeof Chatbot !== 'undefined' && !Chatbot._initialized) {
    Chatbot.init();
  }
});
</script>