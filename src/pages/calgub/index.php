<?php
session_start();
include '../../config/config.php';

$isHomeActive = false;
$isCalonActive = true;
$isPartai = false;
$isTataCaraActive = false;
$isBeritaActive = false;
$isHubungiKamiActive = false;
$isProfil = false;

// Set data pengguna ke dalam sesi jika belum ada
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = array(); // Inisialisasi array pengguna jika belum ada
}
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$foto_profile = isset($_SESSION['foto_profile']) ? $_SESSION['foto_profile'] : 'src/data/users/default_profile.png';

// Ambil parameter partai dari URL
$selectedPartyName = isset($_GET['partai']) ? urldecode($_GET['partai']) : null;

$query = "SELECT c.*, GROUP_CONCAT(p.namo_partai SEPARATOR ', ') AS partai_koalisi
            FROM dbcalgub c
            LEFT JOIN dbpartai p ON FIND_IN_SET(p.Id, c.partai_koalisi)";

// Jika ada parameter partai, tambahkan kondisi filter ke query
if ($selectedPartyName) {
    $query .= " WHERE FIND_IN_SET((SELECT Id FROM dbpartai WHERE namo_partai = :partaiName), c.partai_koalisi)";
}

$query .= " GROUP BY c.id";
$stmt = $pdo->prepare($query);

if ($selectedPartyName) {
    $stmt->bindParam(':partaiName', $selectedPartyName);
}

$stmt->execute();
$candidates = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calon Gubernur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link rel="icon" href="src/data/w/1.svg">
    <link rel="stylesheet" href="maincss">
    <link rel="stylesheet" href="<?php echo $MainLink ?>src/dist/css/main.css">
    <style>
        body {
            padding-top: 150px;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <?php include '../../components/NavbarComponent.php'; ?>

    <!-- Awal Card tentang -->
    <div class="bottom-box mt-5">
        <div class="container">
            <h1 class="team_h1">Calon Gubernur</h1>
            <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3 g-4 mt-3">
                <?php foreach ($candidates as $candidate) : ?>
                    <div class="col">
                        <a href="detail?name=<?php echo urlencode($candidate['calgub']); ?>">
                            <div class="accordion-item" data-target="#flush-collapse">
                                <div class="card profile-card-1">
                                    <img src="<?php echo $MainLink . 'src/data/calgub/' . $candidate['foto_calgun']; ?>" alt="profile-sample1" class="background" />
                                    <img src="<?php echo $MainLink . 'src/data/calgub/' . $candidate['foto_calgun']; ?>" alt="profile-image" class="profile" />
                                    <div class="card-content">
                                        <div class="name"><?php echo $candidate['calgub']; ?></div>
                                        <div class="partai"><?php echo $candidate['partai_koalisi']; ?></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!-- akhir card tentang -->

    <?php include '../../components/FooterComponent.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="<?php echo $MainLink ?>src/dist/js/main.js"></script>
</body>

</html>