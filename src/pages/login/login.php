<?php
// Start session
session_start();

// Include config.php to establish database connection
include '../../config/config.php';

// Base URL otomatis
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
    || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

// hanya ambil host, tanpa dirname
$MainLink = $protocol . $_SERVER['HTTP_HOST'] . '/';

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
    || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

$BaseURL = $protocol . $_SERVER['HTTP_HOST'] . '/'; // buat navigasi (Home, Calgub, Partai, dll.)
$AssetURL = $protocol . $_SERVER['HTTP_HOST'] . '/src/data/'; // khusus untuk asset (logo, gambar)

// Initialize variables
$usernameOrEmail = $password = '';
$errors = array();

// Jika pengguna telah login sebelumnya dengan opsi "remember me" dan cookie tersedia
if (isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
    // Mengisi nilai default untuk input username
    $usernameOrEmail = $_COOKIE['username'];
}

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data and sanitize inputs
    $usernameOrEmail = htmlspecialchars($_POST['usernameOrEmail']);
    $password = htmlspecialchars($_POST['password']);

    // Validate inputs (add your own validation rules)
    if (empty($usernameOrEmail)) {
        $errors['usernameOrEmail'] = "Username or email is required";
    }
    if (empty($password)) {
        $errors['password'] = "Password is required";
    }

    // Check if there are no validation errors
    if (empty($errors)) {
        try {
            // Prepare SQL statement to fetch user data from the database based on username or email
            $stmt = $pdo->prepare("SELECT * FROM tb_user WHERE username = :usernameOrEmail OR email = :usernameOrEmail");
            $stmt->execute(['usernameOrEmail' => $usernameOrEmail]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify password if user exists
            if ($user && password_verify($password, $user['password_hash'])) {
                // User authenticated successfully
                // Store user data in session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['foto_profile'] = $user['foto_profile'];
                $_SESSION['role'] = $user['role'];

                // Set cookie jika opsi "remember me" dicentang
                if (isset($_POST['remember'])) {
                    // Set waktu kedaluwarsa cookie (contoh: 1 minggu)
                    $cookie_expiration = time() + (7 * 24 * 60 * 60); // 1 minggu kedepan
                    // Simpan informasi pengguna dalam cookie
                    setcookie('user_id', $user['id'], $cookie_expiration, '/');
                    setcookie('username', $user['username'], $cookie_expiration, '/');
                    setcookie('foto_profile', $user['foto_profile'], $cookie_expiration, '/');
                    setcookie('role', $user['role'], $cookie_expiration, '/');
                }

                // Redirect to dashboard or any other page
                header("Location: http://localhost/ibuki/");
                exit();
            } else {
                // Add error message for invalid credentials
                $errors['general'][] = "Invalid username/email or password";
            }
        } catch (PDOException $e) {
            // Handle database errors
            $errors['general'][] = "Error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="logincss">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="icon" href="<?php echo $MainLink ?>src/data/w/1.svg">
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>
    <div>
        <div class="login-form">
            <form action="" method="post">
                <div class="logo">
                    <img src="<?php echo $AssetURL ?>src/data/w/2.svg" alt="Logo">
                </div>
                <div class="form-floating">
                    <div class="input-group">
                        <input type="text" class="form-control smaller-input <?php echo !empty($errors['usernameOrEmail']) ? 'is-invalid' : ''; ?>" name="usernameOrEmail" placeholder="Username or Email" value="<?php echo $usernameOrEmail; ?>">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                    </div>
                    <?php if (!empty($errors['usernameOrEmail'])) : ?>
                        <div class="invalid-feedback">
                            <?php echo $errors['usernameOrEmail']; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-floating">
                    <div class="input-group">
                        <input type="password" class="form-control smaller-input <?php echo !empty($errors['password']) ? 'is-invalid' : ''; ?>" id="floatingPassword" name="password" placeholder="Password">
                        <span class="input-group-text"><i class="bi bi-eye-slash" id="togglePassword"></i></span>
                    </div>
                    <?php if (!empty($errors['password'])) : ?>
                        <div class="invalid-feedback">
                            <?php echo $errors['password']; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-check text-start">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">
                        Remember me
                    </label>
                </div>
                <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
                <?php if (!empty($errors['general'])) : ?>
                    <div class="mt-3">
                        <ul class="text-danger">
                            <?php foreach ($errors['general'] as $error) : ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <div class="text-center mt-3">
                    Don't have an account? <a href="register">Register</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="<?php echo $MainLink ?>src/dist/js/login.js"></script>
</body>

</html>