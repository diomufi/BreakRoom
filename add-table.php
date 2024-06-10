<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

include 'connection.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_table = mysqli_real_escape_string($koneksi, $_POST['id_table']);
    $building = mysqli_real_escape_string($koneksi, $_POST['building']);
    $floor = mysqli_real_escape_string($koneksi, $_POST['floor']);
    $number = mysqli_real_escape_string($koneksi, $_POST['number']);

    $query = "INSERT INTO tableinfo (id_table, Gedung, Lantai, Nomor) VALUES ('$id_table', '$building', '$floor', '$number')";

    if (mysqli_query($koneksi, $query)) {
        $message = 'Table added successfully';
    } else {
        $message = 'Failed to add table';
    }

    mysqli_close($koneksi);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Table</title>
    <link rel="stylesheet" href="css/tablebook.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="fontawesome/fontawesome-free-6.2.1-web/css/all.css">
    <script src="js/main.js"></script>
    <script>
        setTimeout(function() {
            var messageElement = document.querySelector('.message');
            if (messageElement) {
                messageElement.style.display = 'none';
            }
        }, 5000);
    </script>
</head>
<body>
<?php include "sidebar.php"; ?>

<div class="container">
    <div class="breakroom_text">
        <h3>Add Table</h3>
        <?php if (!empty($message)) : ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        <form id="addTableForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="id_table">ID Table:</label>
            <input type="text" id="id_table" name="id_table" required><br>
            <label for="building">Building:</label>
            <input type="text" id="building" name="building" required><br>
            <label for="floor">Floor:</label>
            <input type="text" id="floor" name="floor" required><br>
            <label for="number">Table Number:</label>
            <input type="text" id="number" name="number" required><br>
            <input type="submit" value="Add Table">
        </form>
    </div>
</div>

</body>
</html>
