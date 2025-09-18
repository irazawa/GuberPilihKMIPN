<?php
session_start();
include '../../config/config.php';

$isHomeActive = false;
$isCalonActive = false;
$isPartai = false;
$isTataCaraActive = true;
$isBeritaActive = false;
$isHubungiKamiActive = false;
$isProfil = false;
$isDashboard = false;

// Simpan session

// Set data pengguna ke dalam sesi jika belum ada
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = array(); // Inisialisasi array pengguna jika belum ada
}
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$foto_profile = isset($_SESSION['foto_profile']) ? $_SESSION['foto_profile'] : 'src/data/users/default_profile.png';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tata Cara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link rel="icon" href="src/data/w/1.svg">
    <link rel="stylesheet" href="maincss">
    <link rel="stylesheet" href="<?php echo $MainLink ?>src/dist/css/main.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            padding-top: 150px;
            background-image: linear-gradient(to bottom, #FFFFFF, #a6fbff);
        }

        .container2 {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }

        /* Style untuk video */
        .video-container {
            width: 80%;
            /* Lebar maksimum video */
            margin: 0 auto;
            /* Membuat video berada di tengah */
        }

        .video-container video {
            width: 100%;
            /* Mengisi seluruh lebar container */
            height: auto;
            /* Mempertahankan aspek rasio video */
            display: block;
            /* Membuat video menjadi elemen block */
            margin: 0 auto;
            /* Membuat video berada di tengah */
        }

        .container img {
            max-width: 100%;
            height: auto;
            display: block;
            /* Membuat gambar menjadi elemen blok */
            margin: 0 auto;
            /* Memusatkan gambar */
        }
    </style>
</head>

<body>
    <!-- Include NavbarComponent -->
    <?php include '../../components/NavbarComponent.php'; ?>

    <div class="container2">
        <img src="https://www.linggapura.desa.id/artikel/wp-content/uploads/2024/04/Jadwal-dan-Daftar-Pilkada-Serentak-Tahun-2024.jpg" class="img-fluid" alt="Jadwal dan Daftar Pilkada Serentak Tahun 2024">
        <div class="my-4">
            <h3>Pemilihan Kepala Daerah (Pilkada) Serentak Tahun 2024</h3>
            <p>Pemilihan Kepala Daerah (Pilkada) serentak tahun 2024 telah segera dimulai. Pilkada ini terdiri dari Pemilihan Gubernur (Pilgub) dan Pemilihan Bupati (Pilbup), yang diselenggarakan secara bersamaan di beberapa daerah di Indonesia. Penyelenggaraan Pilkada ini telah diatur oleh Komisi Pemilihan Umum (KPU) sesuai dengan Peraturan KPU (PKPU) Nomor 2 Tahun 2024 tentang Tahapan dan Jadwal Pemilihan Gubernur dan Wakil Gubernur, Bupati dan Wakil Bupati, serta Walikota dan Wakil Walikota Tahun 2024.</p>

            <h3>Daerah yang Akan Melaksanakan Pilkada Serentak 2024</h3>
            <p>Jumlah Daerah yang melaksanakan Pilkada:</p>
            <ul>
                <li>37 provinsi (Gubernur)</li>
                <li>415 kabupaten (Bupati)</li>
                <li>93 kota (Walikota)</li>
            </ul>

            <!-- Added content about Syarat Nyoblos Pemilu 2024 -->
            <div class="my-4">
                <h3>Syarat Nyoblos Pemilu 2024</h3>
                <p>Persyaratan nyoblos atau menjadi pemilih diatur dalam PKPU Nomor 7 Tahun 2022. Berikut syarat menjadi pemilih yang harus dipenuhi agar bisa menggunakan hak pilihnya dalam Pemilu 2024.</p>
                <ul>
                    <li>Genap berumur 17 tahun atau lebih pada hari pemungutan suara, sudah kawin, atau sudah pernah kawin.</li>
                    <li>Tidak sedang dicabut hak pilihnya berdasarkan putusan pengadilan yang telah mempunyai kekuatan hukum tetap.</li>
                    <li>Berdomisili di wilayah Negara Kesatuan Republik Indonesia dibuktikan dengan KTP-el.</li>
                    <li>Berdomisili di luar negeri yang dibuktikan dengan KTP-el, paspor dan/atau Surat Perjalanan Laksana Paspor.</li>
                    <li>Dalam hal pemilih belum mempunyai KTP-el sebagaimana dimaksud dalam huruf c dan huruf d, dapat menggunakan Kartu Keluarga.</li>
                    <li>Tidak sedang menjadi prajurit Tentara Nasional Indonesia atau anggota Kepolisian Negara Republik Indonesia.</li>
                </ul>
                <p>KTP-el menjadi salah satu syarat untuk bisa menjadi pemilih. Lantas, bagaimana jika sudah berusia 17 tahun tapi belum memiliki KTP, apakah berarti tidak bisa ikut nyoblos?</p>
            </div>

            <h3>Tahapan Pilkada Serentak 2024</h3>
            <p>Tahapan Persiapan:</p>
            <ul>
                <li>Perencanaan program dan anggaran: Hingga 26 Januari 2024.</li>
                <li>Penyusunan peraturan penyelenggaraan pemilihan: Hingga 18 November 2024.</li>
                <li>Perencanaan penyelenggaraan yang meliputi penetapan tata cara dan jadwal tahapan pelaksanaan pemilihan: Hingga 18 November 2024.</li>
                <li>Pembentukan PPK, PPS, dan KPPS: 17 April-5 November 2024.</li>
                <li>Pembentukan panitia pengawas kecamatan, panitia pengawas lapangan, dan pengawas tempat pemungutan suara: Sesuai ketetapan Badan Pengawas Pemilu (Bawaslu).</li>
                <li>Pemberitahuan dan pendaftaran pemantau pemilihan: 27 Februari-16 November 2024.</li>
                <li>Penyerahan daftar penduduk potensial pemilih: 24 April-31 Mei 2024.</li>
                <li>Pemutakhiran dan penyusunan daftar pemilih: 31 Mei-23 September 2024.</li>
                <!-- Sisipkan tahapan-tahapan lainnya -->
            </ul>
            <p>Tahapan Penyelenggaraan:</p>
            <ul>
                <li>Pengumuman persyaratan dukungan pasangan calon perseorangan: 5 Mei-19 Agustus 2024.</li>
                <li>Pengumuman pendaftaran pasangan calon: 24-26 Agustus 2024.</li>
                <li>Pendaftaran pasangan calon: 27-29 Agustus 2024.</li>
                <li>Penelitian persyaratan calon: 27 Agustus-21 September 2024.</li>
                <li>Penetapan pasangan calon: 22 September 2024.</li>
                <li>Pelaksanaan kampanye: 25 September-23 November 2024.</li>
                <li>Pelaksanaan pemungutan suara: 27 November 2024.</li>
                <li>Penghitungan suara dan rekapitulasi hasil penghitungan suara: 27 November-16 Desember 2024.</li>
                <li>Penetapan Calon Terpilih: Paling lama 3 hari setelah Mahkamah Konstitusi secara resmi memberitahukan permohonan yang teregistrasi dalam Buku Registrasi Perkara Konstitusi (BRPK) kepada KPU.</li>
                <li>Penyelesaian Pelanggaran dan Sengketa Hasil Pemilihan: Paling lama 5 hari setelah salinan penetapan, putusan dismisal, atau putusan Mahkamah Konstitusi diterima oleh KPU.</li>
                <li>Pengusulan Pengesahan Pengangkatan Calon Terpilih: Paling lama 3 hari setelah penetapan pasangan calon terpilih.</li>
                <!-- Sisipkan tahapan-tahapan lainnya -->
            </ul>
            <h4>admin. (2024, April 25). Jadwal dan Jumlah Daerah Pilkada Serentak Tahun 2024 - Artikel Blog. <a href="https://www.linggapura.desa.id/artikel/2024/04/25/jadwal-dan-daftar-pilkada-serentak-tahun-2024/"> Artikel Blog.</a>
            </h4>
        </div>
    </div>

    <!-- Include FooterComponent -->
    <?php include '../../components/FooterComponent.php'; ?>

    <!-- Include Bootstrap JS and other scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="<?php echo $MainLink ?>src/dist/js/main.js"></script>
</body>

</html>