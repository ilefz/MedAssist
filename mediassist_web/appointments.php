<?php
require 'includes/db_connect.php';
include 'includes/header.php';
$sql = "SELECT id, appointement_date, appointement_time, type, notes FROM appointments ORDER BY appointement_date ASC, appointement_time ASC";
$result = mysqli_query($conn, $sql);
?>
<main>
    <div class="container" style="padding-top: 30px; padding-bottom: 30px; padding-left: 550px;">
        <h2>Appointments</h2>
        <p><a href="add_appointment.php" class="button-link add-new">+ Add New Appointment</a></p>
        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Type</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo date("D, M j, Y", strtotime($row['appointement_date'])); // Format date ?></td>
                        <td><?php echo date("g:i A", strtotime($row['appointement_time'])); // Format time ?></td>
                        <td><?php echo htmlspecialchars($row['type']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($row['notes'])); // Display notes with line breaks ?></td>
                        <td>
                            <a href="delete_appointment.php?id=<?php echo $row['id']; ?>" class="action-link" onclick="return confirm('Are you sure you want to delete this appointment?');">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php elseif ($result): ?>
            <p>No appointments scheduled yet.</p>
        <?php else: ?>
            <p class="message error">Error fetching appointments: <?php echo mysqli_error($conn); ?></p>
        <?php endif; ?>

        
    </div> 
</main>
<?php
if ($result) mysqli_free_result($result);
include 'includes/footer.php';
?>