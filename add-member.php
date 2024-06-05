<?php
session_start();
if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'officer')) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Member</title>
    <link rel="stylesheet" href="css/add-admin.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="fontawesome/fontawesome-free-6.2.1-web/css/all.css">
    <style>
        .message {
            margin-top: 10px;
            padding: 10px;
            color: #155724;
        }
    </style>
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="container">
        <div class="breakroom_text">
            <h3>Add Member</h3>
            <?php
            require_once "connection.php";

            $error_message = '';

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Ambil nilai dari form
                $id_member = mysqli_real_escape_string($koneksi, $_POST['id_member']);
                $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
                $member_type = mysqli_real_escape_string($koneksi, $_POST['member_type']);

                // Query untuk memasukkan data ke dalam tabel member
                $query = "INSERT INTO member (id_member, Nama, Member_type) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($koneksi, $query);
                mysqli_stmt_bind_param($stmt, "sss", $id_member, $nama, $member_type);

                // Eksekusi query
                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_close($stmt);
                    mysqli_close($koneksi);
                    echo "<div id='successMessage' class='message'>New record created successfully</div>";
                } else {
                    $error_message = mysqli_error($koneksi);
                    mysqli_stmt_close($stmt);
                    mysqli_close($koneksi);
                    echo "<div class='message'>Error: " . $error_message . "</div>";
                }
            }
            ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="id_member">ID Member:</label>
                <input type="text" id="id_member" name="id_member" required><br>
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" required><br>
                <label for="member_type">Member Type:</label>
                <select id="member_type" name="member_type" required>
                    <option value="Silver">Silver</option>
                    <option value="Gold">Gold</option>
                    <option value="Platinum">Platinum</option>
                </select><br>
                <input type="submit" value="Submit">
            </form>
        </div>
    </div>

    <script>
        // Hapus pesan sukses setelah 5 detik
        window.onload = function() {
            var successMessage = document.getElementById('successMessage');
            if (successMessage) {
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 5000);
            }
        };
    </script>
</body>
</html>
