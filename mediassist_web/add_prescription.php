<?php
session_start();
require 'includes/db_connect.php';

$message = '';
$upload_dir = 'uploads/';

if (!is_dir($upload_dir)) {
    if (!mkdir($upload_dir, 0755, true)) { 
         $message = "<div class='message error'>Failed to create upload directory. Please check permissions.</div>";
    }
}
if (!is_writable($upload_dir)) {
     $message = "<div class='message error'>Upload directory is not writable. Please check permissions.</div>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($message) /* Only proceed if dir is ok */) {
    $pres_description = mysqli_real_escape_string($conn, trim($_POST['pres_description']));
    $uploaded_file_path = null;

    // --- File Upload Handling ---
    if (isset($_FILES['pres_image']) && $_FILES['pres_image']['error'] == UPLOAD_ERR_OK) {
        $file_info = $_FILES['pres_image'];
        $file_name = basename($file_info['name']);
        $file_tmp_path = $file_info['tmp_name'];
        $file_size = $file_info['size'];
        $file_type = $file_info['type'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf']; // Allowed file types
        $max_file_size = 5 * 1024 * 1024; // 5 MB limit

        if (!in_array($file_ext, $allowed_extensions)) {
            $message = "<div class='message error'>Invalid file type. Only JPG, PNG, GIF, PDF allowed.</div>";
        } elseif ($file_size > $max_file_size) {
             $message = "<div class='message error'>File size exceeds the limit of 5MB.</div>";
        } else {
            // Create a unique filename to prevent overwrites
            $unique_filename = uniqid('pres_', true) . '.' . $file_ext;
            $destination = $upload_dir . $unique_filename;

            if (move_uploaded_file($file_tmp_path, $destination)) {
                $uploaded_file_path = $destination; // Store the path to save in DB
            } else {
                $message = "<div class='message error'>Failed to move uploaded file. Check server logs.</div>";
            }
        }
    } elseif (isset($_FILES['pres_image']) && $_FILES['pres_image']['error'] != UPLOAD_ERR_NO_FILE) {
         // Handle other upload errors
         $message = "<div class='message error'>File upload error: Code " . $_FILES['pres_image']['error'] . "</div>";
    }
   if (empty($message)) { // Only insert if no upload errors
         if (empty($pres_description) && empty($uploaded_file_path)) {
             $message = "<div class='message error'>Please provide a description or upload an image.</div>";
         } else {
            $sql = "INSERT INTO prescription (description, image_path) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ss", $pres_description, $uploaded_file_path); 
                if (mysqli_stmt_execute($stmt)) {
                    $message = "<div class='message success'>Prescription added successfully!</div>";
                    $_POST = array();
                } else {
                    $message = "<div class='message error'>Error adding prescription: " . mysqli_stmt_error($stmt) . "</div>";
                    if ($uploaded_file_path && file_exists($uploaded_file_path)) {
                        unlink($uploaded_file_path);
                    }
                }
                mysqli_stmt_close($stmt);
            } else {
                 $message = "<div class='message error'>Error preparing statement: " . mysqli_error($conn) . "</div>";
                 if ($uploaded_file_path && file_exists($uploaded_file_path)) {
                    unlink($uploaded_file_path); // Clean up uploaded file on prepare error
                }
            }
        }
    }
    // --- End Database Insertion ---
}

include 'includes/header.php';
?>
<main>
    <div class="container" style="padding-top: 30px; padding-bottom: 30px; padding-left: 270px;">

        <h2>Add New Prescription</h2>
        <?php echo $message; ?>

        <form action="add_prescription.php" method="post" enctype="multipart/form-data">
            <div>
                <label for="pres_description">Description (Optional):</label>
                <textarea id="pres_description" name="pres_description"><?php echo isset($_POST['pres_description']) ? htmlspecialchars($_POST['pres_description']) : ''; ?></textarea>
            </div>
            <div>
                <label for="pres_image">Upload Image/PDF (Optional, Max 5MB):</label>
                <input type="file" id="pres_image" name="pres_image" accept=".jpg, .jpeg, .png, .gif, .pdf">
            </div>
            <div>
                <button type="submit">Save Prescription</button>
            </div>
        </form>
    </div>
</main>
<?php include 'includes/footer.php'; ?>