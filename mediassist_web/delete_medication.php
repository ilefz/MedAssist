<?php
session_start();
require 'includes/db_connect.php';

// Check if ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_to_delete = (int)$_GET['id']; // Cast to integer for safety

    // Prepare SQL statement to prevent SQL injection
    $sql = "DELETE FROM medications WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id_to_delete);

        if (mysqli_stmt_execute($stmt)) {
            // Optional: Add a success message (e.g., using session flash messages)
            // $_SESSION['message'] = "Medication deleted successfully.";
        } else {
            // Optional: Add an error message
            // $_SESSION['error'] = "Error deleting record: " . mysqli_stmt_error($stmt);
            echo "Error deleting record: " . mysqli_stmt_error($stmt); // Basic error output
             exit(); // Stop if error
        }
         mysqli_stmt_close($stmt);
    } else {
         echo "Error preparing statement: " . mysqli_error($conn); // Basic error output
         exit(); // Stop if error
    }

} else {
    // Optional: Add error message if ID is missing or invalid
    // $_SESSION['error'] = "Invalid request.";
     echo "Invalid request.";
     exit(); // Stop if error
}

// Redirect back to the medication list page
header("Location: medications.php");
exit(); // Ensure no further code is executed after redirect
?>