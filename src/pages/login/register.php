<?php
include '../../config/config.php';
// Base URL otomatis
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
    || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

// hanya ambil host, tanpa dirname
$MainLink = $protocol . $_SERVER['HTTP_HOST'] . '/';

$username = $email = $password = '';
$usernameError = $emailError = $passwordError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    if (empty($username)) {
        $usernameError = "Username is required";
    } else {
        // Check if username already exists
        $stmt = $pdo->prepare("SELECT * FROM tb_user WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $usernameError = "Username is already taken";
        }
    }

    if (empty($email)) {
        $emailError = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Invalid email format";
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT * FROM tb_user WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $emailError = "Email is already registered";
        }
    }

    if (empty($password)) {
        $passwordError = "Password is required";
    } elseif (strlen($password) < 8 || !preg_match("/[!@#$%^&*()-=_+]/", $password)) {
        $passwordError = "Password must be at least 8 characters long and contain at least one special character";
    }

    if (empty($usernameError) && empty($emailError) && empty($passwordError)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        try {
            $stmt = $pdo->prepare("INSERT INTO tb_user (username, email, password_hash) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashed_password]);
            header("Location: http://localhost/ibuki/login");
            exit();
        } catch (PDOException $e) {
            // Jangan tampilkan pesan error asli ke user
            $usernameError = "Terjadi kesalahan. Silakan coba lagi nanti.";

            // Opsional: log error ke file (untuk developer saja)
            error_log("Database insert error: " . $e->getMessage());
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="logincss">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="icon" href="<?php echo $MainLink ?>src/data/w/1.svg">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card" style="background-color: rgba(255, 255, 255, 0.3);">
                    <div class="card-body">
                        <div class="logo text-center mb-4">
                            <img src="<?php echo $MainLink ?>src/data/w/2.svg" alt="Logo">
                        </div>
                        <form method="post" action="" novalidate>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username:</label>
                                <input type="text" class="form-control <?php if (!empty($usernameError)) echo 'is-invalid'; ?>" id="username" name="username" value="<?php echo $username; ?>" required>
                                <div class="invalid-feedback">
                                    <?php echo $usernameError; ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control <?php if (!empty($emailError)) echo 'is-invalid'; ?>" id="email" name="email" value="<?php echo $email; ?>" required>
                                <div class="invalid-feedback">
                                    <?php echo $emailError; ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" class="form-control <?php if (!empty($passwordError)) echo 'is-invalid'; ?>" id="password" name="password" required>
                                <div class="invalid-feedback">
                                    <?php echo $passwordError; ?>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="<?php echo $MainLink ?>src/dist/js/login.js"></script>
</body>


</html>