<?php
session_start();
include '../../config/config.php';
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
    || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

$MainLink = $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/';

$isHomeActive = false;
$isCalonActive = true;
$isPartai = false;
$isTataCaraActive = false;
$isBeritaActive = false;
$isHubungiKamiActive = false;
$isProfil = false;

// Fungsi untuk mendapatkan detail profil dari database berdasarkan nama
function getProfileByName($name, $pdo)
{
    // Query untuk mendapatkan detail profil calon gubernur atau wakil gubernur dari database
    $stmt = $pdo->prepare("SELECT c.*, GROUP_CONCAT(p.namo_partai) AS partai_koalisi
                        FROM dbcalgub c
                        JOIN dbpartai p ON FIND_IN_SET(p.Id, c.partai_koalisi)
                        WHERE c.calgub = :name OR c.wacalgub = :name
                        GROUP BY c.id");
    $stmt->execute(['name' => $name]);
    $profile = $stmt->fetch(PDO::FETCH_ASSOC);

    return $profile;
}

// Dapatkan nama dari URL
$name = isset($_GET['name']) ? $_GET['name'] : '';

// Cek apakah profil ada
$profile = getProfileByName($name, $pdo);

// Jika tidak ada profil yang ditemukan, tampilkan pesan
if (!$profile) {
    echo "Profil tidak ditemukan.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link rel="icon" href="src/data/w/1.svg">
    <link rel="stylesheet" href="<?php echo $MainLink ?>src/dist/css/calgubdetail.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <?php include '../../components/NavbarComponent.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center">Detail Profil: <?php echo $profile['calgub']; ?> & <?php echo $profile['wacalgub']; ?></h1>
        <div class="row justify-content-center">
            <!-- Card untuk informasi Partai Koalisi -->
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Partai Koalisi</h5>
                        <p class="card-text"><?php echo $profile['partai_koalisi']; ?></p>
                    </div>
                </div>
            </div>
            <!-- Card untuk informasi Visi -->
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Visi</h5>
                        <p class="card-text"><?php echo nl2br($profile['visi']); ?></p>
                    </div>
                </div>
            </div>
            <!-- Card untuk informasi Jumlah Suara -->
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Suara</h5>
                        <p class="card-text"><?php echo $profile['jml_suara']; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card profile-card-1">
                    <img src="<?php echo $MainLink . 'src/data/calgub/' . $profile['foto_calgun']; ?>" alt="profile-image" class="profile" />
                    <div class="card-content">
                        <h2 class="name">Calon Gubernur</h2>
                        <div class="name">
                            <h5><?php echo $profile['calgub']; ?></h5>
                        </div>
                        <div class="biografi">
                            <h4>Biografi</h4>
                            <p><?php echo nl2br($profile['calgub_bio']); ?></p>
                        </div>
                        <div class="pendidikan">
                            <h4>Pendidikan</h4>
                            <p><?php echo $profile['calgub_pendidikan']; ?></p>
                        </div>
                        <div class="penghargaan">
                            <h4>Penghargaan</h4>
                            <p><?php echo $profile['calgub_penghargaan']; ?></p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card profile-card-1">
                    <img src="<?php echo $MainLink . 'src/data/calgub/' . $profile['foto_wacalgub']; ?>" alt="profile-image" class="profile" />
                    <div class="card-content">
                        <h2>Wakil Calon Gubernur</h2>
                        <div class="name">
                            <h5><?php echo $profile['wacalgub']; ?></h5>
                        </div>
                        <div class="biografi">
                            <h4>Biografi</h4>
                            <p><?php echo nl2br($profile['wacalgub_bio']); ?></p>
                        </div>
                        <div class="pendidikan">
                            <h4>Pendidikan</h4>
                            <p><?php echo $profile['wacalgub_pendidikan']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../../components/FooterComponent.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="<?php echo $MainLink ?>src/dist/js/main.js"></script>
</body>

</html>