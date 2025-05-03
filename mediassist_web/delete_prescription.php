<?php
session_start();
require 'includes/db_connect.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_to_delete = (int)$_GET['id'];

    // --- First, get the image path before deleting the record ---
    $image_path = null;
    $sql_select = "SELECT image_path FROM prescription WHERE id = ?";
    $stmt_select = mysqli_prepare($conn, $sql_select);
    if($stmt_select) {
        mysqli_stmt_bind_param($stmt_select, "i", $id_to_delete);
        mysqli_stmt_execute($stmt_select);
        mysqli_stmt_bind_result($stmt_select, $image_path);
        mysqli_stmt_fetch($stmt_select);
        mysqli_stmt_close($stmt_select);
    }
    // --- End get image path ---


    // --- Delete the database record ---
    $sql_delete = "DELETE FROM prescription WHERE id = ?";
    $stmt_delete = mysqli_prepare($conn, $sql_delete);

    if ($stmt_delete) {
        mysqli_stmt_bind_param($stmt_delete, "i", $id_to_delete);
        if (mysqli_stmt_execute($stmt_delete)) {
             // --- If DB deletion successful, delete the file ---
             if (!empty($image_path) && file_exists($image_path)) {
                 if (!unlink($image_path)) {
                     // Log error: Failed to delete file
                     error_log("Failed to delete prescription file: " . $image_path);
                     // You might want to inform the user or handle this differently
                 }
             }
             // --- End file deletion ---
        } else {
             error_log("Error deleting prescription record ID $id_to_delete: " . mysqli_stmt_error($stmt_delete));
        }
        mysqli_stmt_close($stmt_delete);
    } else {
        error_log("Error preparing delete statement for prescription: " . mysqli_error($conn));
    }
    // --- End delete database record ---

}

// Redirect back
header("Location: prescriptions.php");
exit();
?>