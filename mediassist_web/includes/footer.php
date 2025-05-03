</main>
    <footer>
        <p>© <?php echo date("Y"); ?> MediAssist Web. All rights reserved.</p>
    </footer>
    <script src="js/script.js"></script>
</body>
</html>
<?php
// Close database connection if it's open
// Note: This is basic. In larger apps, manage connections more carefully.
global $conn; // Access the global connection variable
if (isset($conn) && $conn) {
    mysqli_close($conn);
}
?>