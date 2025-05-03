<?php
session_start();
require 'includes/db_connect.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $contact_name = mysqli_real_escape_string($conn, trim($_POST['contact_name']));
    $contact_phone = mysqli_real_escape_string($conn, trim($_POST['contact_phone']));

    if (empty($contact_name) || empty($contact_phone)) {
        $message = "<div class='message error'>Please fill in both Name and Phone Number.</div>";
    } else {
        $sql = "INSERT INTO emergency_contacts (name, phone) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $contact_name, $contact_phone);
            if (mysqli_stmt_execute($stmt)) {
                $message = "<div class='message success'>Emergency Contact added successfully!</div>";
                $_POST = array(); // Clear form
            } else {
                // Check for duplicate phone error if you added a UNIQUE constraint
                if (mysqli_errno($conn) == 1062) { // 1062 = Duplicate entry error code
                     $message = "<div class='message error'>Error: This phone number is already registered as a contact.</div>";
                } else {
                    $message = "<div class='message error'>Error adding contact: " . mysqli_stmt_error($stmt) . "</div>";
                }
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

        <h2>Add New Emergency Contact</h2>
        <?php echo $message; ?>

        <form action="add_contact.php" method="post">
            <div>
                <label for="contact_name">Contact Name:</label>
                <input type="text" id="contact_name" name="contact_name" required value="<?php echo isset($_POST['contact_name']) ? htmlspecialchars($_POST['contact_name']) : ''; ?>">
            </div>
            <div>
                <label for="contact_phone">Phone Number:</label>
                <input type="tel" id="contact_phone" name="contact_phone" required value="<?php echo isset($_POST['contact_phone']) ? htmlspecialchars($_POST['contact_phone']) : ''; ?>">
            </div>
            <div>
                <button type="submit">Save Contact</button>
            </div>
        </form>
    </div>
</main>

<?php include 'includes/footer.php'; ?>