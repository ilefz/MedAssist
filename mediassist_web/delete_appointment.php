<?php
session_start();
require 'includes/db_connect.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_to_delete = (int)$_GET['id'];

    $sql = "DELETE FROM appointments WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id_to_delete);
        if (!mysqli_stmt_execute($stmt)) {
             // Log error or set session error message
             error_log("Error deleting appointment ID $id_to_delete: " . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);
    } else {
         error_log("Error preparing delete statement for appointment: " . mysqli_error($conn));
    }
}

// Redirect back regardless of success for simplicity, could add messages
header("Location: appointments.php");
exit();
?>