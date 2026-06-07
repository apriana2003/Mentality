-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Jun 2026 pada 08.17
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.5.4

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
(1, 'Super Admin', 'admin@mentality', '$2y$10$T3FP6/ObmhNCudDo7yXkKOyfDU6Jhk0Kl1T0BxOetcYE6gWK9lfka', '2026-03-17 14:33:28');

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
(1, 'Mengenal Stres dan Cara Mengatasinya', 'mengenal-stres-cara-mengatasinya', 'Stres adalah sebuah kondisi yang dirasakan saat seseorang menghadapi tantangan, atau berada dalam situasi yang mengharuskan kita menyesuaikan diri secara cepat dengan sebuah perubahan. Ketika stres membuat kita menjadi lebih terpacu dan termotivasi, stres ini dinamakan eustress atau stress yang positif. Eustress bermanfaat dalam memacu kreativitas, menimbulkan inspirasi dan rasa bahagia, serta menyehatkan tubuh. Eustress diperlukan, misalnya untuk membantu kita menyelesaikan pekerjaan sebelum tenggat waktu yang diberikan, mengejar prestasi atau pencapaian dan lain sebagainya. ', '<h2 style=\"text-align:justify;\"><strong>Jenis Stres</strong></h2><p style=\"margin-left:0px;text-align:justify;\">Stres negatif atau distress terbagi menjadi 2 jenis berdasarkan lama berlangsungnya, yaitu stres akut dan stres kronis.</p><ol><li><h3><strong>Stres Akut</strong></h3><p>Stres akut terjadi ketika kita dihadapkan pada situasi yang mendesak atau membahayakan, seperti berada di jalan yang sangat macet dan berpotensi membuat kita terlambat, atau melihat orang menyeberang jalan, sehingga harus menginjak rem dengan cepat. Stres jenis ini biasanya berlangsung dalam jangka pendek, mudah ditangani, dan akan mereda dengan sendirinya jika pemicu stres sudah hilang.</p></li><li><h3><strong>Stres Kronis</strong></h3><p>Stres kronis berlangsung lebih lama, hingga berminggu-minggu bahkan berbulan-bulan. Contohnya, menghadapi masalah keuangan, konflik dalam rumah tangga atau tempat kerja. Seringkali orang tidak menganggap jenis stres ini serius, bahkan menjadi terbiasa. Namun, jika tidak dituntaskan, stres kronis dapat menimbulkan berbagai gangguan kesehatan, baik fisik maupun emosional.<br>&nbsp;</p></li></ol><h2 style=\"text-align:justify;\"><strong>Gejala-Gejala Stres</strong></h2><p style=\"margin-left:0px;text-align:justify;\">Penyebab stres bisa berasal dari diri sendiri maupun faktor lingkungan. Saat mengalami stres, tubuh akan mengeluarkan <a href=\"https://www.healthline.com/health/stress#cortisol\">hormon</a> kortisol dan adrenalin, yang memicu reaksi dalam tubuh seperti jantung berdetak lebih cepat, otot menegang, napas lebih cepat, tekanan darah dan sinyal kewaspadaan meningkat.</p><p style=\"margin-left:0px;text-align:justify;\">Berikut adalah ciri-ciri orang yang mengalami stres, dibagi berdasarkan gejala-gejalanya, yaitu</p><h3><strong>1. Gejala Psikis</strong></h3><ul><li><p style=\"margin-left:0px;\">Mudah merasa frustasi dan marah</p></li><li><p style=\"margin-left:0px;\">Suasana hati berubah-ubah.</p></li><li><p style=\"margin-left:0px;\">Merasa bingung dan tidak berguna.</p></li><li><p style=\"margin-left:0px;\">Pikiran dan perasaan tidak tenang.</p></li><li><p style=\"margin-left:0px;\">Menghindar dari orang lain.</p></li><li><p style=\"margin-left:0px;\">Depresi.</p><p style=\"margin-left:0px;\">&nbsp;</p></li></ul><h3><strong>2. Gejala Fisik</strong></h3><ul><li><p style=\"margin-left:0px;\">Pusing dan mual.</p></li><li><p style=\"margin-left:0px;\">Lemas.</p></li><li><p style=\"margin-left:0px;\">Diare atau sembelit.</p></li><li><p style=\"margin-left:0px;\">Gangguan tidur atau tidak bisa tidur (insomnia).</p></li><li><p style=\"margin-left:0px;\">Gangguan pencernaan, seperti masalah gastritis, usus besar dan GERD.</p></li><li><p style=\"margin-left:0px;\">Obesitas dan penyakit kardiovaskular.</p></li><li><p style=\"margin-left:0px;\">Perubahan berat badan.&nbsp;</p></li><li><p style=\"margin-left:0px;\">Berkeringat.</p></li><li><p style=\"margin-left:0px;\">Gairah dan kemampuan seksual menurun.</p></li><li><p style=\"margin-left:0px;\">Mulut kering dan sulit menelan.</p></li><li><p style=\"margin-left:0px;\">Telinga sering berdenging.</p></li><li><p style=\"margin-left:0px;\">Tubuh gemetar dan jantung berdebar.</p></li></ul><p style=\"margin-left:0px;text-align:justify;\">&nbsp;</p><h3 style=\"text-align:justify;\"><strong>3. Gejala Kognitif</strong></h3><ul><li><p style=\"margin-left:0px;\">Kesulitan untuk fokus.</p></li><li><p style=\"margin-left:0px;\">Mudah lupa.</p></li><li><p style=\"margin-left:0px;\">Pesimis dan berpikiran negatif.</p></li><li><p style=\"margin-left:0px;\">Kesulitan dalam mengambil keputusan.</p><p style=\"margin-left:0px;\">&nbsp;</p></li></ul><h3 style=\"text-align:justify;\"><strong>4. Gejala Perilaku</strong></h3><ul><li><p style=\"margin-left:0px;\">Cenderung menghindar dari tanggung jawab.</p></li><li><p style=\"margin-left:0px;\">Gugup atau resah.</p></li><li><p style=\"margin-left:0px;\">Kecanduan merokok atau minuman beralkohol.</p><p style=\"margin-left:0px;\">Segera kunjungi fasilitas pelayanan kesehatan untuk meminta bantuan dokter, psikiater atau tenaga kesehatan, jika mengalami atau menemui gejala-gejala berikut ini.</p></li><li><p style=\"margin-left:0px;\">Tidak bisa mengendalikan rasa takut dan panik.</p></li><li><p style=\"margin-left:0px;\">Tidak mampu beraktivitas sehari-hari.</p></li><li><p style=\"margin-left:0px;\">Sulit melupakan trauma.</p></li><li><p style=\"margin-left:0px;\">Sering merasa pusing dan detak jantung meningkat.</p></li><li><p style=\"margin-left:0px;\">Sulit tidur dan mengalami insomnia.</p></li><li><p style=\"margin-left:0px;\">Berpikir untuk mengakhiri hidup.</p></li></ul><h2 style=\"text-align:justify;\"><strong>Penyebab Stres</strong></h2><p style=\"margin-left:0px;text-align:justify;\">Stres bisa terjadi pada siapa saja dan penyebabnya juga bisa bermacam-macam, seperti</p><ol><li><h3><strong>Beban Kerja</strong></h3><p>Beban kerja yang tidak realistis, tuntutan tinggi di tempat kerja disertai kurangnya kendali terhadap pekerjaan dan kurangnya keseimbangan antara pekerjaan dan kehidupan pribadi dapat memicu timbulnya stres.</p></li><li><h3><strong>Krisis Ekonomi</strong></h3><p>Masalah keuangan atau hutang yang menumpuk dapat menimbulkan kecemasan dan tekanan dalam diri seseorang.</p></li><li><h3><strong>Peristiwa Buruk</strong></h3><p>Peristiwa buruk yang dialami seperti kehilangan pekerjaan, perceraian, kematian orang yang dicintai dan sejenisnya dapat menimbulkan distres.</p></li><li><h3>Penyakit Kronis</h3><p>Mengidap penyakit atau gangguan kesehatan kronis serta cedera, yang bersifat jangka panjang, dapat menjadi sumber stres.</p></li><li><h3>Ketidakpastian</h3><p>Kekhawatiran dan rasa tidak aman terhadap masa depan, pendidikan atau karir dapat menciptakan ketegangan emosional.</p></li><li><h3><strong>Lingkungan Tidak Aman</strong></h3><p>Kondisi lingkungan yang tidak aman dan tidak stabil, seperti area konflik, peperangan dan kerusuhan, atau mengalami bencana alam, dapat menimbulkan stres dan ketidaknyamanan.<br><br>&nbsp;</p></li></ol><h2 style=\"text-align:justify;\"><strong>Faktor Risiko Stres</strong></h2><p style=\"margin-left:0px;text-align:justify;\">Pada kebanyakan orang, stres akan mereda dengan sendirinya jika situasi yang dialami membaik, atau jika kita sudah bisa beradaptasi dengan situasi yang menimbulkan stres. Meski demikian, ada kelompok orang-orang yang lebih rentan mengalami stres, yaitu orang-orang yang</p><p style=\"margin-left:0px;text-align:justify;\">&nbsp;</p><ul><li><p style=\"margin-left:0px;\">Tidak bisa tidur atau mengalami gangguan tidur.</p></li><li><p style=\"margin-left:0px;\">Asupan nutrisinya tidak cukup atau tidak sesuai dengan kebutuhan.</p></li><li><p style=\"margin-left:0px;\">Kondisi kesehatan fisik dan mentalnya tidak baik.&nbsp;</p></li><li><p style=\"margin-left:0px;\">Memiliki trauma pada masa lalu.</p></li><li><p style=\"margin-left:0px;\">Memiliki riwayat gangguan kesehatan mental.&nbsp;</p><p style=\"margin-left:0px;\">&nbsp;</p></li></ul><h2 style=\"text-align:justify;\"><strong>Kelola Stres dengan Baik</strong></h2><p style=\"margin-left:0px;text-align:justify;\">Stres tidak dapat dihilangkan, tapi bisa diredakan. Cara meredakan stres yang paling efektif adalah mengelolanya dengan baik. Berikut adalah langkah-langkah yang bisa Anda lakukan untuk mengelola stres.&nbsp;</p><ol><li><h3><strong>Konseling atau Curhat</strong></h3><p>Ungkapkan beban pikiran dan perasaan Anda kepada orang terdekat atau orang yang Anda percaya. Anda pun bisa melakukan konseling dan meminta bantuan kepada tenaga kesehatan dan psikiater.</p></li><li><h3><strong>Mengonsumsi Makanan Sehat</strong></h3><p>Cara lain meredakan stres adalah dengan menjaga kesehatan dan mencukupi kebutuhan nutrisi dengan makanan bergizi. Hindari makanan dan minuman yang dapat memicu stres, seperti alkohol, gula, makanan dan minuman yang tinggi kadar garam dan kafein.<br>Perbanyak ikan, buah-buahan, sayuran, biji-bijian dan kacang-kacangan, khususnya yang kaya akan vitamin B dan magnesium, yang berperan dalam mengatur suasana hati.</p></li><li><h3><strong>Berolahraga dan Beraktivitas Fisik</strong></h3><p>Saat berolahraga dan bergerak, tubuh mengeluarkan hormon endorfin yang dapat membuat tubuh lebih rileks dan membuat suasana hati lebih baik. Berolahraga juga dapat mengalihkan pikiran Anda dari hal-hal yang selama ini mengganggu.<br>Lakukan olahraga atau aktivitas fisik secara rutin minimal 30 menit selama 5 kali dalam seminggu. Beberapa jenis olahraga yang bisa dilakukan antara lain jalan santai, jogging, bersepeda, atau berenang. Anda pun bisa melakukan kegiatan rumah tangga, seperti membersihkan rumah atau berkebun.</p></li><li><h3><strong>Lakukan Kegiatan yang Anda Minati</strong></h3><p>Melakukan kegiatan menyenangkan sesuai hobi, seperti membaca buku, memasak, bermain musik, melukis, menyanyi dan menari, atau bermain dengan binatang peliharaan dapat memicu keluarnya hormon dopamin. Hormon dopamin adalah hormon bahagia yang dapat membuat tubuh lebih rileks dan pikiran tenang.</p></li><li><h3><strong>Berpikir Positif dan Tenang</strong></h3><p>Selalu berusaha dan mencoba mencari hal-hal positif dari kejadian atau tantangan yang Anda alami. Meditasi dapat membantu Anda untuk fokus pada pikiran positif dan menenangkan diri. Saat melakukan meditasi, hormon kortisol dalam tubuh akan menurun, sehingga Anda menjadi lebih rileks dan tenang.</p></li><li><h3><strong>Tidur Cukup</strong></h3><p>Kurangnya waktu dan kualitas tidur dapat menurunkan suasana hati, energi dan konsentrasi. Saat tidur otak dan tubuh beristirahat. Buatlah rutinitas tidur yang baik, seperti meredupkan lampu, menghindari pemakaian gadget minimal satu jam sebelum tidur, dan tidur pada waktu yang sama secara konsisten. Anda pun dapat memasang aromaterapi dengan aroma menenangkan untuk membantu Anda terlelap.<br>Segera ke fasilitas pelayanan kesehatan untuk konsultasi jika Anda mengalami kesulitan tidur atau penurunan kualitas tidur.</p></li><li><h3><strong>Beribadah dan Mendekatkan Diri pada Tuhan</strong></h3><p>Meningkatkan ibadah dan mendekatkan diri pada Yang Maha Kuasa diyakini bisa meningkatkan keimanan, serta membantu Anda lebih tenang dan tabah, jauh dari pikiran-pikiran negatif.</p></li></ol><h2 style=\"text-align:justify;\"><strong>Diagnosis Stres</strong></h2><p style=\"margin-left:0px;text-align:justify;\">Diagnosis stres dilakukan dengan menggunakan kuesioner The Perceived Stress Scale (PSS-10), sebuah alat tes psikologi yang bertujuan untuk menentukan tingkat stres yang dialami penderita. Dokter juga akan melakukan tanya jawab dengan penderita tentang penyebab stres yang dialaminya.</p><p style=\"margin-left:0px;text-align:justify;\">&nbsp;</p><p style=\"margin-left:0px;text-align:justify;\">Setelah mendapatkan hasil dari kuesioner dan tanya jawab, dokter akan menentukan apakah stres yang dialami stres akut atau kronis. Jika stres menimbulkan gangguan kesehatan lainnya, dokter akan melakukan pemeriksaan penunjang, seperti tes darah, MRI dan CT Scan.</p><p style=\"margin-left:0px;text-align:justify;\">&nbsp;</p><h2 style=\"text-align:justify;\"><strong>Pengobatan Stres</strong></h2><p style=\"margin-left:0px;text-align:justify;\">Mengelola stress bertujuan untuk membantu kita menjalani kehidupan sehari-hari tanpa kendala, bukan untuk mengobati stres. Adapun pengobatan stres bisa dilakukan dengan langkah-langkah berikut ini.</p><ol><li><h3><strong>Menemukan penyebabnya</strong></h3><p>Mengetahui faktor pemicu stres bisa menjadi langkah pertama untuk menuntaskannya. Misalnya, konflik dalam rumah tangga, masalah dalam pekerjaan atau masalah keuangan.</p></li><li><h3><strong>Menemukan solusinya</strong></h3><p>Jika sudah menemukan penyebabnya, Anda tinggal mencari solusi pemecahan masalahnya. Mulailah dengan solusi yang paling mudah dilaksanakan dan susun rencana selanjutnya. Misalnya, jika penyebabnya adalah kurang tidur, perbaikilah kualitas dan rutinitas tidur Anda, atau lakukan relaksasi dan meditasi untuk menenangkan pikiran.</p></li><li><h3><strong>Konsultasi dengan Tenaga Profesional</strong></h3><p>Jika Anda tidak dapat menemukan penyebab stres dan solusinya, mintalah bantuan tenaga profesional, seperti dokter atau psikiater. Dokter atau psikiater dapat meresepkan obat jika dibutuhkan, atau melakukan terapi perilaku kognitif (CBT) dengan psikolog klinis atau perawat jiwa.</p></li></ol><p style=\"margin-left:0px;text-align:justify;\">&nbsp;</p><p style=\"margin-left:0px;text-align:justify;\">Dengan mengetahui apa itu stres dan cara-cara menanganinya di atas, diharapkan dapat memberikan dorongan kepada Anda untuk mau mengatasi stres dengan melakukan hal-hal positif, serta menghindari tindakan-tindakan yang mengarah ke perilaku negatif yang kurang sehat.</p><p style=\"margin-left:0px;text-align:justify;\">Tetap terapkan perilaku hidup bersih dan sehat, serta segera melakukan pemeriksaan ke dokter atau psikiater jika membutuhkan bantuan dalam mengatasi stres.</p><p style=\"margin-left:0px;text-align:justify;\">Link Artikel :</p><p style=\"margin-left:0px;text-align:justify;\"><a href=\"https://ayosehat.kemkes.go.id/apa-itu-stres\">https://ayosehat.kemkes.go.id/apa-itu-stres</a></p>', 'https://res.cloudinary.com/dftkqdftn/image/upload/v1780812696/mentality/blogs/rjkofqf5zdpkiyacchhh.png', 'Stres', 1, '2026-03-17 14:33:29', '2026-06-07 13:11:35'),
(2, 'Kecemasan: Gejala, Penyebab, dan Penanganannya', 'kecemasan-gejala-penyebab-penanganan', 'etiap orang bisa merasa cemas sesekali, tetapi orang dengan gangguan kecemasan sering mengalami rasa takut dan khawatir yang intens dan berlebihan. Perasaan ini biasanya disertai dengan ketegangan fisik dan gejala perilaku serta kognitif lainnya. Gangguan ini sulit dikendalikan, menyebabkan penderitaan yang signifikan, dan dapat berlangsung lama jika tidak diobati. Gangguan kecemasan mengganggu aktivitas sehari-hari dan dapat merusak kehidupan keluarga, sosial, sekolah, atau pekerjaan seseorang.', '<h2><strong>Gejala dan pola</strong></h2><p>Orang dengan gangguan kecemasan mungkin mengalami rasa takut atau khawatir yang berlebihan tentang situasi tertentu (misalnya, serangan panik atau situasi sosial) atau, dalam kasus gangguan kecemasan umum, tentang berbagai situasi sehari-hari. Mereka biasanya mengalami gejala-gejala ini dalam jangka waktu yang lama – setidaknya beberapa bulan. Biasanya mereka menghindari situasi yang membuat mereka cemas.</p><p>Gejala lain dari gangguan kecemasan mungkin meliputi:</p><ul><li>kesulitan berkonsentrasi atau membuat keputusan</li><li>merasa mudah tersinggung, tegang, atau gelisah</li><li>mengalami mual atau gangguan perut</li><li>mengalami jantung berdebar-debar</li><li>berkeringat, gemetar atau menggigil</li><li>kesulitan tidur</li><li>memiliki firasat akan bahaya yang akan datang, kepanikan, atau malapetaka.</li></ul><p>Gangguan kecemasan meningkatkan risiko depresi dan gangguan penggunaan zat, serta risiko pikiran dan perilaku bunuh diri.</p><p>Ada beberapa jenis gangguan kecemasan yang berbeda, termasuk:</p><ul><li>gangguan kecemasan umum (kekhawatiran yang terus-menerus dan berlebihan tentang aktivitas atau peristiwa sehari-hari);</li><li>gangguan panik (serangan panik dan ketakutan akan serangan panik yang berkelanjutan);</li><li>gangguan kecemasan sosial (tingkat ketakutan dan kekhawatiran yang tinggi terhadap situasi sosial yang dapat membuat seseorang merasa terhina, malu, atau ditolak);</li><li>agorafobia (ketakutan, kekhawatiran, dan penghindaran berlebihan terhadap situasi yang dapat menyebabkan seseorang panik atau merasa terjebak, tidak berdaya, atau malu);</li><li>gangguan kecemasan perpisahan (ketakutan atau kekhawatiran berlebihan tentang dipisahkan dari orang-orang yang memiliki ikatan emosional yang mendalam);</li><li>fobia spesifik (ketakutan intens dan irasional terhadap objek atau situasi tertentu yang menyebabkan perilaku menghindar dan penderitaan yang signifikan); dan</li><li>Mutisme selektif (ketidakmampuan berbicara secara konsisten dalam situasi sosial tertentu, meskipun mampu berbicara dengan nyaman dalam situasi lain, terutama memengaruhi anak-anak).</li></ul><p>Seseorang mungkin mengalami lebih dari satu gangguan kecemasan secara bersamaan. Gejala sering dimulai pada masa kanak-kanak atau remaja dan berlanjut hingga dewasa. Anak perempuan dan wanita lebih cenderung mengalami gangguan kecemasan daripada anak laki-laki dan pria.</p><h2><strong>Faktor-faktor penyebab dan pencegahan</strong></h2><p>Gangguan kecemasan, seperti kondisi kesehatan mental lainnya, timbul dari interaksi kompleks faktor sosial, psikologis, dan biologis. Siapa pun dapat mengalami gangguan kecemasan, tetapi orang yang pernah mengalami pelecehan, kehilangan yang parah, atau pengalaman buruk lainnya lebih mungkin mengembangkannya.</p><p>Gangguan kecemasan sangat berkaitan dengan dan dipengaruhi oleh kesehatan fisik. Banyak dampak kecemasan (seperti ketegangan fisik, hiperaktivitas sistem saraf, atau penggunaan alkohol yang berbahaya) juga merupakan faktor risiko yang diketahui untuk penyakit seperti penyakit kardiovaskular. Pada gilirannya, orang dengan penyakit-penyakit ini mungkin juga mengalami gangguan kecemasan karena kesulitan yang terkait dengan pengelolaan kondisi mereka.</p><p>Pendekatan berbasis komunitas yang efektif untuk mencegah kecemasan meliputi pendidikan orang tua dan program berbasis sekolah untuk meningkatkan pembelajaran sosial dan emosional serta membangun kemampuan mengatasi masalah yang positif pada anak-anak dan remaja. Program olahraga juga dapat efektif dalam mencegah gangguan kecemasan pada orang dewasa.</p><h2><strong>Diagnosis dan pengobatan</strong></h2><p>Terdapat beberapa pengobatan efektif untuk gangguan kecemasan. Orang yang mengalami gejala kecemasan sebaiknya mencari pertolongan.</p><p>Intervensi psikologis merupakan pengobatan penting untuk gangguan kecemasan dan terutama merujuk pada terapi bicara dengan profesional atau terapis awam yang diawasi. Intervensi ini dapat membantu orang mempelajari cara berpikir, mengatasi, atau berhubungan baru dengan kecemasan mereka, orang lain, atau dunia. Intervensi ini dapat mengajarkan orang bagaimana menghadapi situasi, peristiwa, orang, atau tempat yang memicu kecemasan mereka.</p><p>Intervensi psikologis dapat diberikan kepada individu atau kelompok, secara langsung atau daring. Intervensi ini juga dapat diakses melalui buku panduan swadaya, situs web, dan aplikasi. Intervensi psikologis yang paling banyak didukung bukti untuk mengobati berbagai gangguan kecemasan adalah intervensi yang didasarkan pada prinsip-prinsip terapi kognitif-perilaku. Ini termasuk terapi paparan, di mana orang belajar untuk menghadapi ketakutan mereka.</p><p>Selain itu, mempelajari keterampilan manajemen stres, seperti keterampilan relaksasi dan keterampilan kesadaran diri (mindfulness), dapat membantu mengurangi gejala gangguan kecemasan.</p><p>Obat antidepresan, seperti selective serotonin reuptake inhibitors (SSRIs), juga dapat bermanfaat dalam mengobati orang dewasa dengan gangguan kecemasan. Penyedia layanan kesehatan harus mempertimbangkan kemungkinan efek samping yang terkait dengan obat antidepresan, kemampuan untuk memberikan intervensi (dalam hal keahlian, dan/atau ketersediaan pengobatan), dan preferensi individu.</p><p>Benzodiazepin, yang secara historis diresepkan untuk gangguan kecemasan, umumnya tidak direkomendasikan untuk gangguan kecemasan karena potensi ketergantungannya yang tinggi serta efektivitas jangka panjangnya yang terbatas.</p><h2><strong>Perawatan diri</strong></h2><p>Perawatan diri dapat memainkan peran penting dalam mendukung pengobatan. Untuk membantu mengelola gejala kecemasan dan meningkatkan kesejahteraan Anda secara keseluruhan, Anda dapat:</p><ul><li>Hindari atau kurangi konsumsi alkohol dan jangan menggunakan narkoba ilegal, yang dapat memperburuk kecemasan;</li><li>Berolahragalah secara teratur, meskipun hanya berjalan kaki sebentar;</li><li>Usahakan untuk tetap menjaga kebiasaan makan dan tidur yang teratur sebisa mungkin dan mengonsumsi makanan sehat;</li><li>pelajari teknik relaksasi, seperti pernapasan lambat dan relaksasi otot progresif; dan</li><li>Kembangkan kebiasaan meditasi kesadaran, meskipun hanya beberapa menit per hari.</li></ul><h2><strong>Tanggapan WHO</strong></h2><p>Rencana Aksi Kesehatan Mental Komprehensif WHO 2013–2030 menyoroti langkah-langkah yang diperlukan untuk menyediakan intervensi yang tepat bagi orang-orang dengan kondisi kesehatan mental, termasuk gangguan kecemasan.&nbsp;</p><p>Gangguan kecemasan umum dan gangguan panik termasuk dalam kondisi prioritas yang dicakup oleh&nbsp; Program mhGAP WHO . Program ini bertujuan untuk membantu negara-negara meningkatkan layanan bagi orang-orang dengan gangguan mental, neurologis, dan penyalahgunaan zat melalui perawatan yang diberikan oleh petugas kesehatan yang bukan spesialis di bidang kesehatan mental.&nbsp;</p><p>WHO telah mengembangkan manual intervensi psikologis singkat yang dapat diberikan oleh terapis awam kepada individu dan kelompok. Intervensi ini telah terbukti efektif untuk berbagai masalah kesehatan mental, termasuk kecemasan dan depresi. Contohnya adalah&nbsp; manual Problem Management Plus (PM+) , yang didasarkan pada prinsip-prinsip terapi perilaku kognitif dan menggunakan teknik seperti manajemen stres, pengobatan pemecahan masalah, dan penguatan dukungan sosial. Selain itu, kursus manajemen stres berbasis kelompok Self-Help Plus (SH+) dan buku swadaya populer WHO, Doing What Matters in Times of Stress, menjelaskan keterampilan yang dapat digunakan untuk mengurangi kecemasan dan stres.</p><p>&nbsp;</p><p>Link artikel :</p><p><a href=\"https://www.who.int/news-room/fact-sheets/detail/anxiety-disorders\">https://www.who.int/news-room/fact-sheets/detail/anxiety-disorders</a></p>', 'https://res.cloudinary.com/dftkqdftn/image/upload/v1780812702/mentality/blogs/o6uwcdxto6kz8oaipqv8.png', 'Kecemasan', 1, '2026-03-17 14:33:29', '2026-06-07 13:11:42'),
(3, 'Depresi Bukan Kelemahan: Pahami dan Lawan Bersama', 'depresi-bukan-kelemahan', 'Gangguan depresi (juga dikenal sebagai depresi) adalah gangguan mental yang umum. Gangguan ini ditandai dengan suasana hati yang murung atau hilangnya kesenangan atau minat pada aktivitas dalam jangka waktu yang lama.', '<h2><strong>Fakta-fakta penting</strong></h2><ul><li>Depresi adalah gangguan mental yang umum terjadi.</li><li>Secara global, diperkirakan 5,7% orang dewasa menderita depresi.</li><li>Jumlah perempuan yang terkena depresi lebih banyak daripada laki-laki.</li><li>Depresi dapat menyebabkan bunuh diri.</li><li>Tersedia pengobatan yang efektif untuk depresi ringan, sedang, dan berat.</li></ul><hr><p><strong>Ringkasan</strong></p><p>Gangguan depresi (juga dikenal sebagai depresi) adalah gangguan mental yang umum. Gangguan ini ditandai dengan suasana hati yang murung atau hilangnya kesenangan atau minat pada aktivitas dalam jangka waktu yang lama.</p><p>Depresi berbeda dari perubahan suasana hati dan perasaan biasa tentang kehidupan sehari-hari. Depresi dapat memengaruhi semua aspek kehidupan, termasuk hubungan dengan keluarga, teman, dan masyarakat. Depresi dapat disebabkan oleh atau mengarah pada masalah di sekolah dan di tempat kerja.</p><p>Depresi dapat terjadi pada siapa saja. Orang yang pernah mengalami pelecehan, kehilangan yang berat, atau peristiwa stres lainnya lebih mungkin mengalami depresi. Wanita lebih mungkin mengalami depresi daripada pria.</p><p>Diperkirakan 4% populasi mengalami depresi, termasuk 5,7% orang dewasa (4,6% di antara pria dan 6,9% di antara wanita), dan 5,9% orang dewasa berusia 70 tahun ke atas. Sekitar 332 juta orang di dunia menderita depresi&nbsp; <i>(1)</i> . Depresi sekitar 1,5 kali lebih umum terjadi pada wanita daripada pada pria. Di seluruh dunia, lebih dari 10% wanita hamil dan wanita yang baru melahirkan mengalami depresi&nbsp; <i>(2)</i> . Pada tahun 2021, diperkirakan 727.000 orang meninggal karena bunuh diri. Bunuh diri adalah penyebab kematian ketiga terbesar pada usia 15–29 tahun.</p><p>Di negara-negara berpenghasilan tinggi, hanya sekitar sepertiga orang yang mengalami depresi menerima perawatan kesehatan mental&nbsp; <i>(3)</i> .&nbsp;</p><p>Hambatan terhadap perawatan yang efektif meliputi kurangnya investasi dalam perawatan kesehatan mental, kurangnya tenaga kesehatan terlatih, dan stigma sosial yang terkait dengan gangguan mental.</p><h2><strong>Gejala dan pola</strong></h2><p>Selama episode depresi, seseorang mengalami suasana hati yang terpuruk (merasa sedih, mudah tersinggung, hampa). Mereka mungkin merasa kehilangan kesenangan atau minat dalam berbagai aktivitas.</p><p>Episode depresi berbeda dari fluktuasi suasana hati biasa. Episode depresi berlangsung hampir sepanjang hari, hampir setiap hari, selama setidaknya dua minggu.</p><p>Gejala lain juga dapat muncul, yang mungkin meliputi:</p><ul><li>konsentrasi buruk</li><li>perasaan bersalah yang berlebihan atau rendah diri</li><li>keputusasaan tentang masa depan</li><li>pikiran tentang kematian atau bunuh diri</li><li>tidur terganggu</li><li>perubahan nafsu makan atau berat badan</li><li>merasa sangat lelah atau kekurangan energi.</li></ul><p>Depresi dapat menyebabkan kesulitan dalam semua aspek kehidupan, termasuk di masyarakat dan di rumah, pekerjaan, dan sekolah.</p><p>Episode depresi dapat dikategorikan sebagai ringan, sedang, atau berat tergantung pada jumlah dan tingkat keparahan gejala, serta dampaknya terhadap fungsi individu.&nbsp;</p><p>Terdapat berbagai pola episode depresi, termasuk:</p><ul><li>gangguan depresi episode tunggal, artinya episode pertama dan satu-satunya yang dialami orang tersebut;</li><li>gangguan depresi berulang, artinya orang tersebut memiliki riwayat setidaknya dua episode depresi; dan</li><li>Gangguan bipolar, yang berarti episode depresi bergantian dengan periode gejala manik, yang meliputi euforia atau iritabilitas, peningkatan aktivitas atau energi, dan gejala lain seperti peningkatan banyak bicara, pikiran yang berpacu, peningkatan harga diri, penurunan kebutuhan tidur, mudah teralihkan, dan perilaku impulsif yang sembrono.&nbsp;&nbsp;</li></ul><h2><strong>Faktor-faktor penyebab dan pencegahan</strong></h2><p>Depresi timbul dari interaksi kompleks faktor sosial, psikologis, dan biologis. Orang yang telah mengalami peristiwa kehidupan yang buruk (pengangguran, kehilangan orang terkasih, peristiwa traumatis) lebih cenderung mengalami depresi. Depresi, pada gilirannya, dapat menyebabkan lebih banyak stres dan disfungsi serta memperburuk situasi kehidupan orang yang terkena dampak dan depresi itu sendiri.</p><p>Depresi sangat berkaitan dengan dan dipengaruhi oleh kesehatan fisik. Banyak faktor yang memengaruhi depresi (seperti kurangnya aktivitas fisik atau penggunaan alkohol yang berbahaya) juga merupakan faktor risiko yang diketahui untuk penyakit seperti penyakit kardiovaskular, kanker, diabetes, dan penyakit pernapasan. Pada gilirannya, orang dengan penyakit-penyakit ini mungkin juga mengalami depresi karena kesulitan yang terkait dengan pengelolaan kondisi mereka.</p><p>Program pencegahan telah terbukti mengurangi depresi. Pendekatan komunitas yang efektif untuk mencegah depresi meliputi program berbasis sekolah untuk meningkatkan pola penanggulangan positif pada anak-anak dan remaja. Intervensi untuk orang tua dari anak-anak dengan masalah perilaku dapat mengurangi gejala depresi orang tua dan meningkatkan hasil bagi anak-anak mereka. Program olahraga untuk orang lanjut usia juga dapat efektif dalam pencegahan depresi.</p><h2><strong>Diagnosis dan pengobatan</strong></h2><p>Terdapat pengobatan yang efektif untuk depresi. Pengobatan tersebut meliputi terapi psikologis dan obat-obatan. Carilah perawatan jika Anda mengalami gejala depresi.</p><p>Terapi psikologis adalah pengobatan pertama untuk depresi. Terapi ini dapat dikombinasikan dengan obat antidepresan pada depresi sedang dan berat. Obat antidepresan tidak diperlukan untuk depresi ringan.<br>&nbsp;</p><p>Terapi psikologis dapat mengajarkan cara berpikir, mengatasi masalah, atau berhubungan dengan orang lain yang baru. Terapi ini dapat mencakup terapi bicara dengan para profesional dan terapis awam yang diawasi. Terapi bicara dapat dilakukan secara tatap muka atau daring. Terapi psikologis dapat diakses melalui buku panduan swadaya, situs web, dan aplikasi.&nbsp;<br>&nbsp;</p><p>Perawatan psikologis yang efektif untuk depresi meliputi:&nbsp;&nbsp;&nbsp;</p><ul><li>aktivasi perilaku</li><li>terapi perilaku kognitif</li><li>psikoterapi interpersonal</li><li>terapi pemecahan masalah.</li></ul><p>Obat antidepresan meliputi selective serotonin reuptake inhibitors (SSRIs), seperti fluoxetine.</p><p>Penyedia layanan kesehatan harus mempertimbangkan kemungkinan efek samping yang terkait dengan obat antidepresan, kemampuan untuk memberikan intervensi (dalam hal keahlian, dan/atau ketersediaan pengobatan), dan preferensi individu.</p><p>Antidepresan tidak boleh digunakan untuk mengobati depresi pada anak-anak dan bukan merupakan pengobatan lini pertama pada remaja, di mana penggunaannya harus dilakukan dengan sangat hati-hati.</p><p>Berbagai macam obat dan perawatan digunakan untuk gangguan bipolar.</p><h2><strong>Perawatan diri</strong></h2><p>Perawatan diri dapat memainkan peran penting dalam mengelola gejala depresi dan meningkatkan kesejahteraan secara keseluruhan.<br>&nbsp;</p><p>Yang dapat Anda lakukan:</p><ul><li>Cobalah untuk terus melakukan aktivitas yang dulu Anda sukai.</li><li>Tetap terhubung dengan teman dan keluarga</li><li>Berolahragalah secara teratur, meskipun hanya berjalan kaki sebentar.</li><li>Usahakan untuk tetap menjalankan kebiasaan makan dan tidur secara teratur sebisa mungkin.</li><li>Hindari atau kurangi konsumsi alkohol dan jangan menggunakan narkoba ilegal, karena dapat memperburuk depresi.</li><li>Bicaralah dengan seseorang yang Anda percayai tentang perasaan Anda. </li><li>Carilah bantuan dari penyedia layanan kesehatan.</li></ul><p>Jika Anda memiliki pikiran untuk bunuh diri:</p><ul><li>Ingatlah bahwa kamu tidak sendirian, dan banyak orang telah mengalami apa yang kamu alami dan menemukan bantuan.</li><li>Bicaralah dengan seseorang yang Anda percayai tentang perasaan Anda.</li><li>bicaralah dengan petugas kesehatan, seperti dokter atau konselor.</li><li>Bergabunglah dengan kelompok dukungan.</li></ul><p>Jika Anda merasa berada dalam bahaya langsung untuk melukai diri sendiri, hubungi layanan darurat atau saluran krisis yang tersedia.</p><h2><strong>Tanggapan WHO</strong></h2><p>Rencana Aksi Kesehatan Mental Komprehensif WHO 2013–2030 menyoroti langkah-langkah yang diperlukan untuk menyediakan intervensi yang tepat bagi orang-orang dengan gangguan mental termasuk depresi.&nbsp;</p><p>Depresi dan perilaku melukai diri sendiri/bunuh diri termasuk di antara kondisi prioritas yang dicakup oleh Program Aksi Kesenjangan Kesehatan Mental (mhGAP) WHO. Program ini bertujuan untuk membantu negara-negara meningkatkan layanan bagi orang-orang dengan gangguan mental, neurologis, dan penyalahgunaan zat melalui perawatan yang diberikan oleh petugas kesehatan yang bukan spesialis di bidang kesehatan mental.&nbsp;</p><p>WHO telah mengembangkan manual intervensi psikologis singkat untuk depresi yang dapat diberikan oleh terapis awam kepada individu dan kelompok. Contohnya adalah manual Problem Management Plus (PM+) , yang menjelaskan penggunaan aktivasi perilaku, manajemen stres, pengobatan pemecahan masalah, dan penguatan dukungan sosial. Selain itu,Buku panduan Terapi Interpersonal Kelompok untuk Depresi menjelaskan pengobatan depresi secara berkelompok. Terakhir, buku panduan Berpikir Sehat membahas penggunaan terapi kognitif-perilaku untuk depresi perinatal.</p><p>&nbsp;</p><p>Link Artikel :&nbsp;</p><p><a href=\"https://www.who.int/news-room/fact-sheets/detail/depression\">https://www.who.int/news-room/fact-sheets/detail/depression</a></p>', 'https://res.cloudinary.com/dftkqdftn/image/upload/v1780812708/mentality/blogs/wcdm2wtomceui2lvcsq1.png', 'Depresi', 1, '2026-03-17 14:33:29', '2026-06-07 13:11:48'),
(4, 'Tips Menjaga Kesehatan Mental di Tengah Kesibukan Kuliah', 'tips-kesehatan-mental-kuliah', 'Kenali perbedaan antara hal yang bisa dikendalikan dan hal yang tidak bisa dikendalikan. Atikah menyebutkan beberapa hal yang dapat dikendalikan seperti pikiran, perasaan, perilaku, dan perkataan diri. Sementara pikiran, perasaan, perilaku serta perkataan orang lain, dunia luar, dan kehendak tuhan merupakan hal-hal yang berada di luar kendali diri.', '<p style=\"margin-left:0px;\">Menjaga kesehatan mental menjadi aspek krusial bagi mahasiswa. Di tengah padatnya aktivitas perkuliahan dengan berbagai tugas sering kali menyebabkan stres dan kecemasan. Oleh karena itu, penting bagi mahasiswa untuk menyadari pentingnya menjaga kesehatan mental agar tetap fokus, produktif, dan mampu menghadapi tantangan perkuliahan dengan baik. Lantas langkah apa saja yang bisa diambil untuk tetap menjaga kesehatan mental di tengah padatnya aktivitas perkuliahan?</p><p style=\"margin-left:0px;\">Psikolog pada Career and Student Development Unit (CSDU) Fakultas Ekonomika dan Bisnis UGM, Atikah Dian Rahmawati, M.Psi., Psikolog., menyebutkan ada tujuh cara untuk menjaga kesehatan mental mahasiswa.</p><p style=\"margin-left:0px;\"><strong>Pertama</strong>, melakukan kegiatan yang sesuai kemampuan dan minat serta mengembangkan hobi. Menghabiskan waktu untuk hobi terbukti efektif dalam mengelola stress.</p><p style=\"margin-left:0px;\">“Selain itu menekuni hobi juga mampu mengasah kreativitas yang dapat mengurangi kecemasan dan stres,” tuturnya, Selasa (10/9) di FEB UGM.</p><p style=\"margin-left:0px;\"><strong>Kedua</strong>, menjaga kebugaran tubuh dengan melakukan olahraga, tidur yang cukup, serta makan makanan bergizi dan teratur. Melalui berbagai kegiatan tersebut dapat membantu meredakan ketegangan emosi dan menjernihkan pikiran.</p><p style=\"margin-left:0px;\"><strong>Ketiga</strong>, mengenali perasaan diri sendiri dan mengekspresikan dengan cara yang tepat. Mengakui perasaan dan emosi seperti kecemasan maupun kesedihan merupakan bagian dari upaya dalam menjaga kesehatan mental tanpa menyalahkan diri sendiri atas perasaan yang muncul.</p><p style=\"margin-left:0px;\"><strong>Keempat</strong>, bicarakan perasaan dan keluhan yang dirasakan dengan seseorang yang dapat dipercaya. Dengan bercerita atau berbicara kepada orang yang dapat dipercaya bisa membantu meringankan beban dan mengurangi stres.</p><p style=\"margin-left:0px;\"><strong>Kelima</strong>, ikut aktif dalam kegiatan sosial. Dengan aktif pada kegiatan sosial memberikan peluang membangun koneksi sosial, persahabatan hingga memberikan kesempatan untuk saling mendukung.</p><p style=\"margin-left:0px;\"><strong>Keenam</strong>, kelilingi diri dengan orang-orang yang mendukung. Berada di lingkaran pergaulan yang mendukung akan membawa energi positif pada diri sehingga berpengaruh pada kondisi mental</p><p style=\"margin-left:0px;\">Link Artikel :</p><p style=\"margin-left:0px;\"><a href=\"https://feb.ugm.ac.id/id/berita/4795-tujuh-cara-menjaga-kesehatan-mental-mahasiswa\">https://feb.ugm.ac.id/id/berita/4795-tujuh-cara-menjaga-kesehatan-mental-mahasiswa</a></p>', 'https://res.cloudinary.com/dftkqdftn/image/upload/v1780812715/mentality/blogs/hyrsdu4mnyshcqfxlf8f.png', 'Tips', 1, '2026-03-17 14:33:29', '2026-06-07 13:11:54'),
(5, 'Trauma dan PTSD: Ketika Luka Masa Lalu Menghantui', 'trauma-ptsd-luka-masa-lalu', 'Trauma adalah respons tubuh ketika dihadapkan dengan peristiwa buruk yang dapat membahayakan kondisi fisik maupun mental. Trauma adalah kondisi yang umum terjadi dan bisa dialami oleh siapa saja. Kendati demikian, kondisi ini tetap memerlukan penanganan yang tepat agar tidak menimbulkan efek berkepanjangan yang dapat mengganggu kualitas hidup penderitanya.', '<h2><strong>Penyebab Trauma</strong></h2><p>Penyebab utama dari trauma adalah kejadian atau peristiwa buruk yang dapat memengaruhi kondisi fisik maupun emosi, seperti bencana alam, kecelakaan, pelecehan seksual, dan kekerasan fisik. Selain itu, sejumlah faktor yang dapat meningkatkan risiko seseorang mengalami trauma adalah sebagai berikut:</p><p><strong>Mengalami bullying.</strong></p><ol><li>Diabaikan oleh orang terdekat dan keluarga.</li><li>Diabaikan oleh orang terdekat dan keluarga.</li><li>Memiliki riwayat masalah kesehatan mental, seperti gangguan cemas atau depresi.</li><li>Memiliki keluarga dengan riwayat gangguan mental.</li><li>Memiliki pekerjaan yang berisiko menimbulkan kejadian traumatis, seperti anggota militer atau tenaga medis.</li><li>Penyalahgunaan NAPZA.</li><li>Mengonsumsi minuman beralkohol secara berlebihan.<br>&nbsp;</li></ol><h2><strong>Gejala Trauma</strong></h2><p>Gejala trauma pada setiap individu cenderung beragam tergantung dari kondisi dan tingkat keparahannya. Namun, berdasarkan pengaruhnya, gejala trauma dibedakan menjadi dua kelompok, yaitu reaksi fisik serta reaksi psikis dan emosional. Berikut masing-masing penjelasannya.</p><p>&nbsp;</p><h2><strong>Reaksi Fisik</strong></h2><p>Adapun sejumlah reaksi fisik yang dapat muncul sebagai akibat dari trauma adalah sebagai berikut:</p><ol><li>Sakit kepala.</li><li>Kelelahan.</li><li>Gangguan pencernaan.</li><li>Jantung berdebar.</li><li>Tubuh mengeluarkan keringat berlebih.<br>&nbsp;</li></ol><h2><strong>Reaksi Psikis dan Emosional</strong></h2><p>Sementara itu, sejumlah reaksi psikis dan emosional yang kerap timbul saat seseorang mengalami trauma adalah:</p><ol><li>Takut, panik, dan cemas berlebih.</li><li>Cenderung tertutup dan enggan bersosialisasi.</li><li>Kesulitan untuk memusatkan fokus dan berkonsentrasi.</li><li>Insomnia.</li><li>Depresi.</li><li>Perubahan pola makan.<br>&nbsp;</li></ol><h2><strong>Diagnosis Trauma</strong></h2><p>Untuk memastikan trauma yang dialami oleh pasien, dokter akan melakukan evaluasi psikologis dengan menanyakan keluhan, riwayat kondisi medis, serta peristiwa yang pernah dialami. Selain itu, diagnosis trauma juga dapat dilakukan dengan mengarahkan pasien untuk mengisi kuesioner psikologis.</p><p>&nbsp;</p><h2><strong>Gangguan Mental yang Berkaitan dengan Trauma</strong></h2><p>Adapun sejumlah gangguan kesehatan mental yang berkaitan dengan trauma psikologis adalah sebagai berikut:</p><h2><strong>1. Post-Traumatic Stress Disorder (PTSD)</strong></h2><p>Post-traumatic stress disorder (PTSD) merupakan gangguan mental yang terjadi ketika seseorang mengalami atau melihat peristiwa bersifat traumatis. Beberapa gejala yang kerap dialami oleh penderita PTSD adalah:</p><ol><li>Sering kali mengingat kejadian traumatis yang pernah dialaminya.</li><li>Cenderung mengelak dan enggan membicarakan peristiwa traumatis.</li><li>Insomnia.</li><li>Sulit berkonsentrasi.<br>&nbsp;</li></ol><h2><strong>2. Depresi</strong></h2><p>Depresi adalah gangguan mental yang berkaitan dengan suasana hati dan dapat memengaruhi kondisi fisik, emosional, perilaku, dan cara berpikir seseorang. Depresi menjadi salah satu respons yang umum terjadi saat seseorang mengalami trauma.</p><p>&nbsp;</p><h2><strong>3. Borderline Personality Disorder (BPD)</strong></h2><p>Borderline personality disorder (BPD) adalah kondisi psikologis yang dapat memengaruhi emosi, perasaan, dan cara berpikir penderitanya. Belum diketahui secara pasti apa penyebab dari BPD. Namun, para ahli menduga bahwa kondisi ini bisa dipicu oleh beberapa hal, seperti peristiwa traumatis, faktor genetik, serta kelainan struktur dan fungsi otak.</p><h2><strong>4. Anxiety Disorder</strong><br>&nbsp;</h2><p>Anxiety disorder merupakan gangguan suasana hati yang menyebabkan seseorang merasa cemas, takut, dan khawatir secara berlebihan. Anxiety disorder dapat muncul ketika seseorang mengalami atau mengingat kejadian traumatis yang pernah dialaminya. Beberapa gejala umum dari anxiety disorder adalah sebagai berikut:</p><ol><li>Kesulitan untuk mengontrol rasa takut dan cemas berlebih.</li><li>Mudah gelisah tanpa penyebab yang jelas.</li><li>Kesulitan untuk berkonsentrasi.</li><li>Mengalami panic attack.<br>&nbsp;</li></ol><h2><strong>Cara Mengatasi Trauma</strong></h2><p>Penanganan trauma dilakukan berdasarkan penyebab yang mendasarinya. Namun, sejumlah tindakan medis yang umum dilakukan untuk menangani trauma adalah sebagai berikut:</p><p>&nbsp;</p><h2><strong>1. Psikoterapi</strong></h2><p>Psikoterapi adalah terapi psikologis untuk mengendalikan cara berpikir dan perasaan yang berhubungan dengan trauma. Psikoterapi yang umum dilakukan untuk mengatasi trauma adalah cognitive behavioral therapy (CBT) dan somatic experiencing.</p><p>&nbsp;</p><h2><strong>2. Konsumsi Obat-Obatan</strong></h2><p>Jika diperlukan, dokter juga dapat meresepkan obat-obatan untuk membantu mengatasi trauma. Adapun dua jenis obat yang kerap digunakan untuk menangani trauma di antaranya:</p><p>Tranquiliser untuk mengurangi kecemasan dan membantu tidur.<br>Antidepresan untuk menangani depresi yang muncul sebagai akibat dari trauma.<br>&nbsp;</p><h2><strong>3. Perawatan Mandiri</strong></h2><p>Selain tindakan medis, seseorang yang mengalami trauma juga disarankan untuk melakukan perawatan mandiri di rumah, seperti:</p><ol><li>Mengonsumsi makanan sehat dan bergizi seimbang.</li><li>Mencukupi waktu tidur.</li><li>Berolahraga secara rutin.</li><li>Bercerita dengan keluarga atau orang terdekat.</li></ol><p>Link Artikel:</p><p>&nbsp;<a href=\"https://www.siloamhospitals.com/informasi-siloam/artikel/apa-itu-trauma\">https://www.siloamhospitals.com/informasi-siloam/artikel/apa-itu-trauma</a></p><p>&nbsp;</p>', 'https://res.cloudinary.com/dftkqdftn/image/upload/v1780812721/mentality/blogs/n9ob4xuo6iliczpfrbnf.png', 'Trauma', 1, '2026-03-17 14:33:29', '2026-06-07 13:12:00');
INSERT INTO `blogs` (`id`, `judul`, `slug`, `ringkasan`, `konten`, `gambar`, `kategori`, `published`, `created_at`, `updated_at`) VALUES
(6, 'Umum : Pengenalan  Kesehatan Mental', 'umum-pengenalan-kesehatan-mental', 'Kesehatan mental yang baik adalah kondisi ketika batin kita berada dalam keadaan tentram dan tenang, sehingga memungkinkan kita untuk menikmati kehidupan sehari-hari dan menghargai orang lain di sekitar.', '<p style=\"margin-left:0px;text-align:justify;\">Seseorang yang bermental <i>sehat</i> dapat menggunakan kemampuan atau potensi dirinya secara maksimal dalam menghadapi tantangan hidup, serta menjalin hubungan positif dengan orang lain.</p><p style=\"margin-left:0px;text-align:justify;\">Sebaliknya, orang yang kesehatan mentalnya terganggu akan mengalami gangguan suasana hati, kemampuan berpikir, serta kendali emosi yang pada akhirnya bisa mengarah pada perilaku buruk.</p><p style=\"margin-left:0px;text-align:justify;\">Penyakit mental dapat menyebabkan masalah dalam kehidupan sehari-hari, tidak hanya dapat merusak interaksi atau hubungan dengan orang lain, namun juga dapat menurunkan prestasi di sekolah dan produktivitas kerja. oleh sebab itu, sudah saatnya kita menjalankan pola hidup sehat</p><p style=\"margin-left:0px;text-align:justify;\">Terdapat beberapa jenis masalah kesehatan mental dan berikut ini adalah tiga jenis kondisi yang paling umum terjadi.</p><h2 style=\"text-align:justify;\">&nbsp;</h2><h2 style=\"text-align:justify;\">1. Stres</h2><p style=\"margin-left:0px;text-align:justify;\">Stres adalah keadaan ketika seseorang mengalami tekanan yang sangat berat, baik secara emosi maupun mental.</p><p style=\"margin-left:0px;text-align:justify;\">Seseorang yang stres biasanya akan tampak gelisah, cemas, dan mudah tersinggung. Stres juga dapat mengganggu konsentrasi, mengurangi motivasi, dan pada kasus tertentu, memicu depresi.</p><p style=\"margin-left:0px;text-align:justify;\">Stres bukan saja dapat memengaruhi psikologi penderitanya, tetapi juga dapat berdampak kepada cara bersikap dan kesehatan fisik mereka.</p><p style=\"margin-left:0px;text-align:justify;\">Berikut ini adalah contoh dampak stres terhadap perilaku seseorang:</p><ul><li>Menjadi penyendiri dan enggan berinteraksi dengan orang lain.</li><li>Enggan makan atau makan secara berlebihan.</li><li>Marah-marah, dan terkadang kemaharan itu sulit dikendalikan.</li><li>Menjadi perokok atau merokok secara berlebihan.</li><li>Mengonsumsi minuman beralkohol secara berlebihan.</li><li>Penyalahgunaan obat-obatan narkotika.</li></ul><p style=\"margin-left:0px;text-align:justify;\">Berikut ini adalah masalah<strong> kesehatan</strong> yang dapat timbul akibat stres:</p><ul><li>Gangguan tidur</li><li>Lelah</li><li>Sakit kepala</li><li>Sakit perut</li><li>Nyeri dada</li><li>Nyeri atau tegang pada otot</li><li>Penurunan gairah seksual</li><li>Obesitas</li><li>Hipertensi</li><li>Diabetes</li><li>Gangguan jantung</li></ul><p style=\"margin-left:0px;text-align:justify;\">Banyak faktor yang dapat menyebabkan seseorang mengalami stres, sebagian di antaranya adalah masalah keuangan, hubungan sosial, atau tuntutan di dalam pekerjaan. Untuk mengatasi stres, kunci utamanya adalah mengidentifikasi akar permasalahan dan mencari solusinya.</p><p style=\"margin-left:0px;text-align:justify;\">Penanggulangan stres juga bisa dilakukan dengan mengaplikasikan nasihat-nasihat yang disarankan dalam manajemen stres yang baik, seperti:</p><ul><li>Belajar menerima suatu masalah yang sulit diatasi atau hal-hal yang tidak dapat diubah.</li><li>Selalu berpikir positif dan memandang bahwa segala sesuatu yang terjadi di dalam hidup ada hikmahnya.</li><li>Meminta saran dari orang terpercaya untuk mengatasi masalah yang sedang dialami.</li><li>Belajar mengendalikan diri dan selalu aktif dalam mencari solusi.</li><li>Melakukan aktivitas fisik, meditasi, atau teknik relaksasi guna meredakan ketegangan emosi dan menjernihkan pikiran.</li><li>Melakukan hal-hal baru yang menantang dan lain dari biasanya guna meningkatkan rasa percaya diri.</li><li>Menyisihkan waktu untuk melakukan hal-hal yang disukai.</li><li>Melibatkan diri dalam kegiatan-kegiatan sosial untuk membantu orang lain. Cara ini dapat membuat seseorang lebih tabah dalam menghadapi masalah, terutama jika bisa membantu seseorang yang memiliki masalah lebih berat dari yang dialaminya.</li><li>Menghindari cara-cara negatif untuk meredakan stres, misalnya merokok, mengonsumsi minuman beralkohol secara berlebihan, atau menggunakan narkoba.</li><li>Bekerja dengan mengedepankan kualitas bukan kuantitas, agar manajemen waktu lebih baik dan hidup juga lebih seimbang.</li></ul><h4 style=\"text-align:justify;\">&nbsp;</h4><h2 style=\"text-align:justify;\">2. Gangguan Kecemasan</h2><p style=\"margin-left:0px;text-align:justify;\">Gangguan kecemasan adalah <u>kondisi psikologis</u> ketika seseorang mengalami rasa cemas berlebihan secara konstan dan sulit dikendalikan, sehingga berdampak buruk terhadap kehidupan sehari-harinya.</p><p style=\"margin-left:0px;text-align:justify;\">Bagi sebagian orang normal, rasa cemas biasanya timbul pada suatu kejadian tertentu saja, misalnya saat akan menghadapi ujian di sekolah atau wawancara kerja. Namun pada penderita gangguan kecemasan, rasa cemas ini kerap timbul pada tiap situasi. Itu sebabnya orang yang mengalami kondisi ini akan sulit merasa rileks dari waktu ke waktu.</p><p style=\"margin-left:0px;text-align:justify;\">Selain gelisah atau rasa takut yang berlebihan, gejala psikologis lain yang bisa muncul pada penderita gangguan kecemasan adalah berkurangnya rasa percaya diri, menjadi mudah marah, stres, sulit berkonsentrasi, dan menjadi penyendiri.</p><p style=\"margin-left:0px;text-align:justify;\">Sementara itu, gejala fisik yang mungkin menyertai masalah gangguan kecemasan antara lain:</p><ul><li>Sulit tidur</li><li>Badan gemetar</li><li>Mengeluarkan keringat secara berlebihan</li><li>Otot menjadi tegang</li><li>Jantung berdebar</li><li>Sesak napas</li><li>Lelah</li><li>Sakit perut atau kepala</li><li>Pusing</li><li>Mulut terasa kering</li><li>Kesemutan</li></ul><p style=\"margin-left:0px;text-align:justify;\">Meski penyebab gangguan kecemasan belum diketahui secara pasti, beberapa faktor diduga dapat memicu munculnya kondisi tersebut. Di antaranya adalah trauma akibat intimidasi, pelecehan, dan kekerasan di lingkungan luar ataupun keluarga.</p><p style=\"margin-left:0px;text-align:justify;\">Faktor risiko lainnya adalah stres berkepanjangan, gen yang diwariskan dari orang tua, dan ketidakseimbangan hormon serotonin dan noradrenalin di dalam otak yang berfungsi mengendalikan suasana hati. Gangguan kecemasan juga dapat dipicu oleh penyalahgunaan minuman keras dan obat-obatan terlarang.</p><p style=\"margin-left:0px;text-align:justify;\">Sebenarnya, gangguan kecemasan dapat diatasi tanpa bantuan dokter melalui beberapa cara, seperti mengonsumsi makanan bergizi tinggi, cukup tidur, mengurangi asupan kafein, minuman beralkohol, atau zat penenang lainnya, tidak merokok, berola raga secara rutin, dan melakukan metode relaksasi sederhana, seperti yoga atau meditasi.</p><p style=\"margin-left:0px;text-align:justify;\">Jika pengobatan mandiri tidak memberikan perubahan, disarankan untuk berkonsultasi dengan dokter. Penanganan dari dokter biasanya meliputi pemberian obat-obatan antiansietas serta terapi kognitif.</p><h4 style=\"text-align:justify;\">&nbsp;</h4><h2 style=\"text-align:justify;\">3. Depresi</h2><p style=\"margin-left:0px;text-align:justify;\">Depresi merupakan gangguan suasana hati yang menyebabkan penderitanya terus-menerus merasa sedih. Berbeda dengan kesedihan biasa yang umumnya berlangsung selama beberapa hari, perasaan sedih pada depresi bisa berlangsung hingga berminggu-minggu atau berbulan-bulan.</p><p style=\"margin-left:0px;text-align:justify;\">Selain memengaruhi perasaan atau emosi, depresi juga dapat menyebabkan masalah fisik, mengubah cara berpikir, serta mengubah cara berperilaku penderitanya. Tidak jarang penderita depresi sulit menjalani aktivitas sehari-hari secara normal. Bahkan pada kasus tertentu, mereka bisa menyakiti diri sendiri dan mencoba bunuh diri.</p><p style=\"margin-left:0px;text-align:justify;\">Berikut ini adalah beberapa gejala psikologi seseorang yang mengalami depresi:</p><ul><li>Kehilangan ketertarikan atau motivasi untuk melakukan sesuatu.</li><li>Terus-menerus merasa sedih, bahkan terus-menerus menangis.</li><li>Merasa sangat bersalah dan khawatir berlebihan.</li><li>Tidak dapat menikmati hidup karena kehilangan rasa percaya diri.</li><li>Sulit membuat keputusan dan mudah tersinggung.</li><li>Tidak acuh terhadap orang lain.</li><li>Memiliki pikiran untuk menyakiti diri sendiri atau bunuh diri.</li></ul><p style=\"margin-left:0px;text-align:justify;\">Berikut ini adalah dampak depresi terhadap kesehatan<a href=\"https://ayosehat.kemkes.go.id/phbs\"> </a>fisik yang mungkin dapat terjadi:</p><ul><li>Gangguan tidur dan badan terasa lemah.</li><li>Berbicara atau bergerak menjadi lebih lambat.</li><li>Perubahan siklus menstruasi pada wanita.</li><li>Libido turun dan muncul sembelit.</li><li>Nafsu makan turun atau meningkat secara drastis.</li><li>Merasakan sakit atau nyeri tanpa sebab.</li></ul><p style=\"margin-left:0px;text-align:justify;\">Ada beragam hal yang dapat memicu terjadinya depresi, mulai dari peristiwa dalam hidup yang menimbulkan stres, kehilangan orang yang dicintai, merasa kesepian, hingga memiliki kepribadian yang rapuh terhadap depresi.</p><p style=\"margin-left:0px;text-align:justify;\">Selain itu, depresi yang dialami seseorang juga bisa disebabkan oleh penderitaan akibat penyakit parah dan berkepanjangan, seperti kanker dan gangguan jantung, cedera parah di kepala, efek dari konsumsi minuman beralkohol berlebihan dan obat-obatan terlarang, hingga akibat faktor genetik dalam keluarga.</p><p style=\"margin-left:0px;text-align:justify;\">Dianjurkan untuk berkonsultasi ke dokter jika merasakan gejala-gejala depresi selama lebih dari dua minggu dan tidak kunjung mereda. &nbsp;Apalagi jika gejala depresi tersebut sampai mengganggu proses pendidikan, pekerjaan, dan hubungan sosial,</p><p style=\"margin-left:0px;text-align:justify;\">Penanganan depresi oleh dokter akan disesuaikan dengan tingkat keparahan depresi yang diderita masing-masing pasien. Bentuk penanganan bisa berupa terapi konsultasi, pemberian obat-obatan antidepresi, atau kombinasi keduanya.</p><p style=\"margin-left:0px;text-align:justify;\">Link Artikel :</p><p style=\"margin-left:0px;text-align:justify;\"><a href=\"https://ayosehat.kemkes.go.id/pengertian-kesehatan-mental\">https://ayosehat.kemkes.go.id/pengertian-kesehatan-mental</a></p>', 'https://res.cloudinary.com/dftkqdftn/image/upload/v1780812727/mentality/blogs/m37zu7qgwcbvovtqy4jx.png', 'Umum', 1, '2026-03-20 19:26:27', '2026-06-07 13:12:06');

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

--
-- Dumping data untuk tabel `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `session_id`, `role`, `content`, `created_at`) VALUES
(23, 2, 'user', 'halo', '2026-03-17 20:48:32'),
(24, 2, 'assistant', 'Halo! 😊 Ada apa nih? Lo mau curhat tentang apa? Gue dengerin, deh! 💬', '2026-03-17 20:48:33'),
(25, 2, 'user', 'Tips mengurangi stres kuliah', '2026-03-17 20:48:37'),
(26, 2, 'assistant', 'Stres kuliah itu beneran nggak enak, sih 😔. Tapi, gue punya beberapa tips yang mungkin bisa bantu lo mengurangi stres kuliah, nih!\n\nPertama, coba buat jadwal yang realistis, deh. Jangan terlalu banyak ngambil tugas sekaligus, karena itu bisa bikin lo kepanjangan dan stres. Prioritaskan tugas-tugas yang penting, trus pecah jadi tugas-tugas kecil yang lebih mudah dikelola.\n\nKedua, jangan lupa istirahat, ya! Tidur yang cukup, makan yang sehat, dan olahraga ringan bisa bantu lo mengurangi stres. Gue tahu, kadang-kadang kita suka mager dan malas gerak, tapi percaya deh, olahraga bisa bantu lo merasa lebih baik 🏋️‍♀️.\n\nTerakhir, coba cari kegiatan yang lo suka, nih! Apakah itu membaca, mendengarkan musik, atau ngobrol sama temen-temen, kegiatan yang lo suka bisa bantu lo mengalihkan pikiran dari stres kuliah.\n\nGimana, nih? Lo punya kegiatan favorit yang bisa bantu lo mengurangi stres? 🤔', '2026-03-17 20:48:38'),
(27, 2, 'user', 'mantap men', '2026-03-17 20:49:01'),
(28, 2, 'assistant', 'Makasih, bro! 🙌 Gue senang bisa bantu. Ingat, stres kuliah itu normal, tapi jangan sampai lo kewalahan, deh! 🤯 Jika perlu, lo bisa curhat sama gue atau temen-temen lainnya. Kami ada buat mendengarkan dan membantu, kok! 💬\n\nOh iya, lo udah pernah coba teknik relaksasi, seperti meditasi atau deep breathing, nggak? 🙏 Ini bisa bantu lo mengurangi stres dan merasa lebih tenang, lho! 🌟', '2026-03-17 20:49:02'),
(37, 5, 'user', 'Kapan harus ke psikolog?', '2026-03-20 19:01:22'),
(38, 5, 'assistant', 'Kamu bertanya-tanya kapan harus ke psikolog, ya? 🤔 Gue sih pengen bilang, kalau lo merasa butuh bantuan atau dukungan untuk menghadapi masalah mental, itu udah saat yang tepat buat ke psikolog, deh! 🙌\n\nMisalnya, kalo lo merasa sedih, cemas, atau stres terus-terusan, dan itu ngaruh ke kegiatan sehari-hari, mungkin saatnya lo mencari bantuan profesional, nih. Atau, kalo lo mengalami trauma, kesulitan tidur, atau merasa kesepian, psikolog bisa jadi teman yang baik buat bantu lo melewati masa-masa sulit itu, lho! 😊\n\nTapi, gimana kalo lo masih ragu-ragu? Apa yang membuat lo mikir kalau lo butuh ke psikolog, sih? 🤔 Lo bisa cerita sedikit tentang apa yang terjadi, dan gue bisa bantu lo memahami lebih baik, dong! 💬', '2026-03-20 19:01:24');

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

--
-- Dumping data untuk tabel `chat_sessions`
--

INSERT INTO `chat_sessions` (`id`, `session_token`, `mahasiswa_id`, `hasil_tes_id`, `created_at`) VALUES
(1, '4cdb076b14ebc9b92b4d53d6731d20124f323de00ee2607ebcc28426d635bf5d', NULL, NULL, '2026-03-17 20:11:09'),
(2, '3217f9cac7972fbf7df3bee58c0170e2c97b0b3777762274bb8fc25ad78c4915', 1, 1, '2026-03-17 20:48:25'),
(3, 'a070db86aae32fb4c760a7fadddb17b8ef61f1b21c1307f8d97169508672b234', NULL, NULL, '2026-03-19 20:57:13'),
(4, 'dafe60dae24fc5428b079fed5903aa862f947c5a3af9311a7fa4603cf9a26bad', 3, 3, '2026-03-19 22:43:31'),
(5, '70845f03aebb9df182890617048a80c2b186cfbcc4be9dab545354d43ddfa4c3', NULL, NULL, '2026-03-20 18:39:11'),
(6, '15ccaa25a0a4e220f5b87b9cdd86b90c36ec7201e2d4a66baee0aa1dbf4d933a', NULL, NULL, '2026-03-21 13:39:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `form_fields`
--

CREATE TABLE `form_fields` (
  `id` int(10) UNSIGNED NOT NULL,
  `label` varchar(150) NOT NULL COMMENT 'Label tampilan field',
  `name` varchar(80) NOT NULL COMMENT 'Nama field (unik, huruf kecil & underscore)',
  `type` enum('text','email','number','select','radio','textarea') NOT NULL DEFAULT 'text',
  `placeholder` varchar(150) DEFAULT NULL,
  `options` text DEFAULT NULL COMMENT 'Untuk select/radio: JSON array ["Opsi1","Opsi2"]',
  `required` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=wajib, 0=opsional',
  `aktif` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=tampil, 0=sembunyikan',
  `urutan` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Urutan tampil di form',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Field dinamis form data diri mahasiswa';

--
-- Dumping data untuk tabel `form_fields`
--

INSERT INTO `form_fields` (`id`, `label`, `name`, `type`, `placeholder`, `options`, `required`, `aktif`, `urutan`, `created_at`, `updated_at`) VALUES
(1, 'Nama Lengkap', 'nama', 'text', 'Contoh: Budi Santoso', NULL, 1, 1, 1, '2026-03-19 22:16:17', NULL),
(2, 'Alamat Email', 'email', 'email', 'contoh@email.com', NULL, 1, 1, 2, '2026-03-19 22:16:17', NULL),
(3, 'NIM', 'nim', 'text', 'Nomor Induk Mahasiswa', NULL, 0, 1, 3, '2026-03-19 22:16:17', NULL),
(4, 'Usia', 'usia', 'number', 'Usia dalam tahun', NULL, 1, 1, 4, '2026-03-19 22:16:17', NULL),
(5, 'Perguruan Tinggi', 'universitas', 'text', 'Nama universitas / kampus', NULL, 0, 1, 5, '2026-03-19 22:16:17', NULL),
(6, 'Jenis Kelamin', 'jenis_kelamin', 'radio', NULL, '[\"Laki-laki\",\"Perempuan\"]', 1, 1, 6, '2026-03-19 22:16:17', NULL),
(7, 'Nomor Hp', 'nomor_hp', 'text', 'Contoh : 081x-xxxx-xxxx', NULL, 0, 1, 7, '2026-03-19 22:23:34', '2026-03-20 18:46:32'),
(8, 'Hobi', 'hobi', 'text', 'Contoh : Desainer Website', '[\"Desainer\",\"Freelancer\",\"Pelajar\\/Mahasiswa\",\"Guru\"]', 1, 1, 8, '2026-03-19 22:45:39', '2026-03-19 22:45:39');

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

--
-- Dumping data untuk tabel `hasil_tes`
--

INSERT INTO `hasil_tes` (`id`, `mahasiswa_id`, `skor_depresi`, `skor_kecemasan`, `skor_stres`, `kategori_depresi`, `kategori_kecemasan`, `kategori_stres`, `jawaban_json`, `created_at`) VALUES
(1, 1, 28, 28, 30, 'Sangat Berat', 'Sangat Berat', 'Berat', '{\"1\":1,\"2\":1,\"3\":1,\"4\":1,\"5\":1,\"6\":1,\"7\":1,\"8\":1,\"9\":2,\"10\":3,\"11\":3,\"12\":3,\"13\":3,\"14\":3,\"15\":3,\"16\":0,\"17\":3,\"18\":3,\"19\":3,\"20\":3,\"21\":3}', '2026-03-17 20:13:15'),
(2, 2, 2, 0, 0, 'Normal', 'Normal', 'Normal', '{\"1\":0,\"2\":0,\"3\":0,\"4\":0,\"5\":0,\"6\":0,\"7\":0,\"8\":0,\"9\":0,\"10\":0,\"11\":0,\"12\":0,\"13\":0,\"14\":0,\"15\":0,\"16\":0,\"17\":1,\"18\":0,\"19\":0,\"20\":0,\"21\":0}', '2026-03-19 22:03:39'),
(3, 3, 42, 42, 42, 'Sangat Berat', 'Sangat Berat', 'Sangat Berat', '{\"1\":3,\"2\":3,\"3\":3,\"4\":3,\"5\":3,\"6\":3,\"7\":3,\"8\":3,\"9\":3,\"10\":3,\"11\":3,\"12\":3,\"13\":3,\"14\":3,\"15\":3,\"16\":3,\"17\":3,\"18\":3,\"19\":3,\"20\":3,\"21\":3}', '2026-03-19 22:08:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `attempted_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Log percobaan login gagal untuk rate limiting';

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

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `nama`, `email`, `nim`, `universitas`, `jenis_kelamin`, `usia`, `created_at`) VALUES
(1, 'ana', 'ana@gmail.com', '1', 'STMIK TIME', 'P', 23, '2026-03-17 20:12:45'),
(2, 'Anang', 'anang@gmail.com', '2', 'STMIK TIME', 'L', 23, '2026-03-19 22:03:03'),
(3, 'Apriana', 'aprianabrtrg@gmail.com', '2245046', 'STMIK TIME', 'P', 22, '2026-03-19 22:08:22'),
(4, 'tes', '123@gmail.com', '123', '123', 'L', 15, '2026-03-20 18:41:16'),
(5, 'testsew', 'tes521@gmail.com', '1234', 'STMIK TIME', 'L', 42, '2026-03-20 18:56:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pertanyaan_dass`
--

CREATE TABLE `pertanyaan_dass` (
  `id` int(10) UNSIGNED NOT NULL,
  `nomor` tinyint(3) UNSIGNED NOT NULL COMMENT 'Nomor urut soal 1-21',
  `pertanyaan` text NOT NULL COMMENT 'Teks pertanyaan',
  `skala` enum('depresi','kecemasan','stres') NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Pertanyaan kuesioner DASS-21';

--
-- Dumping data untuk tabel `pertanyaan_dass`
--

INSERT INTO `pertanyaan_dass` (`id`, `nomor`, `pertanyaan`, `skala`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 1, 'Saya merasa sulit untuk tenang', 'stres', 1, '2026-03-20 18:28:35', NULL),
(2, 2, 'Saya menyadari mulut terasa kering', 'kecemasan', 1, '2026-03-20 18:28:35', NULL),
(3, 3, 'Saya tidak dapat merasakan perasaan positif sama sekali', 'depresi', 1, '2026-03-20 18:28:35', NULL),
(4, 4, 'Saya mengalami gangguan pernapasan (napas cepat, sesak)', 'kecemasan', 1, '2026-03-20 18:28:35', NULL),
(5, 5, 'Saya merasa sulit untuk memulai sesuatu', 'depresi', 1, '2026-03-20 18:28:35', NULL),
(6, 6, 'Saya cenderung bereaksi berlebihan terhadap situasi', 'stres', 1, '2026-03-20 18:28:35', NULL),
(7, 7, 'Saya mengalami tremor (gemetar)', 'kecemasan', 1, '2026-03-20 18:28:35', NULL),
(8, 8, 'Saya merasa banyak menghabiskan energi karena cemas', 'stres', 1, '2026-03-20 18:28:35', NULL),
(9, 9, 'Saya khawatir dengan situasi panik yang mempermalukan', 'kecemasan', 1, '2026-03-20 18:28:35', NULL),
(10, 10, 'Saya merasa tidak ada yang bisa diharapkan ke depan', 'depresi', 1, '2026-03-20 18:28:35', NULL),
(11, 11, 'Saya merasa gelisah', 'stres', 1, '2026-03-20 18:28:35', NULL),
(12, 12, 'Saya merasa sulit untuk rileks', 'stres', 1, '2026-03-20 18:28:35', NULL),
(13, 13, 'Saya merasa sedih dan menderita', 'depresi', 1, '2026-03-20 18:28:35', NULL),
(14, 14, 'Saya tidak toleran dengan hal yang menghambat aktivitas', 'stres', 1, '2026-03-20 18:28:35', NULL),
(15, 15, 'Saya merasa hampir panik', 'kecemasan', 1, '2026-03-20 18:28:35', NULL),
(16, 16, 'Saya tidak mampu antusias dengan apapun', 'depresi', 1, '2026-03-20 18:28:35', NULL),
(17, 17, 'Saya merasa diri saya tidak berharga', 'depresi', 1, '2026-03-20 18:28:35', NULL),
(18, 18, 'Saya merasa mudah tersinggung', 'stres', 1, '2026-03-20 18:28:35', NULL),
(19, 19, 'Saya menyadari detak jantung yang tidak biasa', 'kecemasan', 1, '2026-03-20 18:28:35', NULL),
(20, 20, 'Saya merasa takut tanpa alasan yang jelas', 'kecemasan', 1, '2026-03-20 18:28:35', NULL),
(22, 21, 'Saya merasa Hidup tidak berarti', 'depresi', 1, '2026-03-20 18:37:25', '2026-03-20 19:02:27');

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
-- Dumping data untuk tabel `security_logs`
--

INSERT INTO `security_logs` (`id`, `ip_address`, `user_agent`, `method`, `uri`, `threat_type`, `payload`, `severity`, `notified`, `created_at`) VALUES
(1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'GET', 'http://localhost:8080/index.php?search=1%27+OR+%271%27%3D%271', 'SQL Injection', '{\"search\":\"1\' OR \'1\'=\'1\"}', 'Critical', 0, '2026-03-20 20:01:54'),
(2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'GET', 'http://localhost:8080/index.php?search=%3Cscript%3Ealert%281%29%3C%2Fscript%3E', 'SQL Injection', '{\"search\":\"<script>alert(1)<\\/script>\"}', 'Critical', 0, '2026-03-20 20:02:18'),
(3, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'GET', 'http://localhost:8080/index.php?search=1%27+OR+%271%27%3D%271', 'SQL Injection', '{\"search\":\"1\' OR \'1\'=\'1\"}', 'Critical', 0, '2026-03-20 20:09:39'),
(4, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'GET', 'http://localhost:8080/index.php?search=%3Cscript%3Ealert%281%29%3C%2Fscript%3E', 'SQL Injection', '{\"search\":\"<script>alert(1)<\\/script>\"}', 'Critical', 0, '2026-03-20 20:10:22'),
(5, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'GET', 'http://localhost:8080/index.php?search=%3Cscript%3Ealert%281%29%3C%2Fscript%3E', 'SQL Injection', '{\"search\":\"<script>alert(1)<\\/script>\"}', 'Critical', 0, '2026-03-20 20:15:48'),
(6, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'POST', 'http://localhost:8080/index.php/admin/login', 'SQL Injection', '{\"csrf_test_name\":\"e81c21b0f1f789b080bd120ec446c798\",\"email\":\"admin@123\",\"password\":\"admin\"}', 'Critical', 0, '2026-03-21 13:12:34'),
(7, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'POST', 'http://localhost:8080/index.php/admin/login', 'SQL Injection', '{\"csrf_test_name\":\"e81c21b0f1f789b080bd120ec446c798\",\"email\":\"admin@3123\",\"password\":\"admin\"}', 'Critical', 0, '2026-03-21 13:13:00'),
(8, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'POST', 'http://localhost:8080/index.php/admin/login', 'SQL Injection', '{\"csrf_test_name\":\"e81c21b0f1f789b080bd120ec446c798\",\"email\":\"admin@3123\",\"password\":\"admin\"}', 'Critical', 0, '2026-03-21 13:13:02'),
(9, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'POST', 'http://localhost:8080/index.php/admin/login', 'SQL Injection', '{\"csrf_test_name\":\"e81c21b0f1f789b080bd120ec446c798\",\"email\":\"admin@3123\",\"password\":\"admin\"}', 'Critical', 0, '2026-03-21 13:13:04'),
(10, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'POST', 'http://localhost:8080/index.php/admin/login', 'SQL Injection', '{\"csrf_test_name\":\"e81c21b0f1f789b080bd120ec446c798\",\"email\":\"admin@3123\",\"password\":\"admin\"}', 'Critical', 0, '2026-03-21 13:13:06'),
(11, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'POST', 'http://localhost:8080/index.php/admin/login', 'SQL Injection', '{\"csrf_test_name\":\"e81c21b0f1f789b080bd120ec446c798\",\"email\":\"admin@3123\",\"password\":\"admin\"}', 'Critical', 0, '2026-03-21 13:13:08'),
(12, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'POST', 'http://localhost:8080/index.php/admin/login', 'SQL Injection', '{\"csrf_test_name\":\"e81c21b0f1f789b080bd120ec446c798\",\"email\":\"admin@3123\",\"password\":\"admin\"}', 'Critical', 0, '2026-03-21 13:13:10'),
(13, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'POST', 'http://localhost:8080/index.php/admin/login', 'SQL Injection', '{\"csrf_test_name\":\"e81c21b0f1f789b080bd120ec446c798\",\"email\":\"admin@3123\",\"password\":\"admin\"}', 'Critical', 0, '2026-03-21 13:13:12'),
(14, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'POST', 'http://localhost:8080/index.php/admin/login', 'SQL Injection', '{\"csrf_test_name\":\"e81c21b0f1f789b080bd120ec446c798\",\"email\":\"admin@3123\",\"password\":\"admin\"}', 'Critical', 0, '2026-03-21 13:13:15'),
(15, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'POST', 'http://localhost:8080/index.php/admin/login', 'SQL Injection', '{\"csrf_test_name\":\"e81c21b0f1f789b080bd120ec446c798\",\"email\":\"admin@3123\",\"password\":\"admin\"}', 'Critical', 0, '2026-03-21 13:13:17'),
(16, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'POST', 'http://localhost:8080/index.php/admin/login', 'SQL Injection', '{\"csrf_test_name\":\"e81c21b0f1f789b080bd120ec446c798\",\"email\":\"admin@3123\",\"password\":\"admin\"}', 'Critical', 0, '2026-03-21 13:13:19'),
(17, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'POST', 'http://localhost:8080/index.php/admin/login', 'SQL Injection', '{\"csrf_test_name\":\"e81c21b0f1f789b080bd120ec446c798\",\"email\":\"admin2@3151542q414\",\"password\":\"admin\"}', 'Critical', 0, '2026-03-21 13:16:26'),
(18, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'POST', 'http://localhost:8080/index.php/admin/login', 'SQL Injection', '{\"csrf_test_name\":\"e81c21b0f1f789b080bd120ec446c798\",\"email\":\"admin2@3151542q414\",\"password\":\"admin\"}', 'Critical', 0, '2026-03-21 13:18:19'),
(19, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'POST', 'http://localhost:8080/index.php/admin/login', 'SQL Injection', '{\"csrf_test_name\":\"e81c21b0f1f789b080bd120ec446c798\",\"email\":\"admin@13123123\",\"password\":\"admin\"}', 'Critical', 0, '2026-03-21 13:18:31'),
(20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'POST', 'http://localhost:8080/index.php/admin/login', 'SQL Injection', '{\"csrf_test_name\":\"e81c21b0f1f789b080bd120ec446c798\",\"email\":\"admin@123123\",\"password\":\"admin\"}', 'Critical', 0, '2026-03-21 13:20:31'),
(21, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'POST', '/admin/login', 'Brute Force Login', 'Email: admin@12321 | Attempts: 5', 'High', 0, '2026-03-21 13:24:00'),
(22, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'POST', '/admin/login', 'Brute Force Login', 'Email: admin@12321 | Attempts: 5', 'High', 0, '2026-03-21 13:24:00'),
(23, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'POST', '/admin/login', 'Brute Force Login', 'Email: admin@12321 | Attempts: 5', 'High', 0, '2026-03-21 13:24:04'),
(24, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'POST', '/admin/login', 'Brute Force Login', 'Email: admin@123 | Attempts: 5', 'High', 0, '2026-03-21 13:24:23');

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
-- Indeks untuk tabel `form_fields`
--
ALTER TABLE `form_fields`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_name` (`name`);

--
-- Indeks untuk tabel `hasil_tes`
--
ALTER TABLE `hasil_tes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_mahasiswa` (`mahasiswa_id`);

--
-- Indeks untuk tabel `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ip` (`ip_address`),
  ADD KEY `idx_attempted` (`attempted_at`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_email` (`email`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pertanyaan_dass`
--
ALTER TABLE `pertanyaan_dass`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_nomor` (`nomor`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `chat_sessions`
--
ALTER TABLE `chat_sessions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `form_fields`
--
ALTER TABLE `form_fields`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `hasil_tes`
--
ALTER TABLE `hasil_tes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pertanyaan_dass`
--
ALTER TABLE `pertanyaan_dass`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `security_logs`
--
ALTER TABLE `security_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
