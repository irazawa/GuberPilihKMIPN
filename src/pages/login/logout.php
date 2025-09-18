<?php
session_start();

// Hapus semua variabel sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Bersihkan cookie
setcookie('user_id', '', time() - 3600, '/');
setcookie('username', '', time() - 3600, '/');

// Redirect ke halaman login atau halaman lain yang sesuai
header("Location: http://localhost/ibuki/");
exit;
