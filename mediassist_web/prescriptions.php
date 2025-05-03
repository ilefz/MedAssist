<?php
require 'includes/db_connect.php';
include 'includes/header.php';

$sql = "SELECT id, description, image_path, created_at FROM prescription ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>
<main>
    <div class="container" style="padding-top: 30px; padding-bottom: 30px; padding-left: 550px;">
        <h2>Prescriptions</h2>
        <p><a href="add_prescription.php" class="button-link add-new">+ Add New Prescription</a></p>

        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Image/File</th>
                        <th>Added On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo !empty($row['description']) ? htmlspecialchars($row['description']) : '<i>No description</i>'; ?></td>
                        <td>
                            <?php if (!empty($row['image_path']) && file_exists($row['image_path'])): ?>
                                <?php
                                    // Basic check if it's an image file for thumbnail
                                    $is_image = in_array(strtolower(pathinfo($row['image_path'], PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif']);
                                ?>
                                <a href="<?php echo htmlspecialchars($row['image_path']); ?>" target="_blank">
                                    <?php if($is_image): ?>
                                        <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="Prescription Thumbnail" class="prescription-image">
                                    <?php else: ?>
                                        View File (<?php echo strtoupper(htmlspecialchars(pathinfo($row['image_path'], PATHINFO_EXTENSION))); ?>)
                                    <?php endif; ?>
                                </a>
                            <?php else: ?>
                                <i>No file uploaded</i>
                            <?php endif; ?>
                        </td>
                        <td><?php echo date("M j, Y, g:i a", strtotime($row['created_at'])); ?></td>
                        <td>
                            <a href="delete_prescription.php?id=<?php echo $row['id']; ?>" class="action-link" onclick="return confirm('Are you sure you want to delete this prescription? This will also delete the file.');">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php elseif ($result): ?>
            <p>No prescriptions recorded yet.</p>
        <?php else: ?>
            <p class="message error">Error fetching prescriptions: <?php echo mysqli_error($conn); ?></p>
        <?php endif; ?>
    </div>
</main>


<?php
 if ($result) mysqli_free_result($result);
include 'includes/footer.php';
?>