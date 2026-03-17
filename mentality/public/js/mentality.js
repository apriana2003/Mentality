/* ============================================================
   MENTALITY - Main JavaScript
   ============================================================ */

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
        const el  = entry.target;
        const end = parseInt(el.dataset.counter);
        animateCounter(el, end);
        observer.unobserve(el);
      }
    });
  }, { threshold: 0.5 });
  counters.forEach(c => observer.observe(c));

  function animateCounter(el, end) {
    let start = 0;
    const dur = 1800;
    const step = Math.ceil(end / (dur / 16));
    const timer = setInterval(() => {
      start += step;
      if (start >= end) { el.textContent = end.toLocaleString('id-ID') + (el.dataset.suffix || ''); clearInterval(timer); }
      else { el.textContent = start.toLocaleString('id-ID') + (el.dataset.suffix || ''); }
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

});

/* ============================================================
   CHATBOT
============================================================ */
const Chatbot = {
  sessionToken: null,
  isTyping: false,

  async init() {
    const wrapper = document.getElementById('chatWrapper');
    if (!wrapper) return;

    try {
      const res  = await fetch(BASE_URL + 'chatbot/session');
      const data = await res.json();
      this.sessionToken = data.token;

      // Render riwayat pesan
      const msgs = data.messages || [];
      if (msgs.length === 0) {
        this.appendMessage('ai', 'Halo! Saya Mentality AI 👋 Saya siap membantu kamu berbicara tentang kondisi mentalmu. Ceritakan apa yang kamu rasakan saat ini.');
      } else {
        msgs.forEach(m => this.appendMessage(m.role === 'user' ? 'user' : 'ai', m.content, false));
      }
    } catch (err) {
      console.error('Chat init error:', err);
    }

    // Event listeners
    const input  = document.getElementById('chatInput');
    const sendBtn = document.getElementById('sendBtn');

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
    const msg   = input.value.trim();
    if (!msg || this.isTyping) return;

    input.value = '';
    input.style.height = 'auto';
    this.appendMessage('user', msg);
    this.showTyping();
    this.isTyping = true;
    document.getElementById('sendBtn').disabled = true;

    try {
      const res  = await fetch(BASE_URL + 'chatbot/send', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        body: JSON.stringify({ message: msg }),
      });
      const data = await res.json();
      this.hideTyping();
      this.appendMessage('ai', data.reply || 'Maaf, terjadi kesalahan.');
    } catch (err) {
      this.hideTyping();
      this.appendMessage('ai', 'Koneksi bermasalah. Silakan coba lagi.');
    } finally {
      this.isTyping = false;
      document.getElementById('sendBtn').disabled = false;
    }
  },

  appendMessage(role, text, animate = true) {
    const container = document.getElementById('chatMessages');
    const div = document.createElement('div');
    div.className = `msg-bubble msg-${role}${animate ? '' : ''}`;

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
    return text
      .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
      .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
      .replace(/\n/g, '<br>');
  }
};

/* ============================================================
   TES DASS-21 — Progress bar & validasi
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
      if (bar) bar.style.width = pct + '%';
      if (counter) counter.textContent = answered + '/' + total;
    });

    form.addEventListener('submit', e => {
      const answered = form.querySelectorAll('input[type="radio"]:checked').length;
      if (answered < total) {
        e.preventDefault();
        const first = form.querySelector('input[type="radio"]:not(:checked)');
        if (first) {
          const card = first.closest('.question-card');
          card?.scrollIntoView({ behavior: 'smooth', block: 'center' });
          card?.classList.add('border-danger');
          setTimeout(() => card?.classList.remove('border-danger'), 2000);
        }
        showToast('Harap jawab semua ' + total + ' pertanyaan terlebih dahulu.', 'danger');
      }
    });
  }
};

function showToast(msg, type = 'info') {
  const el = document.createElement('div');
  el.className = `alert-floating alert alert-${type} alert-dismissible fade show shadow`;
  el.innerHTML = `<i class="bi bi-exclamation-circle-fill me-2"></i>${msg}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
  document.body.appendChild(el);
  setTimeout(() => bootstrap.Alert.getOrCreateInstance(el).close(), 4000);
}

// Init semua
Chatbot.init();
TesForm.init();
