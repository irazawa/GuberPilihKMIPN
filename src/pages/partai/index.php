<?php
session_start();
include '../../config/config.php';

// Query untuk mengambil data tim dari tabel 'team'
$query = "SELECT * FROM team";
$stmt = $pdo->query($query);

// Query untuk mengambil data partai dari tabel 'dbpartai'
$queryPartai = "SELECT * FROM dbpartai";
$stmtPartai = $pdo->query($queryPartai);

$isHomeActive = false;
$isCalonActive = false;
$isPartai = true;
$isTataCaraActive = false;
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
    <title>Partai</title>
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
    </style>
</head>

<body>
    <?php include '../../components/NavbarComponent.php'; ?>

    <!-- Container for political parties -->
    <div class="container mt-5">
        <h1 class="text-center mb-4">Political Parties in Indonesia</h1>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php
            // Loop through each political party data row
            while ($rowPartai = $stmtPartai->fetch(PDO::FETCH_ASSOC)) {
                $foto_partai = $rowPartai['foto_partai'];
                $nama_partai = $rowPartai['namo_partai'];
            ?>
                <!-- Card for each political party -->
                <div class="col">
                    <div class="card h-100 card-partai" style="background-image: url('<?php echo $MainLink ?>src/data/partai/<?php echo $foto_partai; ?>');">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo $nama_partai; ?></h5>
                            <button type="button" class="btn btn-transparent" data-nama-partai="<?php echo urlencode($nama_partai); ?>">Lihat Lebih Lanjut</button>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <?php include '../../components/FooterComponent.php'; ?>
    <!-- Akhir Container for political parties -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.querySelectorAll('.btn-transparent').forEach(button => {
            button.addEventListener('click', function() {
                const namaPartai = this.getAttribute('data-nama-partai');
                window.location.href = `calgub?partai=${namaPartai}`;
            });
        });
    </script>
</body>

</html>