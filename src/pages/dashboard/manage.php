<?php
session_start();

if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = array(); // Inisialisasi array pengguna jika belum ada
}

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'mod')) {
    // Cek apakah role adalah 'regular'
    if ($_SESSION['role'] === 'regular') {
        header('Location: ../../../');
        exit;
    } else {
        // Jika tidak memenuhi kondisi di atas, arahkan ke home.php
        header('Location: ../../../');
        exit;
    }
}

$isHomeActive = false;
$isCalonActive = false;
$isPartai = false;
$isTataCaraActive = false;
$isBeritaActive = false;
$isHubungiKamiActive = false;
$isProfil = false;
$isDashboard = true;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="../../data/w/ico.svg">
    <link rel="stylesheet" href="../../dist/css/dashboard.css">
    <link rel="stylesheet" href="../../dist/css/main.css">
    <style>
        body {
            padding-top: 100px;
            /* To ensure content doesn't get hidden under the fixed header */
        }

        /* Style untuk pesan 404 */
        #not-found {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            background-color: #f8d7da;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
    <?php include '../../components/NavbarComponent.php'; ?>

    <div class="container mt-5" id="manage-parties" style="display: none;">
        <h2>Add New Partai</h2>
        <form action="manage_partai.php" method="post" enctype="multipart/form-data">
            <div class="input-group mb-3">
                <span class="input-group-text">Nama Partai</span>
                <input type="text" class="form-control" name="nama_partai" required>
            </div>
            <div class="input-group mb-3">
                <input type="file" class="form-control" name="foto_partai" required>
                <label class="input-group-text">Foto Partai</label>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Tambahkan</button>
        </form>

        <hr>

        <h2>List of Partai</h2>
        <div class="row row-cols-2 row-cols-md-4 g-5">
            <?php include 'manage_partai.php'; ?>
        </div>
    </div>

    <div class="container mt-5" id="candidates" style="display: none;">
        <h2>Add New Candidate</h2>
        <form action="manage_calgub.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="calgub" class="form-label">Nama Calon Gubernur</label>
                <input type="text" class="form-control" id="calgub" name="calgub" required>
            </div>
            <div class="mb-3">
                <label for="wacalgub" class="form-label">Nama Wakil Calon Gubernur</label>
                <input type="text" class="form-control" id="wacalgub" name="wacalgub" required>
            </div>
            <div class="mb-3">
                <label for="ket" class="form-label">Keterangan</label>
                <textarea class="form-control" id="ket" name="ket" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="visi" class="form-label">Visi</label>
                <textarea class="form-control" id="visi" name="visi" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="misi" class="form-label">Misi</label>
                <textarea class="form-control" id="misi" name="misi" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Partai Koalisi</label>
                <div>
                    <?php
                    try {
                        // Query to fetch party data from dbpartai table
                        $stmt = $pdo->query("SELECT * FROM dbpartai");

                        // Pastikan $_POST['partai_koalisi'] ada dan merupakan array sebelum menggunakannya
                        $partai_koalisi = isset($_POST['partai_koalisi']) ? $_POST['partai_koalisi'] : array();

                        // Loop through each row and display party name as a checkbox
                        foreach ($stmt as $row) {
                            // Periksa apakah ID partai ada dalam array $_POST['partai_koalisi']
                            $checked = in_array($row['Id'], $partai_koalisi) ? 'checked' : '';
                            echo '<div class="form-check form-check-inline">';
                            echo '<input class="form-check-input" type="checkbox" id="partai_' . $row['Id'] . '" name="partai_koalisi[]" value="' . $row['Id'] . '" ' . $checked . '>';
                            echo '<label class="form-check-label" for="partai_' . $row['Id'] . '">' . $row['namo_partai'] . '</label>';
                            echo '</div>';
                        }
                    } catch (PDOException $e) {
                        // Handle database connection errors
                        echo "Error fetching parties: " . $e->getMessage();
                    }
                    ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="jml_suara" class="form-label">Jumlah Suara</label>
                <input type="number" class="form-control" id="jml_suara" name="jml_suara">
            </div>
            <div class="mb-3">
                <label for="calgub_bio" class="form-label">Biografi Calon Gubernur</label>
                <textarea class="form-control" id="calgub_bio" name="calgub_bio" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="calgub_pendidikan" class="form-label">Pendidikan Calon Gubernur</label>
                <textarea class="form-control" id="calgub_pendidikan" name="calgub_pendidikan" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="calgub_penghargaan" class="form-label">Penghargaan Calon Gubernur</label>
                <textarea class="form-control" id="calgub_penghargaan" name="calgub_penghargaan" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="wacalgub_bio" class="form-label">Biografi Wakil Calon Gubernur</label>
                <textarea class="form-control" id="wacalgub_bio" name="wacalgub_bio" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="wacalgub_pendidikan" class="form-label">Pendidikan Wakil Calon Gubernur</label>
                <textarea class="form-control" id="wacalgub_pendidikan" name="wacalgub_pendidikan" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="foto_calgun" class="form-label">Foto Calon Gubernur</label>
                <input type="file" class="form-control" id="foto_calgun" name="foto_calgun" required accept="image/*">
            </div>
            <div class="mb-3">
                <label for="foto_wacalgub" class="form-label">Foto Wakil Calon Gubernur</label>
                <input type="file" class="form-control" id="foto_wacalgub" name="foto_wacalgub" required accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Tambahkan</button>
        </form>
        <hr>

        <div class="container">
            <h2>List of Candidates</h2>
            <div class="table-responsive">
                <!-- Include PHP script to display list of candidates -->
                <?php include 'manage_calgub.php'; ?>
            </div>
        </div>
    </div>


    <!-- 404 Not Found message -->
    <div id="not-found" style="display: none;">
        <h1>404 Not Found</h1>
        <p>The page you are looking for does not exist.</p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../../dist/js/main.js"></script>

    <script>
        $(document).ready(function() {
            if (!window.location.hash) {
                // Jika tidak ada hash dalam URL, tampilkan pesan 404 Not Found
                $('#not-found').show();
            } else if (window.location.hash === '#manage-parties') {
                $('#manage-parties').show();
            } else if (window.location.hash === '#candidates') {
                $('#candidates').show();
            }
        });
        $(document).ready(function() {
            $('.delete-btn').click(function() {
                var partyId = $(this).data('id');
                var partyName = $(this).data('name');
                if (confirm("Apakah Anda yakin ingin menghapus partai " + partyName + "?")) {
                    $.ajax({
                        url: 'delete_partai.php',
                        method: 'POST',
                        data: {
                            partyId: partyId
                        },
                        success: function(response) {
                            if (response == 'success') {
                                // Hapus elemen dari DOM jika penghapusan berhasil
                                $('[data-id="' + partyId + '"]').closest('.col').remove();
                            } else {
                                alert('Ok');
                                window.location.reload()
                            }
                        }
                    });
                }
            });
        });
        $(document).ready(function() {
            $('.modal').modal();
        });
    </script>

</body>

</html>