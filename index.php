<?php
session_start();
include 'src/config/config.php';
// Query untuk mengambil data tim dari tabel 'team'
$query = "SELECT * FROM team";
$stmt = $pdo->query($query);

// Query untuk mengambil data partai dari tabel 'dbpartai'
$queryPartai = "SELECT * FROM dbpartai";
$stmtPartai = $pdo->query($queryPartai);

$isHomeActive = true;
$isCalonActive = false;
$isPartai = false;
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
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link rel="icon" href="src/data/w/1.svg">
    <link rel="stylesheet" href="maincss">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <?php include 'src/components/NavbarComponent.php'; ?>
    <!-- Main Content -->
    <!-- awalcrousel -->
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active position-relative">
                <img src="src/data/a/kantor-walikota-palembang-900x600.png" class="d-block w-100 object-fit-cover" alt="...">

                <!-- Overlay gradient -->
                <div class="position-absolute top-0 start-0 w-100 h-100"
                    style="background: linear-gradient(to bottom, rgba(0,0,0,0.5), rgba(0,0,0,0.8));">
                </div>

                <!-- Caption modern -->
                <div class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100 text-center">
                    <h2 class="display-4 fw-bold text-white animate__animated animate__fadeInDown">
                        Welcome to <span class="text-warning">Guberpilih Citizen Portal</span>
                    </h2>
                    <button type="button"
                        class="btn btn-lg btn-warning shadow-lg px-4 py-2 rounded-pill mt-3 animate__animated animate__fadeInUp"
                        onclick="window.location.href='register'">
                        <i class="bi bi-person-plus me-2"></i> Create Your Account
                    </button>
                    <p class="mt-3 text-light animate__animated animate__fadeInUp animate__delay-1s">
                        Already have an account?
                        <a href="login" class="fw-semibold text-decoration-none text-info">Login here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Akhir Carousel -->


    <!-- tentang aplikasi -->
    <div class="px-4 py-5 my-5 text-center">
        <img class="d-block mx-auto mb-4" src="<?php echo $MainLink ?>src/data/w/2.svg" alt="" width="150" height="auto">
        <h1 class="display-5 fw-bold text-body-emphasis">Calon Gubernur</h1>
        <div class="col-lg-6 mx-auto">
            <p class="lead mb-4">Aplikasi Web Calon Gubernur adalah platform digital inovatif yang dirancang untuk meningkatkan transparansi dan partisipasi publik dalam proses pemilihan gubernur. Aplikasi ini menyediakan akses mudah bagi masyarakat untuk mengenal lebih dekat para calon gubernur, visi misi mereka, rekam jejak, serta program kerja yang ditawarkan.</p>
        </div>
    </div>
    <!-- akhir tentang aplikasi -->

    <!-- Awal Card tentang -->
    <div class="bottom-box">
        <div class="container">
            <h1 class="team_h1">TEAM</h1>
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3 g-4 mt-3">
                    <?php
                    // Function to generate Lorem Ipsum text with name and description
                    function generateLorem($nama, $ket)
                    {
                        $lorem = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.";
                        return "$nama<br>$ket<br>" . substr($lorem, 0, 40);
                    }

                    // Loop through each team data row
                    $count = 0; // Counter to track card IDs
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $foto = $row['foto'];
                        $nama = $row['nama'];
                        $ket = $row['ket'];
                        $sos_ig = $row['sos_ig'];
                        $sos_twitter = $row['sos_twitter'];
                        $sos_fb = $row['sos_fb'];
                        $count++; // Increment the counter for each card
                    ?>
                        <div class="col">
                            <div class="accordion-item<?php echo ($count == 1) ? ' active' : ''; ?>" data-target="#flush-collapse<?php echo $count; ?>">
                                <div class="card profile-card-1">
                                    <img src="<?php echo $foto; ?>" alt="profile-sample1" class="background" />
                                    <img src="<?php echo $foto; ?>" alt="profile-image" class="profile" />
                                    <div class="card-content">
                                        <div class="name"><?php echo $nama; ?></div>
                                        <div class="description"><?php echo $ket; ?></div>
                                        <div class="icon-block">
                                            <?php if (!empty($sos_fb)) : ?>
                                                <a href="<?php echo $sos_fb; ?>" target="_blank"><i class="bi bi-facebook"></i></a>
                                            <?php endif; ?>
                                            <?php if (!empty($sos_twitter)) : ?>
                                                <a href="<?php echo $sos_twitter; ?>" target="_blank"><i class="bi bi-twitter-x"></i></a>
                                            <?php endif; ?>
                                            <?php if (!empty($sos_ig)) : ?>
                                                <a href="<?php echo $sos_ig; ?>" target="_blank"><i class="bi bi-instagram"></i></a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-collapse<?php echo ($count == 1) ? ' show' : ''; ?>">
                                    <div class="accordion-body<?php echo ($count % 2 == 0) ? ' right-to-left' : ''; ?>">

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- akhir card tentang -->
    <!-- Kontak -->
    <section id="kontak">
        <div class="container">
            <h1>Kontak</h1>
            <p>JI Srijaya Negara Bukit Besar Palembang 30139 <br>
                Telpon : +620711353414 <br>
                Fax: +62711355918 <br>
                Web: <a href="https://www.polsri.ac.id">polsri.ac.id</a><br>
                Email : info@polsri.ac.id</p>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7968.821254998066!2d104.7312443016235!3d-2.983431994609355!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e3b75ec487f021d%3A0x63054012aa39de4f!2sPOLITEKNIK%20NEGERI%20SRIWIJAYA%20(POLSRI)!5e0!3m2!1sid!2sid!4v1715788711235!5m2!1sid!2sid" width="500" height="auto" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>
    <!-- akhirKontak -->

    <?php include 'src/components/FooterComponent.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="<?php echo $MainLink ?>src/dist/js/main.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const accordionItems = document.querySelectorAll('.accordion-item');

            accordionItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Toggle the collapse state
                    const collapse = this.querySelector('.accordion-collapse');
                    collapse.classList.toggle('show');

                    // Collapse other items
                    accordionItems.forEach(accItem => {
                        if (accItem !== item) {
                            accItem.classList.remove('active');
                            accItem.querySelector('.accordion-collapse').classList.remove('show');
                            accItem.querySelector('.profile').classList.remove('collapsed-card');
                        }
                    });

                    // Collapse other images
                    const images = this.querySelectorAll('.profile');
                    images.forEach(img => {
                        if (img !== this.querySelector('.profile')) {
                            img.classList.add('collapsed-card');
                        }
                    });

                    // Add active class to the clicked item
                    this.classList.toggle('active');
                });
            });
        });
    </script>
</body>

</html>