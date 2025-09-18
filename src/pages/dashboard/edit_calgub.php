<?php
// Start session if it hasn't been started yet
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user has moderator or admin role
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'mod' && $_SESSION['role'] !== 'admin')) {
    // Include 403 Forbidden page
    include '../../forbidden.php';
    // Stop further execution
    exit;
}
// Include necessary files and start session
include '../../config/config.php';

// Check if user has moderator or admin role
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'mod' && $_SESSION['role'] !== 'admin')) {
    // Include 403 Forbidden page
    include '../../forbidden.php';
    // Stop further execution
    exit;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Process form data
    // Retrieve candidate ID from the URL
    $candidate_id = $_GET['id'];

    $calgub = $_POST['calgub'];
    $wacalgub = $_POST['wacalgub'];
    $ket = isset($_POST['ket']) ? $_POST['ket'] : null;
    $visi = isset($_POST['visi']) ? nl2br($_POST['visi']) : null;
    $misi = isset($_POST['misi']) ? nl2br($_POST['misi']) : null;
    $partai_koalisi = isset($_POST['partai_koalisi']) ? $_POST['partai_koalisi'] : [];
    $partai_koalisi_string = implode(",", $partai_koalisi); // Convert array to string
    $jml_suara = isset($_POST['jml_suara']) ? $_POST['jml_suara'] : null;
    $calgub_bio = isset($_POST['calgub_bio']) ? nl2br($_POST['calgub_bio']) : null;
    $calgub_pendidikan = isset($_POST['calgub_pendidikan']) ? nl2br($_POST['calgub_pendidikan']) : null;
    $calgub_penghargaan = isset($_POST['calgub_penghargaan']) ? nl2br($_POST['calgub_penghargaan']) : null;
    $wacalgub_bio = isset($_POST['wacalgub_bio']) ? nl2br($_POST['wacalgub_bio']) : null;
    $wacalgub_pendidikan = isset($_POST['wacalgub_pendidikan']) ? nl2br($_POST['wacalgub_pendidikan']) : null;

    // Upload photos
    $upload_date = date('Y-m-d');
    $upload_dir = "../../data/calgub/$upload_date";

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Check if the photo inputs are not empty
    if (!empty($_FILES['foto_calgun']['name'])) {
        $foto_calgun_name = $_FILES['foto_calgun']['name'];
        $foto_calgun_temp = $_FILES['foto_calgun']['tmp_name'];
        $foto_calgun_destination = "$upload_dir/" . $foto_calgun_name;
        move_uploaded_file($foto_calgun_temp, $foto_calgun_destination);
        $foto_calgun_path = "$upload_date/$foto_calgun_name";
    } else {
        // If the photo input is empty, use the existing photo
        $foto_calgun_path = $candidate['foto_calgun'];
    }

    if (!empty($_FILES['foto_wacalgub']['name'])) {
        $foto_wacalgub_name = $_FILES['foto_wacalgub']['name'];
        $foto_wacalgub_temp = $_FILES['foto_wacalgub']['tmp_name'];
        $foto_wacalgub_destination = "$upload_dir/" . $foto_wacalgub_name;
        move_uploaded_file($foto_wacalgub_temp, $foto_wacalgub_destination);
        $foto_wacalgub_path = "$upload_date/$foto_wacalgub_name";
    } else {
        // If the photo input is empty, use the existing photo
        $foto_wacalgub_path = $candidate['foto_wacalgub'];
    }

    try {
        // Update candidate data in the database
        $stmt = $pdo->prepare("UPDATE dbcalgub SET calgub=?, wacalgub=?, ket=?, visi=?, misi=?, partai_koalisi=?, jml_suara=?, calgub_bio=?, calgub_pendidikan=?, calgub_penghargaan=?, wacalgub_bio=?, wacalgub_pendidikan=?, foto_calgun=?, foto_wacalgub=? WHERE id=?");
        $stmt->execute([$calgub, $wacalgub, $ket, $visi, $misi, $partai_koalisi_string, $jml_suara, $calgub_bio, $calgub_pendidikan, $calgub_penghargaan, $wacalgub_bio, $wacalgub_pendidikan, $foto_calgun_path, $foto_wacalgub_path, $candidate_id]);

        // Check if the photo inputs are not empty before updating the photo in the database
        if (!empty($_FILES['foto_calgun']['name'])) {
            $stmt = $pdo->prepare("UPDATE dbcalgub SET foto_calgun=? WHERE id=?");
            $stmt->execute([$foto_calgun_path, $candidate_id]);
        }

        if (!empty($_FILES['foto_wacalgub']['name'])) {
            $stmt = $pdo->prepare("UPDATE dbcalgub SET foto_wacalgub=? WHERE id=?");
            $stmt->execute([$foto_wacalgub_path, $candidate_id]);
        }

        // Redirect to manage page to avoid form resubmission on page refresh
        header("Location: manage #candidates");
        exit;
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
}

// Fetch candidate data based on ID
$candidate_id = $_GET['id'];
try {
    $stmt = $pdo->prepare("SELECT * FROM dbcalgub WHERE id = ?");
    $stmt->execute([$candidate_id]);
    $candidate = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle database errors
    echo "Error fetching candidate: " . $e->getMessage();
}

function clean_text($text)
{
    // Remove <br> tags and excess whitespace
    return preg_replace('/<br\s*\/?>/', '', $text);
}

// Clean text from <br> tags before displaying in input fields
$candidate['calgub_pendidikan'] = clean_text($candidate['calgub_pendidikan']);
$candidate['calgub_bio'] = clean_text($candidate['calgub_bio']);
$candidate['calgub_penghargaan'] = clean_text($candidate['calgub_penghargaan']);
$candidate['wacalgub_bio'] = clean_text($candidate['wacalgub_bio']);
$candidate['wacalgub_pendidikan'] = clean_text($candidate['wacalgub_pendidikan']);
$candidate['visi'] = clean_text($candidate['visi']); // Clean visi
$candidate['misi'] = clean_text($candidate['misi']); // Clean misi
?>

<!DOCTYPE html>
<html lang="en">

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit <?php echo htmlspecialchars($candidate['calgub']); ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="../../data/w/ico.svg">
    <link rel="stylesheet" href="../../dist/css/main.css">
</head>

<body>

    <div class="container mt-5">
        <h1>Edit Calon Gubernur <?php echo htmlspecialchars($candidate['calgub']); ?></h1>
        <form method="POST" enctype="multipart/form-data">
            <!-- Populate form fields with existing data -->
            <!-- Candidate Name -->
            <div class="mb-3">
                <label for="calgub" class="form-label">Nama Calon Gubernur</label>
                <input type="text" class="form-control" id="calgub" name="calgub" value="<?php echo htmlspecialchars($candidate['calgub']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="wacalgub" class="form-label">Nama Wakil Calon Gubernur</label>
                <input type="text" class="form-control" id="wacalgub" name="wacalgub" value="<?php echo htmlspecialchars($candidate['wacalgub']); ?>" required>
            </div>

            <!-- Keterangan -->
            <div class="mb-3">
                <label for="ket" class="form-label">Keterangan</label>
                <textarea class="form-control" id="ket" name="ket" rows="3"><?php echo htmlspecialchars($candidate['ket']); ?></textarea>
            </div>

            <!-- Visi -->
            <div class="mb-3">
                <label for="visi" class="form-label">Visi</label>
                <textarea class="form-control" id="visi" name="visi" rows="3"><?php echo htmlspecialchars($candidate['visi']); ?></textarea>
            </div>

            <!-- Misi -->
            <div class="mb-3">
                <label for="misi" class="form-label">Misi</label>
                <textarea class="form-control" id="misi" name="misi" rows="3"><?php echo htmlspecialchars($candidate['misi']); ?></textarea>
            </div>

            <!-- Partai Koalisi -->
            <div class="mb-3">
                <label for="partai_koalisi" class="form-label">Partai Koalisi</label>
                <?php
                try {
                    // Query to fetch party data from dbpartai table
                    $stmt = $pdo->query("SELECT * FROM dbpartai");

                    // Retrieve the existing party IDs associated with the candidate
                    $existing_partai_koalisi = explode(",", $candidate['partai_koalisi']);

                    // Loop through each row and display party name as a checkbox
                    foreach ($stmt as $row) {
                        // Check if the current party ID exists in the existing_partai_koalisi array
                        $checked = in_array($row['Id'], $existing_partai_koalisi) ? 'checked' : '';
                        echo '<div class="form-check form-check-inline">';
                        echo '<input class="form-check-input" type="checkbox" id="partai_' . $row['Id'] . '" name="partai_koalisi[]" value="' . $row['Id'] . '" ' . $checked . '>';
                        echo '<label class="form-check-label" for="partai_' . $row['Id'] . '">' . $row['namo_partai'] . '</label>';
                        echo '</div>';
                    }
                } catch (PDOException $e) {
                    // Handle database connection errors
                    echo "Error fetching parties: " . $e->getMessage();
                }
                ?>
            </div>

            <!-- Jumlah Suara -->
            <div class="mb-3">
                <label for="jml_suara" class="form-label">Jumlah Suara</label>
                <input type="number" class="form-control" id="jml_suara" name="jml_suara" value="<?php echo htmlspecialchars($candidate['jml_suara']); ?>">
            </div>

            <!-- Biografi Calon Gubernur -->
            <div class="mb-3">
                <label for="calgub_bio" class="form-label">Biografi Calon Gubernur</label>
                <textarea class="form-control" id="calgub_bio" name="calgub_bio" rows="3"><?php echo htmlspecialchars($candidate['calgub_bio']); ?></textarea>
            </div>

            <!-- Pendidikan Calon Gubernur -->
            <div class="mb-3">
                <label for="calgub_pendidikan" class="form-label">Pendidikan Calon Gubernur</label>
                <textarea class="form-control" id="calgub_pendidikan" name="calgub_pendidikan" rows="3"><?php echo htmlspecialchars($candidate['calgub_pendidikan']); ?></textarea>
            </div>

            <!-- Penghargaan Calon Gubernur -->
            <div class="mb-3">
                <label for="calgub_penghargaan" class="form-label">Penghargaan Calon Gubernur</label>
                <textarea class="form-control" id="calgub_penghargaan" name="calgub_penghargaan" rows="3"><?php echo htmlspecialchars($candidate['calgub_penghargaan']); ?></textarea>
            </div>

            <!-- Biografi Wakil Calon Gubernur -->
            <div class="mb-3">
                <label for="wacalgub_bio" class="form-label">Biografi Wakil Calon Gubernur</label>
                <textarea class="form-control" id="wacalgub_bio" name="wacalgub_bio" rows="3"><?php echo htmlspecialchars($candidate['wacalgub_bio']); ?></textarea>
            </div>

            <!-- Pendidikan Wakil Calon Gubernur -->
            <div class="mb-3">
                <label for="wacalgub_pendidikan" class="form-label">Pendidikan Wakil Calon Gubernur</label>
                <textarea class="form-control" id="wacalgub_pendidikan" name="wacalgub_pendidikan" rows="3"><?php echo htmlspecialchars($candidate['wacalgub_pendidikan']); ?></textarea>
            </div>

            <!-- Input fields for candidate photos -->
            <div class="mb-3">
                <label for="foto_calgun" class="form-label">Foto Calon Gubernur</label>
                <input type="file" class="form-control" id="foto_calgun" name="foto_calgun" required>
            </div>
            <div class="mb-3">
                <label for="foto_wacalgub" class="form-label">Foto Wakil Calon Gubernur</label>
                <input type="file" class="form-control" id="foto_wacalgub" name="foto_wacalgub" required>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary mb-5" name="submit">Submit</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../../dist/js/main.js"></script>
</body>

</html>