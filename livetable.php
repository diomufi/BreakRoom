<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

require_once "connection.php"; // Menghubungkan ke database

// Set zona waktu
date_default_timezone_set('Asia/Jakarta'); // Ubah sesuai dengan zona waktu Anda

// Handling form submission untuk menghapus data dan update tableinfo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_trxTableBilliard'])) {
    // Ambil id_trxTableBilliard dari form
    $id_trxTableBilliard = mysqli_real_escape_string($koneksi, $_POST['id_trxTableBilliard']);

    // Query untuk mengambil data dari trxtablebilliard
    $query_select = "SELECT id_member, Date, Time, id_table FROM trxtablebilliard WHERE id_trxTableBilliard = '$id_trxTableBilliard'";
    $result_select = mysqli_query($koneksi, $query_select);

    if ($result_select && mysqli_num_rows($result_select) > 0) {
        $row = mysqli_fetch_assoc($result_select);
        $id_member = $row['id_member'];
        $date = $row['Date'];
        $time = $row['Time'];
        $id_table = $row['id_table'];

        // Hitung Date_checkout dan Time_checkout
        $date_checkout = date('Y-m-d');
        $time_checkout = date('H:i:s');

        // Debugging Output
        error_log("Debugging Time Checkout: $time_checkout");

        // Hitung selisih waktu dalam detik
        $datetime_start = new DateTime("$date $time");
        $datetime_end = new DateTime("$date_checkout $time_checkout");
        $interval = $datetime_start->diff($datetime_end);
        $seconds = $interval->days * 24 * 60 * 60 + $interval->h * 60 * 60 + $interval->i * 60 + $interval->s;

        // Hitung Amount (misalnya, 35 ribu per jam)
        $rate_per_hour = 35000; // 35 ribu per jam
        $rate_per_second = $rate_per_hour / 3600; // Biaya per detik
        $amount = $seconds * $rate_per_second;

        // Bulatkan jumlah ke atas agar tidak ada perhitungan di bawah Rp. 1
        $amount = ceil($amount);

        // Query untuk memasukkan data ke dalam tabel transaction
        $query_insert_transaction = "INSERT INTO transaction (id_member, id_trxTableBilliard, Date_checkout, Time_checkout, Amount) 
                                     VALUES ('$id_member', '$id_trxTableBilliard', '$date_checkout', '$time_checkout', '$amount')";
        $result_insert_transaction = mysqli_query($koneksi, $query_insert_transaction);

        if ($result_insert_transaction) {
            // Query untuk mengubah action dari tableinfo menjadi NoAction
            $query_update_action = "UPDATE tableinfo SET action = 'NoAction' WHERE id_table = '$id_table'";
            $result_update_action = mysqli_query($koneksi, $query_update_action);

            if ($result_update_action) {
                // Query untuk menghapus data dari trxtablebilliard
                $query_delete = "DELETE FROM trxtablebilliard WHERE id_trxTableBilliard = '$id_trxTableBilliard'";
                $result_delete = mysqli_query($koneksi, $query_delete);

                if ($result_delete) {
                    // Redirect ke halaman livetable.php setelah berhasil menghapus
                    header("Location: livetable.php");
                    exit;
                } else {
                    error_log("Error: Gagal menghapus data dari trxtablebilliard. " . mysqli_error($koneksi));
                    echo "Error: Gagal menghapus data dari trxtablebilliard. " . mysqli_error($koneksi);
                }
            } else {
                error_log("Error: Gagal mengubah action pada tableinfo. " . mysqli_error($koneksi));
                echo "Error: Gagal mengubah action pada tableinfo. " . mysqli_error($koneksi);
            }
        } else {
            error_log("Error: Gagal memasukkan data ke dalam transaction. " . mysqli_error($koneksi));
            echo "Error: Gagal memasukkan data ke dalam transaction. " . mysqli_error($koneksi);
        }
    } else {
        error_log("Error: Data tidak ditemukan. " . mysqli_error($koneksi));
        echo "Error: Data tidak ditemukan. " . mysqli_error($koneksi);
    }
}

// Query untuk mendapatkan data dari trxtablebilliard dengan nama member terkait
$query = "SELECT t.id_trxTableBilliard, m.id_member, m.Nama AS Name, t.Date, t.Time, t.id_table 
          FROM trxtablebilliard t 
          INNER JOIN member m ON t.id_member = m.id_member";
$result = mysqli_query($koneksi, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Booking Table</title>
    <link rel="stylesheet" href="css/livetable.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="fontawesome/fontawesome-free-6.2.1-web/css/all.css">
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="container">
        <h2>Live Booking Table</h2>
        <table id="liveTable">
            <thead>
                <tr>
                    <th>ID Member</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Table Number</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Periksa apakah query berhasil dieksekusi
                if ($result && mysqli_num_rows($result) > 0) {
                    // Loop untuk menampilkan data
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id_member'] . "</td>";
                        echo "<td>" . $row['Name'] . "</td>";
                        echo "<td>" . $row['Date'] . "</td>";
                        echo "<td>" . $row['Time'] . "</td>";
                        echo "<td>" . $row['id_table'] . "</td>";
                        echo "<td>";
                        echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='POST'>";
                        echo "<input type='hidden' name='id_trxTableBilliard' value='" . $row['id_trxTableBilliard'] . "'>";
                        echo "<button type='submit'>Stop</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Tidak ada data yang ditemukan</td></tr>";
                }

                mysqli_close($koneksi);
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
