/* ============================================================
   MENTALITY - Main JavaScript
   Fitur:
   - localStorage persistence sesi mahasiswa
   - Auto-save form data diri saat mengetik
   - Banner reminder tes belum selesai
   ============================================================ */

// ── Key constants untuk localStorage ─────────────────────────
const LS_KEY = {
  mahasiswa   : 'mentality_mahasiswa',
  hasilTes    : 'mentality_hasil_tes',
  chatToken   : 'mentality_chat_token',
  formDraft   : 'mentality_form_draft',   // Draft form data diri
  tesBelumSelesai : 'mentality_tes_pending', // Flag tes belum selesai
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

  // ── Inisialisasi fitur halaman ────────────────────────────
  SesiManager.checkAndShowBanner();
  FormAutoSave.init();
  ReminderBanner.init();

});

/* ============================================================
   SESI MANAGER — simpan & restore sesi mahasiswa
============================================================ */
const SesiManager = {

  // Dipanggil setelah tes selesai (dari view hasil/index.php)
  saveAfterTes(mahasiswaId, nama, hasilTesId, depresi, kecemasan, stres, kdep, kkec, kstr) {
    LocalData.save(LS_KEY.mahasiswa, { id: mahasiswaId, nama });
    LocalData.save(LS_KEY.hasilTes, {
      id                 : hasilTesId,
      skor_depresi       : depresi,
      skor_kecemasan     : kecemasan,
      skor_stres         : stres,
      kategori_depresi   : kdep,
      kategori_kecemasan : kkec,
      kategori_stres     : kstr,
    });
    // Hapus draft & flag pending karena tes sudah selesai
    LocalData.remove(LS_KEY.formDraft);
    LocalData.remove(LS_KEY.tesBelumSelesai);
    LocalData.remove(LS_KEY.chatToken);
  },

  // Dipanggil setelah submit form data diri (dari view form/index.php)
  saveAfterFormSubmit(nama, email) {
    LocalData.save(LS_KEY.tesBelumSelesai, {
      nama,
      email,
      savedAt : new Date().toISOString(),
    });
    // Hapus draft karena sudah submit
    LocalData.remove(LS_KEY.formDraft);
  },

  saveChatToken(token)  { LocalData.save(LS_KEY.chatToken, token); },
  getChatToken()        { return LocalData.get(LS_KEY.chatToken); },
  getMahasiswa()        { return LocalData.get(LS_KEY.mahasiswa); },
  getHasilTes()         { return LocalData.get(LS_KEY.hasilTes); },
  getFormDraft()        { return LocalData.get(LS_KEY.formDraft); },
  getTesPending()       { return LocalData.get(LS_KEY.tesBelumSelesai); },

  hasSesi() {
    return !!(LocalData.get(LS_KEY.mahasiswa) && LocalData.get(LS_KEY.hasilTes));
  },

  clearSesi() { LocalData.clear(); },

  clearSesiAndReload() {
    this.clearSesi();
    window.location.reload();
  },

  // ── Banner sesi sebelumnya (tes sudah selesai) ────────────
  checkAndShowBanner() {
    const formPage = document.getElementById('formDiri');
    if (!formPage) return;
    if (!this.hasSesi()) return;

    const mahasiswa = this.getMahasiswa();
    const hasil     = this.getHasilTes();
    if (!mahasiswa || !hasil) return;

    const banner = document.createElement('div');
    banner.className = 'alert rounded-3 mb-4 d-flex align-items-center gap-3 flex-wrap';
    banner.style.cssText = 'background:#e8f5ee;border:1.5px solid #1a6b3c;color:#0f4c2a';
    banner.innerHTML = `
      <i class="bi bi-person-check-fill fs-4 flex-shrink-0" style="color:#1a6b3c"></i>
      <div class="flex-grow-1">
        <div class="fw-bold" style="font-size:.9rem">Hei, ${escapeHtml(mahasiswa.nama)}! Kamu punya sesi sebelumnya 👋</div>
        <div style="font-size:.8rem;opacity:.8;margin-top:.2rem">
          Hasil tes: Depresi <b>${escapeHtml(hasil.kategori_depresi)}</b>
          · Kecemasan <b>${escapeHtml(hasil.kategori_kecemasan)}</b>
          · Stres <b>${escapeHtml(hasil.kategori_stres)}</b>
        </div>
      </div>
      <div class="d-flex gap-2 flex-shrink-0">
        <a href="${BASE_URL}services/konseling" class="btn btn-sm btn-primary-custom rounded-pill px-3">
          <i class="bi bi-robot me-1"></i>Lanjut Chat
        </a>
        <button onclick="SesiManager.clearSesiAndReload()"
          class="btn btn-sm rounded-pill px-3"
          style="background:white;border:1px solid #1a6b3c;color:#1a6b3c;font-size:.8rem">
          Mulai Baru
        </button>
      </div>
    `;
    formPage.parentNode.insertBefore(banner, formPage);
  },
};

/* ============================================================
   FORM AUTO-SAVE — simpan draft form data diri ke localStorage
============================================================ */
const FormAutoSave = {
  saveTimer: null,

  init() {
    const form = document.getElementById('formDiri');
    if (!form) return;

    // Restore draft jika ada
    this.restoreDraft(form);

    // Auto-save saat ada perubahan input (debounce 800ms)
    form.addEventListener('input', () => {
      clearTimeout(this.saveTimer);
      this.saveTimer = setTimeout(() => this.saveDraft(form), 800);
    });

    form.addEventListener('change', () => {
      clearTimeout(this.saveTimer);
      this.saveTimer = setTimeout(() => this.saveDraft(form), 800);
    });

    // Tampilkan indikator auto-save
    this.createIndicator(form);
  },

  saveDraft(form) {
    const draft = {};
    const inputs = form.querySelectorAll('input:not([type="hidden"]):not([type="submit"]), select, textarea');

    inputs.forEach(input => {
      if (!input.name) return;
      if (input.type === 'radio') {
        if (input.checked) draft[input.name] = input.value;
      } else {
        draft[input.name] = input.value;
      }
    });

    // Hanya simpan jika ada isian
    const hasData = Object.values(draft).some(v => v && v.trim?.() !== '');
    if (!hasData) return;

    draft._savedAt = new Date().toISOString();
    LocalData.save(LS_KEY.formDraft, draft);
    this.showSavedIndicator();
  },

  restoreDraft(form) {
    // Jangan restore kalau sudah punya sesi selesai
    if (SesiManager.hasSesi()) return;

    const draft = LocalData.get(LS_KEY.formDraft);
    if (!draft) return;

    const inputs = form.querySelectorAll('input:not([type="hidden"]):not([type="submit"]), select, textarea');
    let restored = false;

    inputs.forEach(input => {
      if (!input.name || !(input.name in draft)) return;
      const val = draft[input.name];
      if (!val) return;

      if (input.type === 'radio') {
        if (input.value === val) {
          input.checked = true;
          // Trigger style update untuk radio custom
          input.dispatchEvent(new Event('change', { bubbles: true }));
        }
      } else {
        input.value = val;
      }
      restored = true;
    });

    if (restored) {
      // Tampilkan notif draft dipulihkan
      const notice = document.createElement('div');
      notice.className = 'alert rounded-3 mb-3 d-flex align-items-center gap-2';
      notice.style.cssText = 'background:#eff6ff;border:1px solid #93c5fd;color:#1d4ed8;font-size:.83rem';
      notice.innerHTML = `
        <i class="bi bi-floppy-fill flex-shrink-0"></i>
        <span>Draft tersimpan dipulihkan — lanjutkan mengisi form kamu.</span>
        <button onclick="FormAutoSave.clearDraftAndReload()"
          class="btn btn-sm ms-auto rounded-pill"
          style="background:white;border:1px solid #93c5fd;color:#1d4ed8;font-size:.75rem;white-space:nowrap">
          Hapus Draft
        </button>
      `;
      form.parentNode.insertBefore(notice, form);
    }
  },

  createIndicator(form) {
    const indicator = document.createElement('div');
    indicator.id = 'autoSaveIndicator';
    indicator.style.cssText = 'font-size:.72rem;color:#64748b;text-align:right;margin-bottom:.5rem;display:none';
    indicator.innerHTML = '<i class="bi bi-check-circle-fill text-success me-1"></i>Draft tersimpan otomatis';
    form.parentNode.insertBefore(indicator, form);
  },

  showSavedIndicator() {
    const el = document.getElementById('autoSaveIndicator');
    if (!el) return;
    el.style.display = 'block';
    clearTimeout(this._hideTimer);
    this._hideTimer = setTimeout(() => { el.style.display = 'none'; }, 3000);
  },

  clearDraftAndReload() {
    LocalData.remove(LS_KEY.formDraft);
    window.location.reload();
  },
};

/* ============================================================
   REMINDER BANNER — pengingat tes belum selesai
   Tampil di halaman BERANDA & TES jika mahasiswa sudah isi
   form tapi belum selesaikan tes
============================================================ */
const ReminderBanner = {
  init() {
    const pending = SesiManager.getTesPending();
    if (!pending) return;

    // Jangan tampil kalau sesi tes sudah selesai
    if (SesiManager.hasSesi()) {
      LocalData.remove(LS_KEY.tesBelumSelesai);
      return;
    }

    // Hitung berapa lama sejak daftar
    const savedAt  = new Date(pending.savedAt);
    const diffMin  = Math.round((Date.now() - savedAt) / 60000);
    const timeAgo  = diffMin < 60
      ? `${diffMin} menit lalu`
      : `${Math.round(diffMin/60)} jam lalu`;

    // Tampilkan di beranda (sebelum hero CTA) atau di bagian atas halaman tes
    const targets = [
      document.querySelector('.hero-section'),   // beranda
      document.querySelector('.form-section'),    // form
      document.getElementById('tesForm'),         // tes
    ].filter(Boolean);

    if (targets.length === 0) return;

    const banner = document.createElement('div');
    banner.style.cssText = 'background:#fef9c3;border-bottom:2px solid #fbbf24;padding:.75rem 0';
    banner.innerHTML = `
      <div class="container">
        <div class="d-flex align-items-center gap-3 flex-wrap justify-content-between">
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-clock-history" style="color:#d97706;font-size:1.1rem"></i>
            <div>
              <span style="font-size:.85rem;font-weight:700;color:#92400e">
                Hei, ${escapeHtml(pending.nama)}! Kamu belum menyelesaikan tes mental.
              </span>
              <span style="font-size:.78rem;color:#b45309;margin-left:.5rem">Dimulai ${timeAgo}</span>
            </div>
          </div>
          <div class="d-flex gap-2">
            <a href="${BASE_URL}tes" class="btn btn-sm rounded-pill fw-bold"
              style="background:#fbbf24;color:#1c1917;border:none;font-size:.78rem">
              <i class="bi bi-play-fill me-1"></i>Lanjut Tes
            </a>
            <button onclick="ReminderBanner.dismiss()"
              class="btn btn-sm rounded-pill"
              style="background:transparent;border:1px solid #d97706;color:#92400e;font-size:.78rem">
              Nanti Saja
            </button>
          </div>
        </div>
      </div>
    `;

    // Sisipkan sebelum elemen target pertama
    const target = targets[0];
    target.parentNode.insertBefore(banner, target);
  },

  dismiss() {
    LocalData.remove(LS_KEY.tesBelumSelesai);
    window.location.reload();
  },
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
      const savedToken = SesiManager.getChatToken();
      const headers    = { 'X-Requested-With': 'XMLHttpRequest' };
      if (savedToken) headers['X-Chat-Token'] = savedToken;

      const res  = await fetch(BASE_URL + 'chatbot/session', { headers });
      const data = await res.json();

      this.sessionToken = data.token;
      if (data.token) SesiManager.saveChatToken(data.token);

      const msgs = data.messages || [];

      if (msgs.length === 0) {
        // Cek apakah ada hasil tes
        const hasilEl  = document.getElementById('hasilTesData');
        const hasilTes = hasilEl ? JSON.parse(hasilEl.dataset.hasil) : null;
        const mahasiswa = SesiManager.getMahasiswa();

        if (hasilTes && data.has_hasil_tes) {
          // Ada hasil tes — minta AI beri nasihat otomatis
          this.showTyping();
          this.isTyping = true;
          document.getElementById('sendBtn').disabled = true;

          try {
            const res2 = await fetch(BASE_URL + 'chatbot/send', {
              method  : 'POST',
              headers : { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
              body    : JSON.stringify({ message: '__init_with_hasil_tes__' }),
            });
            const data2 = await res2.json();
            this.hideTyping();
            this.appendMessage('ai', data2.reply || 'Halo! Gue udah lihat hasil tes kamu nih 👋');
          } catch (err) {
            this.hideTyping();
            const sapa = mahasiswa
              ? `Halo ${mahasiswa.nama}! 👋 Gue udah lihat hasil tes kamu. Ada yang mau kamu ceritain?`
              : 'Halo! 👋 Gue udah lihat hasil tes kamu. Ada yang mau kamu ceritain?';
            this.appendMessage('ai', sapa);
          } finally {
            this.isTyping = false;
            document.getElementById('sendBtn').disabled = false;
          }
        } else {
          // Tidak ada hasil tes — sapa biasa
          const sapa = mahasiswa
            ? `Halo ${mahasiswa.nama}! 👋 Gue Mentality AI, teman curhat kamu. Gimana perasaan kamu sekarang?`
            : 'Halo! Gue Mentality AI 👋 Ceritain aja apa yang lagi kamu rasain sekarang.';
          this.appendMessage('ai', sapa);
        }
      } else {
        msgs.forEach(m => this.appendMessage(m.role === 'user' ? 'user' : 'ai', m.content, false));
        container.scrollTop = container.scrollHeight;
      }
    } catch (err) {
      console.error('Chat init error:', err);
      this.appendMessage('ai', 'Aduh, ada gangguan koneksi nih. Coba refresh halaman ya!');
    }

    const input   = document.getElementById('chatInput');
    const sendBtn = document.getElementById('sendBtn');
    if (!input || !sendBtn) return;

    sendBtn.addEventListener('click',  () => this.send());
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
    document.getElementById('suggestionChips').style.display = 'none';
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

  hideTyping() { document.getElementById('typingIndicator')?.remove(); },

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

    const total   = form.querySelectorAll('.question-card').length;
    const bar     = document.getElementById('tesProgressFill');
    const counter = document.getElementById('tesProgressCount');

    form.addEventListener('change', () => {
      const answered = form.querySelectorAll('input[type="radio"]:checked').length;
      const pct = Math.round((answered / total) * 100);
      if (bar)     bar.style.width    = pct + '%';
      if (counter) counter.textContent = answered + '/' + total;
    });

    form.addEventListener('submit', e => {
      const answered = form.querySelectorAll('input[type="radio"]:checked').length;
      if (answered < total) {
        e.preventDefault();
        const cards = form.querySelectorAll('.question-card');
        let firstUnanswered = null;
        cards.forEach(card => {
          if (!card.querySelector('input:checked') && !firstUnanswered) {
            firstUnanswered = card;
          }
        });
        firstUnanswered?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        firstUnanswered?.classList.add('border-danger');
        setTimeout(() => firstUnanswered?.classList.remove('border-danger'), 2000);
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

// Init semua//
Chatbot.init();
TesForm.init();