<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

require_once "connection.php"; // Menghubungkan ke database

// Inisialisasi variabel
$error_message = '';

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai dari form
    $id_member = mysqli_real_escape_string($koneksi, $_POST['id_member']);
    $date = mysqli_real_escape_string($koneksi, $_POST['date']);
    $time = mysqli_real_escape_string($koneksi, $_POST['time']);
    $id_table = mysqli_real_escape_string($koneksi, $_POST['table']);

    // Validasi id_member
    if (empty($id_member)) {
        $error_message = "ID Member harus diisi.";
    } else {
        // Query untuk memeriksa keberadaan id_member
        $query_check_member = "SELECT COUNT(*) AS count FROM member WHERE id_member = '$id_member'";
        $result_check_member = mysqli_query($koneksi, $query_check_member);
        $row_check_member = mysqli_fetch_assoc($result_check_member);

        if ($row_check_member['count'] == 0) {
            $error_message = "ID Member tidak valid.";
        } else {
            // Query untuk memasukkan data ke dalam tabel trxtablebilliard
            $query_insert = "INSERT INTO trxtablebilliard (id_member, Date, Time, id_table) VALUES ('$id_member', '$date', '$time', '$id_table')";
            if (mysqli_query($koneksi, $query_insert)) {
                // Set action dari tableinfo menjadi NoActive setelah pemesanan berhasil
                $query_update_action = "UPDATE tableinfo SET action = 'Active' WHERE id_table = '$id_table'";
                if (mysqli_query($koneksi, $query_update_action)) {
                    // Pemesanan berhasil, tampilkan alert dan redirect setelah 5 detik
                    echo "<script>
                            alert('Pemesanan berhasil');
                            setTimeout(function() {
                                window.location.href = 'tablebook.php';
                            }, 5000); // 5000 milidetik = 5 detik
                          </script>";
                    exit;
                } else {
                    $error_message = "Gagal mengubah status table.";
                }
            } else {
                $error_message = "Gagal melakukan pemesanan.";
            }
        }
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
    <title>Book Table</title>
    <link rel="stylesheet" href="css/tablebook.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="fontawesome/fontawesome-free-6.2.1-web/css/all.css">
    <script src="js/main.js"></script>
</head>
<body>
    <?php include "sidebar.php"; ?>

    <div class="container">
        <div class="breakroom_text">
            <h3>Book Table</h3>
            <form id="bookingForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <?php if (!empty($error_message)) : ?>
                    <div class="error"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <label for="id_member">ID Member:</label>
                <input type="text" id="id_member" name="id_member" required><br>
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required><br>
                <label for="time">Time:</label>
                <input type="time" id="time" name="time" required><br>
                <label for="table">Table Number:</label>
                <select id="table" name="table" required>
                    <?php
                    // Query untuk mendapatkan tabel yang memiliki action NoActive dari tableinfo
                    $query_tables = "SELECT id_table FROM tableinfo WHERE action = 'NoAction'";
                    $result_tables = mysqli_query($koneksi, $query_tables);
                    while ($row_table = mysqli_fetch_assoc($result_tables)) {
                        echo "<option value='" . $row_table['id_table'] . "'>" . $row_table['id_table'] . "</option>";
                    }
                    ?>
                </select><br>
                <input type="submit" value="Start">
            </form>
        </div>
    </div>
</body>
</html>
