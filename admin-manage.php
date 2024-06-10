<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit;
}
require_once "connection.php";
$deletion_success = false;
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM admin WHERE id_admin = ?";
    if ($stmt = mysqli_prepare($koneksi, $delete_query)) {
        mysqli_stmt_bind_param($stmt, "s", $delete_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $deletion_success = true;
    }

    header("Location: admin-manage.php?deleted=" . ($deletion_success ? "true" : "false"));
    exit;
}

$query = "SELECT * FROM admin";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Manage</title>
    <link rel="stylesheet" href="css/admin-manage.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="fontawesome/fontawesome-free-6.2.1-web/css/all.css">
    <script>
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('deleted') === 'true') {
                alert('Admin successfully deleted.');
            } else if (urlParams.get('deleted') === 'false') {
                alert('Failed to delete admin.');
            }
        };
    </script>
</head>
<body>
    <?php include "sidebar.php" ?>
    <div class="container">
        <table id="liveTable">
            <thead>
                <tr>
                    <th>ID Admin</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop melalui setiap baris data dari hasil query
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id_admin'] . "</td>";
                    echo "<td>" . $row['Nama'] . "</td>";
                    echo "<td>" . $row['Username'] . "</td>";
                    echo "<td>" . $row['Email'] . "</td>";
                    echo "<td>" . $row['Role'] . "</td>";
                    // Tombol untuk menghapus data, di sini Anda harus menyesuaikan dengan URL yang sesuai untuk file action penghapusan
                    echo "<td><a href='admin-manage.php?delete_id=" . $row['id_admin'] . "'><button>Delete</button></a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
