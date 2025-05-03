<?php
require 'includes/db_connect.php';
include 'includes/header.php';

// Fetch medications from database
$sql = "SELECT id, name, dosage, frequency, time, created_at FROM medications ORDER BY name ASC";
$result = mysqli_query($conn, $sql);

?>
<main>
    <div class="container" style="padding-top: 30px; padding-bottom: 30px; padding-left: 550px;">

        <h2>Medication List</h2>
        <p><a href="add_medication.php" style="text-decoration:none;"><button>+ Add New Medication</button></a></p>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Dosage</th>
                        <th>Frequency</th>
                        <th>Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['dosage']); ?></td>
                        <td><?php echo htmlspecialchars($row['frequency']); ?></td>
                        <td><?php echo date("h:i A", strtotime($row['time'])); // Format time ?></td>
                        <td>
                            <!-- Add Edit link later -->
                            <a href="delete_medication.php?id=<?php echo $row['id']; ?>" class="action-link" onclick="return confirm('Are you sure you want to delete this medication?');">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No medications recorded yet.</p>
        <?php endif; ?>
    </div>
</main>

<?php
mysqli_free_result($result); // Free memory associated with result
include 'includes/footer.php';
?>