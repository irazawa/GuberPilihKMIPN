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

// Check if party ID and party name are provided via POST request
if (isset($_POST['partyId']) && isset($_POST['editPartyName'])) {
    // Get party ID and party name from POST request
    $partyId = $_POST['partyId'];
    $editPartyName = $_POST['editPartyName'];

    // Check if a new image file is uploaded
    if (!empty($_FILES["editPartyImage"]["name"])) {
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

        // Upload new image
        $editPartyImage = uploadPhoto($_FILES["editPartyImage"]);

        // Check if image upload is successful
        if ($editPartyImage) {
            // Remove directory part from path
            $editPartyImage = str_replace("../../data/partai/", "", $editPartyImage);

            // Update party name and image in the database based on party ID
            $sql = "UPDATE dbpartai SET namo_partai = :editPartyName, foto_partai = :editPartyImage WHERE Id = :partyId";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':editPartyName', $editPartyName, PDO::PARAM_STR);
            $stmt->bindParam(':editPartyImage', $editPartyImage, PDO::PARAM_STR);
            $stmt->bindParam(':partyId', $partyId, PDO::PARAM_INT);

            // Execute the update query
            if ($stmt->execute()) {
                // Redirect back to manage after successful update
                header("Location: manage#manage-parties");
                exit();
            } else {
                // Handle update failure
                echo "Failed to update party.";
            }
        } else {
            // Handle image upload failure
            echo "Failed to upload new image.";
        }
    } else {
        // No new image uploaded, update party name only
        $sql = "UPDATE dbpartai SET namo_partai = :editPartyName WHERE Id = :partyId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':editPartyName', $editPartyName, PDO::PARAM_STR);
        $stmt->bindParam(':partyId', $partyId, PDO::PARAM_INT);

        // Execute the update query
        if ($stmt->execute()) {
            // Redirect back to manage after successful update
            header("Location: manage#manage-parties");
            exit();
        } else {
            // Handle update failure
            echo "Failed to update party.";
        }
    }
} else {
    // Handle missing party ID or party name
    header("Location: manage#manage-parties");
}
