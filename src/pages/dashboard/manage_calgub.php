<?php
// Start session if it hasn't been started yet
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user has moderator or admin role
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'mod' && $_SESSION['role'] !== 'admin')) {
    // Include 403 Forbidden page
    include '../../forbidden.php';
    // Stop further execution
    exit;
}

// Include database connection
include '../../config/config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Process form data
    $calgub = $_POST['calgub'];
    $wacalgub = $_POST['wacalgub'];
    $ket = isset($_POST['ket']) ? $_POST['ket'] : null;
    $visi = isset($_POST['visi']) ? nl2br($_POST['visi']) : null;
    $misi = isset($_POST['misi']) ? nl2br($_POST['misi']) : null;
    $partai_koalisi = isset($_POST['partai_koalisi']) ? $_POST['partai_koalisi'] : [];
    $partai_koalisi_string = implode(",", $partai_koalisi); // Convert array to string
    $jml_suara = isset($_POST['jml_suara']) ? $_POST['jml_suara'] : null;
    $calgub_bio = isset($_POST['calgub_bio']) ? nl2br($_POST['calgub_bio']) : null;
    $calgub_pendidikan = isset($_POST['calgub_pendidikan']) ? nl2br($_POST['calgub_pendidikan']) : null;
    $calgub_penghargaan = isset($_POST['calgub_penghargaan']) ? nl2br($_POST['calgub_penghargaan']) : null;
    $wacalgub_bio = isset($_POST['wacalgub_bio']) ? nl2br($_POST['wacalgub_bio']) : null;
    $wacalgub_pendidikan = isset($_POST['wacalgub_pendidikan']) ? nl2br($_POST['wacalgub_pendidikan']) : null;

    // Upload photos
    $upload_date = date('Y-m-d');
    $upload_dir = "../../data/calgub/$upload_date";

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $foto_calgun_name = $_FILES['foto_calgun']['name'];
    $foto_calgun_temp = $_FILES['foto_calgun']['tmp_name'];
    $foto_calgun_destination = "$upload_dir/" . $foto_calgun_name;
    move_uploaded_file($foto_calgun_temp, $foto_calgun_destination);

    $foto_wacalgub_name = $_FILES['foto_wacalgub']['name'];
    $foto_wacalgub_temp = $_FILES['foto_wacalgub']['tmp_name'];
    $foto_wacalgub_destination = "$upload_dir/" . $foto_wacalgub_name;
    move_uploaded_file($foto_wacalgub_temp, $foto_wacalgub_destination);

    try {
        // Insert candidate data into database
        $stmt = $pdo->prepare("INSERT INTO dbcalgub (calgub, wacalgub, ket, visi, misi, partai_koalisi, jml_suara, calgub_bio, calgub_pendidikan, calgub_penghargaan, wacalgub_bio, wacalgub_pendidikan, foto_calgun, foto_wacalgub) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$calgub, $wacalgub, $ket, $visi, $misi, $partai_koalisi_string, $jml_suara, $calgub_bio, $calgub_pendidikan, $calgub_penghargaan, $wacalgub_bio, $wacalgub_pendidikan, "$upload_date/$foto_calgun_name", "$upload_date/$foto_wacalgub_name"]);

        // Redirect to avoid form resubmission on page refresh
        header("Location: manage #candidates");
        exit;
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
}

try {
    // Fetch data kandidat dari database
    $stmt = $pdo->query("SELECT c.*, GROUP_CONCAT(p.namo_partai) AS nama_partai
                        FROM dbcalgub c
                        JOIN dbpartai p ON FIND_IN_SET(p.Id, c.partai_koalisi)
                        GROUP BY c.id");

    // Menampilkan kandidat dalam tabel
    echo '<table class="table table-hover">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">Foto Calon Gubernur</th>';
    echo '<th scope="col">Nama Calon Gubernur</th>';
    echo '<th scope="col">Foto Wakil Calon Gubernur</th>';
    echo '<th scope="col">Nama Wakil Calon Gubernur</th>';
    echo '<th scope="col">Keterangan</th>';
    echo '<th scope="col">Visi</th>';
    echo '<th scope="col">Misi</th>';
    echo '<th scope="col">Partai Koalisi</th>';
    echo '<th scope="col">Jumlah Suara</th>';
    echo '<th scope="col">Biografi Calon Gubernur</th>';
    echo '<th scope="col">Pendidikan Calon Gubernur</th>';
    echo '<th scope="col">Penghargaan Calon Gubernur</th>';
    echo '<th scope="col">Biografi Wakil Calon Gubernur</th>';
    echo '<th scope="col">Pendidikan Wakil Calon Gubernur</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    function truncateText($text, $maxLength)
    {
        return strlen($text) > $maxLength ? substr($text, 0, $maxLength) . '...' : $text;
    }

    foreach ($stmt as $row) {
        echo '<tr>';
        echo '<td><img src="../../data/calgub/' . $row['foto_calgun'] . '" class="img-thumbnail" alt="Foto Calon Gubernur" style="max-width: 100px;"></td>';
        echo '<td>' . $row['calgub'] . '</td>';
        echo '<td><img src="../../data/calgub/' . $row['foto_wacalgub'] . '" class="img-thumbnail" alt="Foto Wakil Calon Gubernur" style="max-width: 100px;"></td>';
        echo '<td>' . $row['wacalgub'] . '</td>';
        echo '<td class="truncate">' . truncateText($row['ket'], 50) . '</td>';
        echo '<td class="truncate">' . truncateText($row['visi'], 50) . '</td>';
        echo '<td class="truncate">' . truncateText($row['misi'], 50) . '</td>';
        echo '<td class="truncate">' . truncateText($row['nama_partai'], 50) . '</td>'; // Menampilkan nama partai
        echo '<td>' . $row['jml_suara'] . '</td>';
        echo '<td class="truncate">' . truncateText($row['calgub_bio'], 50) . '</td>';
        echo '<td class="truncate">' . truncateText($row['calgub_pendidikan'], 50) . '</td>';
        echo '<td class="truncate">' . truncateText($row['calgub_penghargaan'], 50) . '</td>';
        echo '<td class="truncate">' . truncateText($row['wacalgub_bio'], 50) . '</td>';
        echo '<td class="truncate">' . truncateText($row['wacalgub_pendidikan'], 50) . '</td>';
        // Tombol Edit dan Delete
        echo '<td><a href="edit_calgub?id=' . $row['id'] . '" class="btn btn-primary btn-sm">Edit</a></td>';
        echo '<td><a href="delete_calgub?id=' . $row['id'] . '" class="btn btn-danger btn-sm">Delete</a></td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
} catch (PDOException $e) {
    // Tangani kesalahan koneksi database
    echo "Error fetching candidates: " . $e->getMessage();
}
