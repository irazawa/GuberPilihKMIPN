<?php
// Include konfigurasi database dan mulai sesi
include '../../config/config.php';
session_start();

// Periksa izin pengguna
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'mod' && $_SESSION['role'] !== 'admin')) {
    // Termasuk halaman 403 Forbidden
    include '../../forbidden.php';
    // Berhenti eksekusi lebih lanjut
    exit;
}

// Periksa apakah parameter ID kandidat ada dalam URL
if (isset($_GET['id'])) {
    $candidate_id = $_GET['id'];

    // Menyiapkan query untuk mengambil detail kandidat
    $stmt = $pdo->prepare("SELECT * FROM dbcalgub WHERE id = ?");
    $stmt->execute([$candidate_id]);
    $candidate = $stmt->fetch(PDO::FETCH_ASSOC);

    // Periksa apakah kandidat ditemukan
    if (!$candidate) {
        // Jika kandidat tidak ditemukan, arahkan pengguna kembali ke halaman pengelolaan
        header("Location: manage #candidates");
        exit;
    }

    // Konfirmasi penghapusan
    if (isset($_POST['confirm_delete'])) {
        try {
            // Hapus data kandidat dari database
            $stmt = $pdo->prepare("DELETE FROM dbcalgub WHERE id = ?");
            $stmt->execute([$candidate_id]);

            // Redirect ke halaman pengelolaan untuk menghindari pengiriman formulir ulang saat merefresh halaman
            header("Location: manage #candidates");
            exit;
        } catch (PDOException $e) {
            // Tangani kesalahan koneksi database
            echo "Error deleting candidate: " . $e->getMessage();
        }
    }
} else {
    // Jika parameter ID kandidat tidak ada dalam URL, arahkan pengguna kembali ke halaman pengelolaan
    header("Location: manage #candidates");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Hapus Calon Gubernur</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <div class="container mt-5">
        <h1>Konfirmasi Hapus Calon Gubernur</h1>
        <p>Anda akan menghapus kandidat berikut:</p>
        <p>Nama: <?php echo htmlspecialchars($candidate['calgub']); ?></p>
        <p>Wakil: <?php echo htmlspecialchars($candidate['wacalgub']); ?></p>
        <p>Jika Anda yakin ingin melanjutkan, klik tombol "Hapus".</p>
        <form method="post">
            <button type="submit" class="btn btn-danger" name="confirm_delete">Hapus</button>
            <a href="manage #candidates" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>