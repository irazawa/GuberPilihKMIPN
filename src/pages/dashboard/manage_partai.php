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

// Include the database configuration file
include '../../config/config.php';

// Function to upload photo
function uploadPhoto($file)
{
    $targetDir = "../../data/partai/";
    $fileName = basename($file["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allow certain file formats
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    if (in_array($fileType, $allowTypes)) {
        // Upload file to server
        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            return $targetFilePath;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

// If form submitted
if (isset($_POST['submit'])) {
    $nama_partai = $_POST['nama_partai'];

    // Check if file is uploaded
    if (!empty($_FILES["foto_partai"]["name"])) {
        $foto_partai = uploadPhoto($_FILES["foto_partai"]);
        if ($foto_partai) {
            // Remove directory part from path
            $foto_partai = str_replace("../../data/partai/", "", $foto_partai);
            // Insert photo and name into database
            $sql = "INSERT INTO dbpartai (namo_partai, foto_partai) VALUES (:namo_partai, :foto_partai)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":namo_partai", $nama_partai);
            $stmt->bindParam(":foto_partai", $foto_partai);
            $stmt->execute();
            echo "Partai berhasil ditambahkan.";
            header("Location: manage#manage-parties");
        } else {
            echo "Gagal mengupload foto partai.";
        }
    } else {
        echo "Foto partai harus diunggah.";
        header("Location: manage#manage-parties");
    }
}

// Display existing parties
$sql = "SELECT * FROM dbpartai";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$parties = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php foreach ($parties as $party) : ?>
    <?php $partyId = $party['Id']; ?>
    <div class="col">
        <div class="card h-100 card-partai" style="background-image: url('../../data/partai/<?php echo $party['foto_partai']; ?>');">
            <div class="card-body text-center">
                <h5 class="card-title"><?php echo $party['namo_partai']; ?></h5>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary edit-btn" data-id="<?php echo $partyId; ?>" data-bs-toggle="modal" data-bs-target="#editPartyModal_<?php echo $partyId; ?>">Edit</button>
                    <button type="button" class="btn btn-danger delete-btn" data-id="<?php echo $partyId; ?>" data-name="<?php echo $party['namo_partai']; ?>">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editPartyModal_<?php echo $partyId; ?>" tabindex="-1" aria-labelledby="editPartyModalLabel_<?php echo $partyId; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPartyModalLabel_<?php echo $partyId; ?>">Edit Party</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Edit party form -->
                    <form id="editPartyForm_<?php echo $partyId; ?>" action="edit_partai.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="editPartyName_<?php echo $partyId; ?>" class="form-label">Party Name</label>
                            <input type="text" class="form-control" id="editPartyName_<?php echo $partyId; ?>" name="editPartyName" value="<?php echo $party['namo_partai']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPartyImage_<?php echo $partyId; ?>" class="form-label">Upload New Party Image</label>
                            <input type="file" class="form-control" id="editPartyImage_<?php echo $partyId; ?>" name="editPartyImage">
                        </div>
                        <input type="hidden" name="partyId" value="<?php echo $partyId; ?>">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>