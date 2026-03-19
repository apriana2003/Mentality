/* ============================================================
   MENTALITY - Main JavaScript
   Fitur: localStorage persistence untuk sesi mahasiswa
   ============================================================ */

// ── Key constants untuk localStorage ─────────────────────────
const LS_KEY = {
  mahasiswa : 'mentality_mahasiswa',
  hasilTes  : 'mentality_hasil_tes',
  chatToken : 'mentality_chat_token',
};

// ── Helper: simpan & ambil dari localStorage ─────────────────
const LocalData = {
  save(key, value) {
    try { localStorage.setItem(key, JSON.stringify(value)); } catch(e) {}
  },
  get(key) {
    try {
      const v = localStorage.getItem(key);
      return v ? JSON.parse(v) : null;
    } catch(e) { return null; }
  },
  remove(key) {
    try { localStorage.removeItem(key); } catch(e) {}
  },
  clear() {
    Object.values(LS_KEY).forEach(k => {
      try { localStorage.removeItem(k); } catch(e) {}
    });
  }
};

document.addEventListener('DOMContentLoaded', function () {

  // ── Navbar scroll effect ──────────────────────────────────
  const navbar = document.getElementById('mainNavbar');
  if (navbar) {
    window.addEventListener('scroll', () => {
      navbar.classList.toggle('scrolled', window.scrollY > 40);
    });
  }

  // ── Auto-dismiss alerts after 4s ─────────────────────────
  document.querySelectorAll('.alert-floating').forEach(alert => {
    setTimeout(() => {
      const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
      bsAlert.close();
    }, 4000);
  });

  // ── Animate numbers (counter) ────────────────────────────
  const counters = document.querySelectorAll('[data-counter]');
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        animateCounter(entry.target, parseInt(entry.target.dataset.counter));
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.5 });
  counters.forEach(c => observer.observe(c));

  function animateCounter(el, end) {
    let start = 0;
    const step  = Math.ceil(end / (1800 / 16));
    const timer = setInterval(() => {
      start += step;
      if (start >= end) {
        el.textContent = end.toLocaleString('id-ID') + (el.dataset.suffix || '');
        clearInterval(timer);
      } else {
        el.textContent = start.toLocaleString('id-ID') + (el.dataset.suffix || '');
      }
    }, 16);
  }

  // ── Fade-in on scroll ─────────────────────────────────────
  const fadeEls = document.querySelectorAll('.fade-in-up');
  const fadeObs = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) { e.target.classList.add('visible'); fadeObs.unobserve(e.target); }
    });
  }, { threshold: 0.15 });
  fadeEls.forEach(el => fadeObs.observe(el));

  // ── Cek localStorage & tampilkan banner "lanjut sesi" ────
  SesiManager.checkAndShowBanner();

});

/* ============================================================
   SESI MANAGER — simpan & restore sesi mahasiswa
============================================================ */
const SesiManager = {

  // Simpan data setelah tes selesai
  saveAfterTes(mahasiswaId, nama, hasilTesId, depresi, kecemasan, stres, kdep, kkec, kstr) {
    LocalData.save(LS_KEY.mahasiswa, {
      id   : mahasiswaId,
      nama : nama,
    });
    LocalData.save(LS_KEY.hasilTes, {
      id                  : hasilTesId,
      skor_depresi        : depresi,
      skor_kecemasan      : kecemasan,
      skor_stres          : stres,
      kategori_depresi    : kdep,
      kategori_kecemasan  : kkec,
      kategori_stres      : kstr,
    });
    // Hapus token chat lama supaya sesi baru dibuat
    LocalData.remove(LS_KEY.chatToken);
  },

  // Simpan chat token
  saveChatToken(token) {
    LocalData.save(LS_KEY.chatToken, token);
  },

  getChatToken() {
    return LocalData.get(LS_KEY.chatToken);
  },

  getMahasiswa() {
    return LocalData.get(LS_KEY.mahasiswa);
  },

  getHasilTes() {
    return LocalData.get(LS_KEY.hasilTes);
  },

  hasSesi() {
    return !!(LocalData.get(LS_KEY.mahasiswa) && LocalData.get(LS_KEY.hasilTes));
  },

  clearSesi() {
    LocalData.clear();
  },

  // Tampilkan banner "Lanjut sesi sebelumnya" di halaman form
  checkAndShowBanner() {
    const formPage = document.getElementById('formDiri');
    if (!formPage) return;
    if (!this.hasSesi()) return;

    const mahasiswa = this.getMahasiswa();
    const hasil     = this.getHasilTes();
    if (!mahasiswa || !hasil) return;

    // Buat banner
    const banner = document.createElement('div');
    banner.className = 'alert rounded-3 mb-4 d-flex align-items-center gap-3';
    banner.style.cssText = 'background:#e8f5ee;border:1.5px solid #1a6b3c;color:#0f4c2a';
    banner.innerHTML = `
      <i class="bi bi-person-check-fill fs-4 flex-shrink-0"></i>
      <div class="flex-grow-1">
        <div class="fw-bold" style="font-size:.9rem">Hei, ${escapeHtml(mahasiswa.nama)}! Kamu punya sesi sebelumnya 👋</div>
        <div style="font-size:.8rem;opacity:.8">Hasil tes: Depresi <b>${escapeHtml(hasil.kategori_depresi)}</b> · Kecemasan <b>${escapeHtml(hasil.kategori_kecemasan)}</b> · Stres <b>${escapeHtml(hasil.kategori_stres)}</b></div>
      </div>
      <div class="d-flex gap-2 flex-shrink-0">
        <a href="${BASE_URL}services/konseling" class="btn btn-sm btn-primary-custom rounded-pill px-3">
          <i class="bi bi-robot me-1"></i>Lanjut Chat
        </a>
        <button onclick="SesiManager.clearSesiAndReload()" class="btn btn-sm rounded-pill px-3"
          style="background:white;border:1px solid #1a6b3c;color:#1a6b3c;font-size:.8rem">
          Mulai Baru
        </button>
      </div>
    `;

    // Sisipkan di atas form
    formPage.parentNode.insertBefore(banner, formPage);
  },

  clearSesiAndReload() {
    this.clearSesi();
    window.location.reload();
  }
};

function escapeHtml(str) {
  if (!str) return '';
  return String(str)
    .replace(/&/g,'&amp;').replace(/</g,'&lt;')
    .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

/* ============================================================
   CHATBOT
============================================================ */
const Chatbot = {
  sessionToken : null,
  isTyping     : false,
  _initialized : false,

  async init() {
    const container = document.getElementById('chatMessages');
    if (!container) return;
    if (this._initialized) return;
    this._initialized = true;

    try {
      // Kirim chat_token dari localStorage ke server via header custom
      const savedToken = SesiManager.getChatToken();
      const headers = { 'X-Requested-With': 'XMLHttpRequest' };
      if (savedToken) headers['X-Chat-Token'] = savedToken;

      const res  = await fetch(BASE_URL + 'chatbot/session', { headers });
      const data = await res.json();

      this.sessionToken = data.token;

      // Simpan token baru ke localStorage
      if (data.token) SesiManager.saveChatToken(data.token);

      // Render riwayat pesan
      const msgs = data.messages || [];
      if (msgs.length === 0) {
        const mahasiswa = SesiManager.getMahasiswa();
        const sapa = mahasiswa
          ? `Halo ${mahasiswa.nama}! 👋 Gue Mentality AI, teman curhat kamu. Gimana perasaan kamu sekarang?`
          : 'Halo! Gue Mentality AI 👋 Ceritain aja apa yang lagi kamu rasain sekarang.';
        this.appendMessage('ai', sapa);
      } else {
        msgs.forEach(m => this.appendMessage(m.role === 'user' ? 'user' : 'ai', m.content, false));
        // Scroll ke bawah
        container.scrollTop = container.scrollHeight;
      }
    } catch (err) {
      console.error('Chat init error:', err);
      this.appendMessage('ai', 'Aduh, ada gangguan koneksi nih. Coba refresh halaman ya!');
    }

    // Event listeners
    const input   = document.getElementById('chatInput');
    const sendBtn = document.getElementById('sendBtn');
    if (!input || !sendBtn) return;

    sendBtn.addEventListener('click', () => this.send());
    input.addEventListener('keydown', e => {
      if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); this.send(); }
    });
    input.addEventListener('input', () => {
      input.style.height = 'auto';
      input.style.height = Math.min(input.scrollHeight, 120) + 'px';
    });
  },

  async send() {
    const input = document.getElementById('chatInput');
    const msg   = input?.value?.trim();
    if (!msg || this.isTyping) return;

    input.value = '';
    input.style.height = 'auto';
    this.appendMessage('user', msg);
    this.showTyping();
    this.isTyping = true;
    document.getElementById('sendBtn').disabled = true;

    try {
      const res  = await fetch(BASE_URL + 'chatbot/send', {
        method  : 'POST',
        headers : { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        body    : JSON.stringify({ message: msg }),
      });
      const data = await res.json();
      this.hideTyping();
      this.appendMessage('ai', data.reply || 'Aduh, gue bingung nih. Coba tanya lagi ya!');
    } catch (err) {
      this.hideTyping();
      this.appendMessage('ai', 'Koneksi bermasalah nih. Coba lagi ya! 🙏');
    } finally {
      this.isTyping = false;
      document.getElementById('sendBtn').disabled = false;
    }
  },

  appendMessage(role, text, animate = true) {
    const container = document.getElementById('chatMessages');
    if (!container) return;
    const div  = document.createElement('div');
    div.className = `msg-bubble msg-${role}`;
    const time = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    div.innerHTML = `
      <div class="msg-content">${this.formatText(text)}</div>
      <div class="msg-time">${time}</div>
    `;
    container.appendChild(div);
    container.scrollTop = container.scrollHeight;
  },

  showTyping() {
    const container = document.getElementById('chatMessages');
    if (!container) return;
    const div = document.createElement('div');
    div.id = 'typingIndicator';
    div.className = 'msg-bubble msg-ai';
    div.innerHTML = '<div class="typing-indicator"><div class="typing-dot"></div><div class="typing-dot"></div><div class="typing-dot"></div></div>';
    container.appendChild(div);
    container.scrollTop = container.scrollHeight;
  },

  hideTyping() {
    document.getElementById('typingIndicator')?.remove();
  },

  formatText(text) {
    return String(text)
      .replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
      .replace(/\*\*(.*?)\*\*/g,'<strong>$1</strong>')
      .replace(/\n/g,'<br>');
  }
};

/* ============================================================
   TES DASS-21 — progress bar & validasi
============================================================ */
const TesForm = {
  init() {
    const form = document.getElementById('tesForm');
    if (!form) return;

    const total   = 21;
    const bar     = document.getElementById('tesProgressFill');
    const counter = document.getElementById('tesProgressCount');

    form.addEventListener('change', () => {
      const answered = form.querySelectorAll('input[type="radio"]:checked').length;
      const pct = Math.round((answered / total) * 100);
      if (bar)     bar.style.width   = pct + '%';
      if (counter) counter.textContent = answered + '/' + total;
    });

    form.addEventListener('submit', e => {
      const answered = form.querySelectorAll('input[type="radio"]:checked').length;
      if (answered < total) {
        e.preventDefault();
        const unanswered = form.querySelector('.question-card:not(:has(input:checked))');
        unanswered?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        unanswered?.classList.add('border-danger');
        setTimeout(() => unanswered?.classList.remove('border-danger'), 2000);
        showToast('Harap jawab semua ' + total + ' pertanyaan terlebih dahulu.', 'danger');
      }
    });
  }
};

function showToast(msg, type = 'info') {
  const el = document.createElement('div');
  el.className = `alert-floating alert alert-${type} alert-dismissible fade show shadow`;
  el.innerHTML = `<i class="bi bi-exclamation-circle-fill me-2"></i>${escapeHtml(msg)}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
  document.body.appendChild(el);
  setTimeout(() => bootstrap.Alert.getOrCreateInstance(el)?.close(), 4000);
}

// Init semua
Chatbot.init();
TesForm.init();