<?php
require 'includes/db_connect.php';
include 'includes/header.php';
$sql = "SELECT id, name, phone FROM emergency_contacts ORDER BY name ASC";
$result = mysqli_query($conn, $sql);
?>
<main>
    <div class="container" style="padding-top: 30px; padding-bottom: 30px; padding-left: 550px;">



        <h2>Emergency Contacts</h2>
        <p><a href="add_contact.php" class="button-link add-new">+ Add New Contact</a></p>

        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><a href="tel:<?php echo htmlspecialchars($row['phone']); ?>"><?php echo htmlspecialchars($row['phone']); ?></a></td> {/* Clickable phone link */}
                        <td>
                            <a href="delete_contact.php?id=<?php echo $row['id']; ?>" class="action-link" onclick="return confirm('Are you sure you want to delete this contact?');">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php elseif ($result): ?>
            <p>No emergency contacts added yet.</p>
        <?php else: ?>
            <p class="message error">Error fetching contacts: <?php echo mysqli_error($conn); ?></p>
        <?php endif; ?>
    </div>
</main>

<?php
 if ($result) mysqli_free_result($result);
include 'includes/footer.php';
?>