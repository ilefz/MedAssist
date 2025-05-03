
<?php
session_start();
require 'includes/db_connect.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $app_date = mysqli_real_escape_string($conn, trim($_POST['app_date']));
    $app_time = mysqli_real_escape_string($conn, trim($_POST['app_time']));
    $app_type = mysqli_real_escape_string($conn, trim($_POST['app_type']));
    $app_notes = mysqli_real_escape_string($conn, trim($_POST['app_notes'])); // Optional notes

    if (empty($app_date) || empty($app_time) || empty($app_type)) {
        $message = "<div class='message error'>Please fill in Date, Time, and Type.</div>";
    } else {
        $sql = "INSERT INTO appointments (appointment_date, appointment_time, type, notes) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssss", $app_date, $app_time, $app_type, $app_notes);
            if (mysqli_stmt_execute($stmt)) {
                $message = "<div class='message success'>Appointment added successfully!</div>";
                $_POST = array(); // Clear form on success
            } else {
                $message = "<div class='message error'>Error adding appointment: " . mysqli_stmt_error($stmt) . "</div>";
            }
            mysqli_stmt_close($stmt);
        } else {
             $message = "<div class='message error'>Error preparing statement: " . mysqli_error($conn) . "</div>";
        }
    }
}

include 'includes/header.php';
?>
<main>
    <div class="container" style="padding-top: 30px; padding-bottom: 30px; padding-left: 200px;">

        <h2>Add New Appointment</h2>
        <?php echo $message; ?>

        <form action="add_appointment.php" method="post">
            <div>
                <label for="app_date">Date:</label>
                <input type="date" id="app_date" name="app_date" required value="<?php echo isset($_POST['app_date']) ? htmlspecialchars($_POST['app_date']) : ''; ?>">
            </div>
            <div>
                <label for="app_time">Time:</label>
                <input type="time" id="app_time" name="app_time" required value="<?php echo isset($_POST['app_time']) ? htmlspecialchars($_POST['app_time']) : ''; ?>">
            </div>
            <div>
                <label for="app_type">Type (e.g., Doctor Visit, Dentist):</label>
                <input type="text" id="app_type" name="app_type" required value="<?php echo isset($_POST['app_type']) ? htmlspecialchars($_POST['app_type']) : ''; ?>">
            </div>
            <div>
                <label for="app_notes">Notes (Optional):</label>
                <textarea id="app_notes" name="app_notes"><?php echo isset($_POST['app_notes']) ? htmlspecialchars($_POST['app_notes']) : ''; ?></textarea>
            </div>
            <div>
                <button type="submit">Save Appointment</button>
            </div>
        </form>
    </div> 
</main>

<?php include 'includes/footer.php'; ?>