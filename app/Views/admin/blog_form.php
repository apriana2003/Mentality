<?php
$blog      = $blog      ?? null;
$isEdit    = !empty($blog);
$pageTitle = $isEdit ? 'Edit Artikel' : 'Tambah Artikel';
$icons     = ['Stres'=>'bi-wind','Kecemasan'=>'bi-lightning','Depresi'=>'bi-cloud-rain','Tips'=>'bi-lightbulb','Trauma'=>'bi-bandaid'];
?>

<!-- CKEditor 5 — 100% Gratis, tanpa API key, works di hosting manapun -->
<script src="https://cdn.jsdelivr.net/npm/ckeditor5@43.3.1/dist/browser/ckeditor5.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ckeditor5@43.3.1/dist/browser/ckeditor5.css">

<style>
  /* Styling container CKEditor */
  .ck-editor__editable {
    min-height: 400px !important;
    font-family: 'Plus Jakarta Sans', Arial, sans-serif !important;
    font-size: 15px !important;
    line-height: 1.8 !important;
    color: #1f2937 !important;
  }
  .ck.ck-editor__main > .ck-editor__editable:not(.ck-focused) {
    border-color: #d1d5db !important;
  }
  .ck.ck-editor__main > .ck-editor__editable.ck-focused {
    border-color: var(--green-main) !important;
    box-shadow: 0 0 0 3px rgba(26,107,60,.1) !important;
  }
  .ck-toolbar {
    border-color: #d1d5db !important;
    background: #f8fafc !important;
    border-radius: 8px 8px 0 0 !important;
  }
  .ck-editor__editable {
    border-radius: 0 0 8px 8px !important;
  }
</style>

<div class="d-flex align-items-center gap-3 mb-4">
  <a href="<?= base_url('admin/blogs') ?>" class="btn btn-sm btn-outline-secondary rounded-pill">
    <i class="bi bi-arrow-left me-1"></i>Kembali
  </a>
  <h5 class="fw-bold mb-0">
    <i class="bi bi-journal-richtext me-2 text-green-main"></i><?= $pageTitle ?>
  </h5>
</div>

<form action="<?= base_url('admin/blogs/save') ?>" method="POST"
  enctype="multipart/form-data" id="blogForm">
  <?= csrf_field() ?>
  <?php if ($isEdit): ?>
  <input type="hidden" name="id" value="<?= $blog['id'] ?>">
  <?php endif; ?>

  <div class="row g-4">

    <!-- Kiri: Konten utama -->
    <div class="col-lg-8">
      <div class="admin-table p-4">

        <!-- Judul -->
        <div class="mb-3">
          <label class="form-label-mentality">
            Judul Artikel <span class="text-danger">*</span>
          </label>
          <input type="text" name="judul" class="form-control form-control-mentality"
            placeholder="Tulis judul artikel yang menarik..."
            value="<?= esc($blog['judul'] ?? '') ?>" required>
        </div>

        <!-- Ringkasan -->
        <div class="mb-3">
          <label class="form-label-mentality">Ringkasan</label>
          <textarea name="ringkasan" class="form-control form-control-mentality" rows="2"
            placeholder="Ringkasan singkat untuk kartu blog (maks ~150 karakter)..."><?= esc($blog['ringkasan'] ?? '') ?></textarea>
        </div>

        <!-- Konten dengan CKEditor -->
        <div class="mb-1">
          <label class="form-label-mentality">
            Isi Artikel <span class="text-danger">*</span>
          </label>
          <div class="form-text mb-2">
            <i class="bi bi-magic me-1 text-green-main"></i>
            Ketik langsung — bold, italic, heading, list, tabel — semua bisa tanpa kode!
          </div>

          <!-- CKEditor akan muncul di sini -->
          <div id="kontenEditor"><?= $blog['konten'] ?? '' ?></div>

          <!-- Hidden textarea untuk simpan konten -->
          <textarea name="konten" id="kontenHidden" style="display:none"><?= $blog['konten'] ?? '' ?></textarea>
        </div>

      </div>
    </div>

    <!-- Kanan: Pengaturan & Gambar -->
    <div class="col-lg-4">

      <!-- Pengaturan -->
      <div class="admin-table p-4 mb-4">
        <h6 class="fw-bold mb-3"><i class="bi bi-gear me-2"></i>Pengaturan</h6>

        <div class="mb-3">
          <label class="form-label-mentality">Kategori</label>
          <select name="kategori" class="form-select form-control-mentality">
            <?php foreach(['Stres','Kecemasan','Depresi','Trauma','Tips','Umum'] as $k): ?>
            <option value="<?= $k ?>"
              <?= ($blog['kategori'] ?? 'Umum') === $k ? 'selected' : '' ?>>
              <?= $k ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-4">
          <label class="form-label-mentality">Status</label>
          <select name="published" class="form-select form-control-mentality">
            <option value="1" <?= ($blog['published'] ?? 1) == 1 ? 'selected' : '' ?>>✅ Terbit</option>
            <option value="0" <?= ($blog['published'] ?? 1) == 0 ? 'selected' : '' ?>>📝 Draft</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary-custom w-100">
          <i class="bi bi-save me-2"></i>
          <?= $isEdit ? 'Simpan Perubahan' : 'Publikasikan' ?>
        </button>
      </div>

      <!-- Upload Gambar -->
      <div class="admin-table p-4">
        <h6 class="fw-bold mb-3"><i class="bi bi-image me-2"></i>Gambar Sampul</h6>

        <!-- Preview gambar -->
        <div id="imagePreviewWrap"
          style="<?= ($isEdit && !empty($blog['gambar'])) ? '' : 'display:none' ?>">
          <div class="position-relative mb-3" style="border-radius:10px;overflow:hidden">
            <img id="imagePreview"
              src="<?= ($isEdit && !empty($blog['gambar'])) ? $blog['gambar'] : '' ?>"              alt="Preview"
              style="width:100%;height:160px;object-fit:cover;display:block">
            <button type="button" onclick="removeImage()"
              class="btn btn-sm position-absolute"
              style="top:8px;right:8px;background:rgba(0,0,0,.6);color:white;border:none;border-radius:6px;padding:.2rem .5rem">
              <i class="bi bi-x-lg"></i>
            </button>
          </div>
          <input type="hidden" name="hapus_gambar" id="hapusGambarInput" value="0">
          <button type="button" onclick="document.getElementById('gambarInput').click()"
            class="btn btn-sm btn-outline-green rounded-pill w-100">
            <i class="bi bi-arrow-repeat me-1"></i>Ganti Gambar
          </button>
        </div>

        <!-- Area upload -->
        <div id="uploadArea"
          style="<?= ($isEdit && !empty($blog['gambar'])) ? 'display:none' : '' ?>;border:2px dashed #d1d5db;border-radius:10px;padding:1.5rem;text-align:center;cursor:pointer;transition:all .2s"
          onclick="document.getElementById('gambarInput').click()"
          ondragover="handleDragOver(event)"
          ondragleave="handleDragLeave(event)"
          ondrop="handleDrop(event)">
          <i class="bi bi-cloud-upload" style="font-size:2rem;color:#9ca3af"></i>
          <p class="text-muted small mb-1 mt-2">Klik atau drag & drop</p>
          <p class="text-muted mb-0" style="font-size:.72rem">JPG, PNG, WebP — Maks. 2MB</p>
        </div>

        <input type="file" name="gambar" id="gambarInput"
          accept="image/jpeg,image/jpg,image/png,image/webp"
          style="display:none" onchange="previewImage(this)">

        <!-- Ikon default -->
        <div class="mt-3 p-2 rounded-3 text-center" style="background:#f8fafc">
          <p class="text-muted mb-1" style="font-size:.72rem">Ikon default jika tanpa gambar:</p>
          <i class="bi <?= $icons[$blog['kategori'] ?? 'Umum'] ?? 'bi-journal-text' ?>"
            style="font-size:1.8rem;color:var(--green-main)"></i>
        </div>
      </div>

    </div>
  </div>
</form>

<script>
const { ClassicEditor, Essentials, Bold, Italic, Underline, Strikethrough,
        Paragraph, Heading, BlockQuote, List, Link, Table, TableToolbar,
        Alignment, Indent, IndentBlock, HorizontalLine, Undo } = CKEDITOR;

// Inisialisasi CKEditor 5
ClassicEditor.create(document.getElementById('kontenEditor'), {
  licenseKey : 'GPL',
  plugins    : [
    Essentials, Bold, Italic, Underline, Strikethrough,
    Paragraph, Heading, BlockQuote, List, Link,
    Table, TableToolbar, Alignment, Indent, IndentBlock,
    HorizontalLine, Undo,
  ],
  toolbar: {
    items: [
      'undo', 'redo', '|',
      'heading', '|',
      'bold', 'italic', 'underline', 'strikethrough', '|',
      'alignment', '|',
      'bulletedList', 'numberedList', 'outdent', 'indent', '|',
      'blockQuote', 'insertTable', 'horizontalLine', '|',
      'link',
    ],
  },
  heading: {
    options: [
      { model: 'paragraph',  title: 'Paragraf',  class: 'ck-heading_paragraph' },
      { model: 'heading2',   view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
      { model: 'heading3',   view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
      { model: 'heading4',   view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
    ],
  },
  table: {
    contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells'],
  },
  language: 'id',
  placeholder: 'Mulai tulis artikel di sini...',
}).then(editor => {
  // Sync konten ke hidden textarea saat form submit
  document.getElementById('blogForm').addEventListener('submit', function() {
    document.getElementById('kontenHidden').value = editor.getData();
  });

  // Auto-sync saat ada perubahan (backup)
  editor.model.document.on('change:data', () => {
    document.getElementById('kontenHidden').value = editor.getData();
  });

}).catch(err => {
  console.error('CKEditor error:', err);
});

// ── Upload gambar ─────────────────────────────────────────────
function previewImage(input) {
  if (!input.files || !input.files[0]) return;
  const file = input.files[0];

  if (file.size > 2 * 1024 * 1024) {
    alert('Ukuran gambar maksimal 2MB!');
    input.value = '';
    return;
  }

  const reader = new FileReader();
  reader.onload = function(e) {
    document.getElementById('imagePreview').src               = e.target.result;
    document.getElementById('imagePreviewWrap').style.display = 'block';
    document.getElementById('uploadArea').style.display       = 'none';
    document.getElementById('hapusGambarInput').value         = '0';
  };
  reader.readAsDataURL(file);
}

function removeImage() {
  document.getElementById('imagePreview').src               = '';
  document.getElementById('imagePreviewWrap').style.display = 'none';
  document.getElementById('uploadArea').style.display       = 'block';
  document.getElementById('gambarInput').value              = '';
  document.getElementById('hapusGambarInput').value         = '1';
}

function handleDragOver(e) {
  e.preventDefault();
  e.currentTarget.style.borderColor = 'var(--green-main)';
  e.currentTarget.style.background  = 'var(--green-pale)';
}

function handleDragLeave(e) {
  e.currentTarget.style.borderColor = '#d1d5db';
  e.currentTarget.style.background  = '';
}

function handleDrop(e) {
  e.preventDefault();
  handleDragLeave(e);
  const file = e.dataTransfer.files[0];
  if (file && file.type.startsWith('image/')) {
    const dt    = new DataTransfer();
    dt.items.add(file);
    const input = document.getElementById('gambarInput');
    input.files = dt.files;
    previewImage(input);
  }
}
</script>