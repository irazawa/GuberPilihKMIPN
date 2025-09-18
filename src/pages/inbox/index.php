<?php
session_start();
include '../../config/config.php';

$isHomeActive = false;
$isCalonActive = false;
$isPartai = false;
$isTataCaraActive = false;
$isBeritaActive = false;
$isHubungiKamiActive = true; // Set active untuk halaman Hubungi Kami
$isProfil = false;
$isDashboard = false;
$isInboxActive = true; // Set active untuk halaman Hubungi Kami

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
    <title>Contact Us</title>
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
            /* To ensure content doesn't get hidden under the fixed header */
            background-image: linear-gradient(to bottom, #FFFFFF, #a6fbff);
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .input-group-text {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <!-- Include NavbarComponent -->
    <?php include '../../components/NavbarComponent.php'; ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <h1 class="text-center mb-4">Contact</h1>
                <form action="path_to_your_form_handler" method="post" class="card p-4 shadow">
                    <div class="mb-3">
                        <label for="username" class="form-label">Name</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Your name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="5" placeholder="Your message here" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>


    <!-- Include FooterComponent -->
    <?php include '../../components/FooterComponent.php'; ?>

    <!-- Include Bootstrap JS and other scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="<?php echo $MainLink ?>src/dist/js/main.js"></script>
</body>

</html>