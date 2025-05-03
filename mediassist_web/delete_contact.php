<?php
session_start();
require 'includes/db_connect.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_to_delete = (int)$_GET['id'];

    $sql = "DELETE FROM emergency_contacts WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id_to_delete);
         if (!mysqli_stmt_execute($stmt)) {
             error_log("Error deleting contact ID $id_to_delete: " . mysqli_stmt_error($stmt));
         }
        mysqli_stmt_close($stmt);
    } else {
        error_log("Error preparing delete statement for contact: " . mysqli_error($conn));
    }
}

// Redirect back
header("Location: contacts.php");
exit();
?>