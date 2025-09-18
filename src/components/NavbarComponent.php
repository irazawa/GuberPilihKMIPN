<?php
// Base URL otomatis
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
    || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

// hanya ambil host, tanpa dirname
$MainLink = $protocol . $_SERVER['HTTP_HOST'] . '/';

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
    || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

$BaseURL = $protocol . $_SERVER['HTTP_HOST'] . '/'; // buat navigasi (Home, Calgub, Partai, dll.)
$AssetURL = $protocol . $_SERVER['HTTP_HOST'] . '/src/data/'; // khusus untuk asset (logo, gambar)

?>

<!-- Desktop Navbar -->
<nav class="hidden lg:block fixed top-0 left-0 w-full backdrop-blur-md bg-white/70 shadow z-50">
    <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-3">
        <!-- Logo -->
        <a href="<?php echo $BaseURL ?>" class="flex items-center gap-2">
            <img src="<?php echo $AssetURL ?>w/Ibuki1.png" alt="Logo" class="h-12">
        </a>

        <!-- Nav Links -->
        <ul class="flex items-center gap-6 font-medium">
            <li><a href="<?php echo $MainLink ?>" class="px-3 py-2 rounded-lg transition <?php echo $isHomeActive ? 'bg-gradient-to-r from-blue-600 to-cyan-500 text-white' : 'hover:text-blue-600'; ?>">Home</a></li>
            <li><a href="<?php echo $MainLink ?>calgub" class="px-3 py-2 rounded-lg transition <?php echo $isCalonActive ? 'bg-gradient-to-r from-blue-600 to-cyan-500 text-white' : 'hover:text-blue-600'; ?>">Calon</a></li>
            <li><a href="<?php echo $MainLink ?>partai" class="px-3 py-2 rounded-lg transition <?php echo $isPartai ? 'bg-gradient-to-r from-blue-600 to-cyan-500 text-white' : 'hover:text-blue-600'; ?>">Partai</a></li>
            <li><a href="<?php echo $MainLink ?>tatacara" class="px-3 py-2 rounded-lg transition <?php echo $isTataCaraActive ? 'bg-gradient-to-r from-blue-600 to-cyan-500 text-white' : 'hover:text-blue-600'; ?>">Tata Cara</a></li>
            <li><a href="<?php echo $MainLink ?>inbox" class="px-3 py-2 rounded-lg transition <?php echo $isInboxActive ? 'bg-gradient-to-r from-blue-600 to-cyan-500 text-white' : 'hover:text-blue-600'; ?>">Contact</a></li>

            <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'mod')) : ?>
                <li><a href="<?php echo $MainLink ?>src/pages/dashboard/dashboard" class="px-3 py-2 rounded-lg transition <?php echo $isDashboard ? 'bg-gradient-to-r from-blue-600 to-cyan-500 text-white' : 'hover:text-blue-600'; ?>">Dashboard</a></li>
            <?php endif; ?>
        </ul>

        <!-- Profile Avatar -->
        <div class="relative group">
            <a href="<?php echo $MainLink ?>login">
                <img src="<?php echo $MainLink ?><?php echo $_SESSION['foto_profile'] ?? 'src/data/users/default_profile.png'; ?>" alt="User" class="h-10 w-10 rounded-full border-2 border-white shadow-md cursor-pointer">
            </a>
        </div>
    </div>
</nav>

<!-- Mobile Navbar -->
<header class="lg:hidden fixed top-0 left-0 w-full bg-white/90 backdrop-blur-md shadow z-50">
    <div class="flex items-center justify-between px-4 py-3">
        <button class="text-gray-700 focus:outline-none" onclick="document.getElementById('offcanvas').classList.toggle('translate-x-0')">
            <i class="bi bi-list text-3xl"></i>
        </button>
        <img src="<?php echo $MainLink ?>src/data/w/1.svg" alt="Logo" class="h-12">
        <a href="<?php echo $MainLink ?>login">
            <img src="<?php echo $MainLink ?><?php echo $_SESSION['foto_profile'] ?? 'src/data/users/default_profile.png'; ?>" alt="User" class="h-10 w-10 rounded-full border-2 border-white shadow-md cursor-pointer">
        </a>
    </div>
</header>

<!-- Offcanvas Mobile Menu -->
<div id="offcanvas" class="fixed top-0 left-0 w-64 h-full bg-gradient-to-b from-blue-600 to-cyan-500 text-white transform -translate-x-full transition-transform duration-300 z-50">
    <div class="flex items-center justify-between p-4">
        <span class="text-lg font-bold">Menu</span>
        <button onclick="document.getElementById('offcanvas').classList.toggle('translate-x-0')">
            <i class="bi bi-x-lg text-xl"></i>
        </button>
    </div>
    <ul class="flex flex-col gap-2 px-4 mt-4 font-medium">
        <li><a href="<?php echo $MainLink ?>" class="flex items-center gap-2 px-4 py-2 rounded-md transition hover:bg-white/20 <?php echo $isHomeActive ? 'bg-white/30' : ''; ?>"><i class="bi bi-house-door-fill"></i> Home</a></li>
        <li><a href="<?php echo $MainLink ?>calgub" class="flex items-center gap-2 px-4 py-2 rounded-md transition hover:bg-white/20 <?php echo $isCalonActive ? 'bg-white/30' : ''; ?>"><i class="bi bi-people-fill"></i> Calon</a></li>
        <li><a href="<?php echo $MainLink ?>partai" class="flex items-center gap-2 px-4 py-2 rounded-md transition hover:bg-white/20 <?php echo $isPartai ? 'bg-white/30' : ''; ?>"><i class="bi bi-person-lines-fill"></i> Partai</a></li>
        <li><a href="<?php echo $MainLink ?>tatacara" class="flex items-center gap-2 px-4 py-2 rounded-md transition hover:bg-white/20 <?php echo $isTataCaraActive ? 'bg-white/30' : ''; ?>"><i class="bi bi-list-ul"></i> Tata Cara</a></li>
        <li><a href="<?php echo $MainLink ?>inbox" class="flex items-center gap-2 px-4 py-2 rounded-md transition hover:bg-white/20 <?php echo $isInboxActive ? 'bg-white/30' : ''; ?>"><i class="bi bi-telephone-fill"></i> Contact</a></li>

        <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'mod')) : ?>
            <li><a href="<?php echo $MainLink ?>src/pages/dashboard/dashboard" class="flex items-center gap-2 px-4 py-2 rounded-md transition hover:bg-white/20 <?php echo $isDashboard ? 'bg-white/30' : ''; ?>"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
        <?php endif; ?>

        <hr class="border-white/40 my-2">

        <?php if (isset($_SESSION['user_id'])) : ?>
            <li><a href="<?php echo $MainLink ?>logout" class="flex items-center gap-2 px-4 py-2 rounded-md transition hover:bg-red-600/70"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
        <?php else : ?>
            <li><a href="<?php echo $MainLink ?>login" class="flex items-center gap-2 px-4 py-2 rounded-md transition hover:bg-green-600/70"><i class="bi bi-box-arrow-in-right"></i> Login</a></li>
        <?php endif; ?>
    </ul>
</div>