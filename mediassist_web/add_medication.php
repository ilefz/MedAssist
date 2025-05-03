_<?php
session_start(); // Good practice, even if not using full login yet
require 'includes/db_connect.php'; // Use require to stop script if DB connection fails

$message = ''; // To store success or error messages

// --- Handle Form Submission ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data (Basic example - use more robust validation/sanitization in real apps)
    $med_name = mysqli_real_escape_string($conn, trim($_POST['med_name']));
    $med_dosage = mysqli_real_escape_string($conn, trim($_POST['med_dosage']));
    $med_frequency = mysqli_real_escape_string($conn, trim($_POST['med_frequency']));
    $med_time = mysqli_real_escape_string($conn, trim($_POST['med_time'])); // Assumes 'HH:MM' format from input type="time"

    // Basic Validation
    if (empty($med_name) || empty($med_dosage) || empty($med_frequency) || empty($med_time)) {
        $message = "<div class='message error'>Please fill in all fields.</div>";
    } else {
        // Prepare SQL statement (Prevents basic SQL injection)
        $sql = "INSERT INTO medications (name, dosage, frequency, time) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            // Bind parameters (s = string, i = integer, d = double, b = blob)
            mysqli_stmt_bind_param($stmt, "ssss", $med_name, $med_dosage, $med_frequency, $med_time);

            // Execute statement
            if (mysqli_stmt_execute($stmt)) {
                $message = "<div class='message success'>Medication added successfully!</div>";
                // Clear form fields after successful submission (optional)
                $_POST = array();
            } else {
                $message = "<div class='message error'>Error adding medication: " . mysqli_stmt_error($stmt) . "</div>";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        } else {
             $message = "<div class='message error'>Error preparing statement: " . mysqli_error($conn) . "</div>";
        }
    }
}
// --- End Form Submission Handling ---

include 'includes/header.php'; // Include the HTML header and nav
?>
<main>
    <div class="container" style="padding-top: 30px; padding-bottom: 30px; padding-left: 270px;">


        <h2>Add New Medication</h2>

        <?php echo $message; // Display any success or error messages ?>

        <form action="add_medication.php" method="post">
            <div>
                <label for="med_name">Medication Name:</label>
                <input type="text" id="med_name" name="med_name" required value="<?php echo isset($_POST['med_name']) ? htmlspecialchars($_POST['med_name']) : ''; ?>">
            </div>
            <div>
                <label for="med_dosage">Dosage (e.g., 1 tablet, 5ml):</label>
                <input type="text" id="med_dosage" name="med_dosage" required value="<?php echo isset($_POST['med_dosage']) ? htmlspecialchars($_POST['med_dosage']) : ''; ?>">
            </div>
            <div>
                <label for="med_frequency">Frequency (e.g., Daily, Twice a day):</label>
                <input type="text" id="med_frequency" name="med_frequency" required value="<?php echo isset($_POST['med_frequency']) ? htmlspecialchars($_POST['med_frequency']) : ''; ?>">
            </div>
            <div>
                <label for="med_time">Time:</label>
                <input type="time" id="med_time" name="med_time" required value="<?php echo isset($_POST['med_time']) ? htmlspecialchars($_POST['med_time']) : ''; ?>">
            </div>
            <div>
                <button type="submit">Save Medication</button>
            </div>
        </form>
    </div>
</main>
<?php include 'includes/footer.php';  ?>