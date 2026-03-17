-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Mar 2026 pada 08.37
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mentality_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL COMMENT 'Nama lengkap admin',
  `email` varchar(150) NOT NULL COMMENT 'Email login admin',
  `password` varchar(255) NOT NULL COMMENT 'Password terenkripsi bcrypt',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Akun administrator';

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `nama`, `email`, `password`, `created_at`) VALUES
(1, 'Super Admin', 'admin@mentality.id', '$2y$12$eImiTXuWVxfM37uY4JANjOe5XscKhW2tMQHNQBCJa/Oa9A.R7Jhe2', '2026-03-17 14:33:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `blogs`
--

CREATE TABLE `blogs` (
  `id` int(10) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL COMMENT 'Judul artikel',
  `slug` varchar(255) NOT NULL COMMENT 'URL-friendly versi judul',
  `ringkasan` text DEFAULT NULL COMMENT 'Ringkasan singkat artikel',
  `konten` longtext NOT NULL COMMENT 'Isi lengkap artikel (HTML)',
  `gambar` varchar(255) DEFAULT NULL COMMENT 'Nama file gambar sampul',
  `kategori` varchar(80) NOT NULL DEFAULT 'Umum' COMMENT 'Kategori artikel',
  `published` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = Terbit, 0 = Draft',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Artikel blog kesehatan mental';

--
-- Dumping data untuk tabel `blogs`
--

INSERT INTO `blogs` (`id`, `judul`, `slug`, `ringkasan`, `konten`, `gambar`, `kategori`, `published`, `created_at`, `updated_at`) VALUES
(1, 'Mengenal Stres dan Cara Mengatasinya', 'mengenal-stres-cara-mengatasinya', 'Stres adalah respons alami tubuh terhadap tekanan. Pelajari cara mengelolanya dengan efektif.', '<p>Stres merupakan bagian normal dari kehidupan. Namun ketika tidak dikelola dengan baik, stres dapat berdampak negatif pada kesehatan fisik dan mental. Penting bagi mahasiswa untuk mengenali tanda-tanda stres dan mengetahui cara mengatasinya secara sehat.</p><p>Beberapa cara efektif mengelola stres antara lain: olahraga rutin, tidur cukup, berbicara dengan orang yang dipercaya, serta melakukan aktivitas yang menyenangkan.</p>', NULL, 'Stres', 1, '2026-03-17 14:33:29', NULL),
(2, 'Kecemasan: Gejala, Penyebab, dan Penanganannya', 'kecemasan-gejala-penyebab-penanganan', 'Gangguan kecemasan adalah salah satu masalah kesehatan mental paling umum di kalangan mahasiswa.', '<p>Kecemasan adalah perasaan khawatir, gugup, atau takut yang intens terhadap situasi sehari-hari. Pada tingkat tertentu, kecemasan adalah normal dan bahkan membantu. Namun kecemasan berlebihan dapat mengganggu kehidupan sehari-hari.</p><p>Gejala umum kecemasan meliputi: jantung berdebar, sulit berkonsentrasi, mudah lelah, dan gangguan tidur. Penanganannya bisa melalui terapi kognitif, meditasi, atau konsultasi dengan profesional.</p>', NULL, 'Kecemasan', 1, '2026-03-17 14:33:29', NULL),
(3, 'Depresi Bukan Kelemahan: Pahami dan Lawan Bersama', 'depresi-bukan-kelemahan', 'Depresi adalah kondisi medis serius yang memengaruhi perasaan, pikiran, dan tindakan seseorang.', '<p>Banyak orang masih salah paham tentang depresi. Depresi bukan sekadar rasa sedih biasa, melainkan gangguan medis yang memerlukan perhatian dan penanganan yang tepat. Siapapun bisa mengalami depresi, tanpa memandang usia atau latar belakang.</p><p>Tanda-tanda depresi antara lain: perasaan sedih berkepanjangan, kehilangan minat, perubahan nafsu makan, dan pikiran negatif. Jangan ragu mencari bantuan profesional jika kamu merasakannya.</p>', NULL, 'Depresi', 1, '2026-03-17 14:33:29', NULL),
(4, 'Tips Menjaga Kesehatan Mental di Tengah Kesibukan Kuliah', 'tips-kesehatan-mental-kuliah', 'Kuliah bisa sangat melelahkan. Berikut beberapa cara praktis menjaga kesehatan mentalmu.', '<p>Dunia perkuliahan penuh dengan tantangan: tugas menumpuk, ujian, tekanan sosial, dan ekspektasi keluarga. Tidak heran banyak mahasiswa yang mengalami burnout atau kelelahan mental.</p><p>Tips praktis: atur jadwal belajar dengan istirahat yang cukup, jangan takut minta tolong, prioritaskan kegiatan yang memberi energi positif, dan tetap terhubung dengan teman serta keluarga.</p>', NULL, 'Tips', 1, '2026-03-17 14:33:29', NULL),
(5, 'Trauma dan PTSD: Ketika Luka Masa Lalu Menghantui', 'trauma-ptsd-luka-masa-lalu', 'Trauma psikologis bisa berdampak jangka panjang. Kenali tanda-tandanya dan cara penyembuhannya.', '<p>Trauma adalah respons emosional terhadap kejadian yang sangat menyakitkan atau mengancam jiwa. PTSD (Post-Traumatic Stress Disorder) bisa muncul setelah seseorang mengalami atau menyaksikan peristiwa traumatis.</p><p>Gejala PTSD meliputi: kilas balik, mimpi buruk, menghindari pengingat trauma, dan mudah terkejut. Dengan terapi yang tepat seperti EMDR atau CBT, pemulihan dari trauma sangat mungkin dicapai.</p>', NULL, 'Trauma', 1, '2026-03-17 14:33:29', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `session_id` int(10) UNSIGNED NOT NULL COMMENT 'Referensi ke tabel chat_sessions',
  `role` enum('user','assistant') NOT NULL COMMENT 'user = mahasiswa, assistant = AI',
  `content` text NOT NULL COMMENT 'Isi pesan',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Waktu pesan dikirim'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Riwayat pesan chatbot per sesi';

-- --------------------------------------------------------

--
-- Struktur dari tabel `chat_sessions`
--

CREATE TABLE `chat_sessions` (
  `id` int(10) UNSIGNED NOT NULL,
  `session_token` varchar(64) NOT NULL COMMENT 'Token unik sesi (64 karakter hex)',
  `mahasiswa_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'NULL jika guest belum mengisi form',
  `hasil_tes_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'Diisi jika sudah menyelesaikan tes',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Waktu sesi dimulai'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Sesi percakapan chatbot AI';

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_tes`
--

CREATE TABLE `hasil_tes` (
  `id` int(10) UNSIGNED NOT NULL,
  `mahasiswa_id` int(10) UNSIGNED NOT NULL COMMENT 'Referensi ke tabel mahasiswa',
  `skor_depresi` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Skor depresi (0-42)',
  `skor_kecemasan` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Skor kecemasan (0-42)',
  `skor_stres` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Skor stres (0-42)',
  `kategori_depresi` enum('Normal','Ringan','Sedang','Berat','Sangat Berat') NOT NULL COMMENT 'Kategori tingkat depresi',
  `kategori_kecemasan` enum('Normal','Ringan','Sedang','Berat','Sangat Berat') NOT NULL COMMENT 'Kategori tingkat kecemasan',
  `kategori_stres` enum('Normal','Ringan','Sedang','Berat','Sangat Berat') NOT NULL COMMENT 'Kategori tingkat stres',
  `jawaban_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Jawaban lengkap 21 soal dalam format JSON' CHECK (json_valid(`jawaban_json`)),
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Waktu pengerjaan tes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Hasil tes DASS-21 peserta';

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL COMMENT 'Nama lengkap peserta',
  `email` varchar(150) NOT NULL COMMENT 'Alamat email peserta',
  `nim` varchar(30) DEFAULT NULL COMMENT 'Nomor Induk Mahasiswa (opsional)',
  `universitas` varchar(150) DEFAULT NULL COMMENT 'Nama perguruan tinggi (opsional)',
  `jenis_kelamin` enum('L','P') NOT NULL COMMENT 'L = Laki-laki, P = Perempuan',
  `usia` tinyint(3) UNSIGNED NOT NULL COMMENT 'Usia dalam tahun',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Waktu pengisian data'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Data peserta tes kesehatan mental';

-- --------------------------------------------------------

--
-- Struktur dari tabel `security_logs`
--

CREATE TABLE `security_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL COMMENT 'Alamat IP pelaku',
  `user_agent` varchar(500) DEFAULT NULL COMMENT 'Browser/tools yang digunakan',
  `method` varchar(10) NOT NULL COMMENT 'HTTP method (GET/POST/dll)',
  `uri` varchar(500) NOT NULL COMMENT 'URL yang diserang',
  `threat_type` varchar(100) NOT NULL COMMENT 'Jenis ancaman: SQLi, XSS, dll',
  `payload` text DEFAULT NULL COMMENT 'Data berbahaya yang dikirim',
  `severity` enum('Low','Medium','High','Critical') NOT NULL DEFAULT 'Medium' COMMENT 'Tingkat bahaya',
  `notified` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = Sudah notif admin',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Waktu kejadian'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Log ancaman keamanan sistem';

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_email` (`email`);

--
-- Indeks untuk tabel `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_slug` (`slug`),
  ADD KEY `idx_published` (`published`),
  ADD KEY `idx_kategori` (`kategori`);

--
-- Indeks untuk tabel `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_session` (`session_id`);

--
-- Indeks untuk tabel `chat_sessions`
--
ALTER TABLE `chat_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_session_token` (`session_token`),
  ADD KEY `idx_mahasiswa_id` (`mahasiswa_id`),
  ADD KEY `idx_hasil_tes_id` (`hasil_tes_id`);

--
-- Indeks untuk tabel `hasil_tes`
--
ALTER TABLE `hasil_tes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_mahasiswa` (`mahasiswa_id`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_email` (`email`);

--
-- Indeks untuk tabel `security_logs`
--
ALTER TABLE `security_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_severity` (`severity`),
  ADD KEY `idx_ip` (`ip_address`),
  ADD KEY `idx_created` (`created_at`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `chat_sessions`
--
ALTER TABLE `chat_sessions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `hasil_tes`
--
ALTER TABLE `hasil_tes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `security_logs`
--
ALTER TABLE `security_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `fk_cm_session` FOREIGN KEY (`session_id`) REFERENCES `chat_sessions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `chat_sessions`
--
ALTER TABLE `chat_sessions`
  ADD CONSTRAINT `fk_cs_hasil` FOREIGN KEY (`hasil_tes_id`) REFERENCES `hasil_tes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cs_mahasiswa` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `hasil_tes`
--
ALTER TABLE `hasil_tes`
  ADD CONSTRAINT `fk_ht_mahasiswa` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
