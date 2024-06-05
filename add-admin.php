<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

require_once "connection.php"; // Memuat file koneksi database

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Insert data into admin table
    $sql = "INSERT INTO admin (Nama, Username, Email, Password, Role) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $nama, $username, $email, $password, $role);
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($koneksi); // Close database connection
        header("Location: add-admin.php?status=success");
        exit;
    } else {
        $error_message = mysqli_error($koneksi);
        mysqli_stmt_close($stmt);
        mysqli_close($koneksi); // Close database connection
        header("Location: add-admin.php?status=error&message=" . urlencode($error_message));
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin</title>
    <link rel="stylesheet" href="css/add-admin.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="fontawesome/fontawesome-free-6.2.1-web/css/all.css">
    <script>
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('status') === 'success') {
                alert('New record created successfully');
            } else if (urlParams.get('status') === 'error') {
                alert('Error: ' + urlParams.get('message'));
            }
        };
    </script>
</head>
<body>
    <?php include "sidebar.php" ?>
    <div class="container">
    <div class="breakroom_text">
        <h3>Add Admin</h3>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required><br>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="admin">Admin</option>
                <option value="officer">Officer</option>
            </select><br>
            <input type="submit" value="Submit">
        </form>
    </div>
</div>
</body>
</html>
