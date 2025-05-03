<?php
// --- Database Credentials ---
// !! IMPORTANT: Replace with your actual database details !!
$dbHost = "localhost";       // Or your DB host (e.g., 127.0.0.1)
$dbUser = "root";            // Your MySQL username (default for XAMPP/WAMP is often 'root')
$dbPass = "";                // Your MySQL password (default for XAMPP/WAMP is often empty)
$dbName = "mediassist_db";   // The database name you created

// --- Create Connection ---
$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

// --- Check Connection ---
if (!$conn) {
    // Don't show detailed errors in production! Log them instead.
    die("Database connection failed: " . mysqli_connect_error());
}

// Optional: Set character set (good practice)
mysqli_set_charset($conn, "utf8mb4");

// echo "Database connected successfully!"; // Uncomment for testing connection
?>