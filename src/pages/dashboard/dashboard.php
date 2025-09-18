<?php
session_start();

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex" />
    <title>Dashboard</title>
    <link rel="icon" href="../../data/w/ico.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preload" href="https://site.com/non-critical-styles.css" as="style" />
    <link rel="stylesheet" type="text/css" href="https://site.com/non-critical-styles.css" media="print" onload="this.media='all'" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="../../dist/css/dashboard.css">
</head>

<body>
    <main>
        <div class="container mt-2">
            <div class="jumbotron">
                <h1 class="display-4 text-center">Dashboard</h1>
                <p class="lead text-center"></p>
                <hr class="my-4">
            </div>
        </div>
        <div class="container text-dark">
            <div class="row">
                <?php
                if (
                    isset($_SESSION['role']) && ($_SESSION['role'] === 'admin')
                ) {
                ?>
                    <div class="col-md-4 mb-3">
                        <a href="#" class="custom-card" data-bs-toggle="modal" data-bs-target="#passwordModal">
                            <div class="card-icon">
                                <span class="fa fa-user"></span>
                            </div>
                            <div class="card-title-wrap">
                                <h3 class="card-title">Manage User</h3>
                                <h4 class="card-subtitle"></h4>
                            </div>
                            <span class="card-color-fill"></span>
                        </a>
                    </div>
                <?php
                }
                ?>
                <div class="col-md-4 mb-3">
                    <a href="manage#manage-parties" class="custom-card">
                        <div class="card-icon">
                            <span class="fa fa-building"></span> <!-- Ganti ikon dengan yang sesuai -->
                        </div>
                        <div class="card-title-wrap">
                            <h3 class="card-title">Manage Partai</h3>
                            <h4 class="card-subtitle"></h4>
                        </div>
                        <div class="card-body">
                            <div class="card-desc"></div>
                            <div class="card-info"></div>
                        </div>
                        <span class="card-color-fill"></span>
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="manage#candidates" class="custom-card">
                        <div class="card-icon">
                            <span class="fa fa-users"></span> <!-- Ganti ikon dengan yang sesuai -->
                        </div>
                        <div class="card-title-wrap">
                            <h3 class="card-title">Manage Candidates</h3>
                            <h4 class="card-subtitle"></h4>
                        </div>
                        <div class="card-body">
                            <div class="card-desc"></div>
                            <div class="card-info"></div>
                        </div>
                        <span class="card-color-fill"></span>
                    </a>
                </div>
            </div>
        </div>
    </main>


</body>

</html>