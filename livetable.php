<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

require_once "connection.php";

date_default_timezone_set('Asia/Jakarta');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_trxTableBilliard'])) {
    $id_trxTableBilliard = mysqli_real_escape_string($koneksi, $_POST['id_trxTableBilliard']);

    $query_select = "SELECT id_member, Date, Time, id_table FROM trxtablebilliard WHERE id_trxTableBilliard = '$id_trxTableBilliard'";
    $result_select = mysqli_query($koneksi, $query_select);

    if ($result_select && mysqli_num_rows($result_select) > 0) {
        $row = mysqli_fetch_assoc($result_select);
        $id_member = $row['id_member'];
        $date = $row['Date'];
        $time = $row['Time'];
        $id_table = $row['id_table'];

        $date_checkout = date('Y-m-d');
        $time_checkout = date('H:i:s');

        error_log("Debugging Time Checkout: $time_checkout");

        $datetime_start = new DateTime("$date $time");
        $datetime_end = new DateTime("$date_checkout $time_checkout");
        $interval = $datetime_start->diff($datetime_end);
        $seconds = $interval->days * 24 * 60 * 60 + $interval->h * 60 * 60 + $interval->i * 60 + $interval->s;

        $rate_per_hour = 35000;
        $rate_per_second = $rate_per_hour / 3600;
        $amount = $seconds * $rate_per_second;

        $amount = ceil($amount);

        $query_insert_transaction = "INSERT INTO transaction (id_member, id_trxTableBilliard, Date_checkout, Time_checkout, Amount) 
                                     VALUES ('$id_member', '$id_trxTableBilliard', '$date_checkout', '$time_checkout', '$amount')";
        $result_insert_transaction = mysqli_query($koneksi, $query_insert_transaction);

        if ($result_insert_transaction) {
            $query_update_action = "UPDATE tableinfo SET action = 'NoAction' WHERE id_table = '$id_table'";
            $result_update_action = mysqli_query($koneksi, $query_update_action);

            if ($result_update_action) {
                $query_delete = "DELETE FROM trxtablebilliard WHERE id_trxTableBilliard = '$id_trxTableBilliard'";
                $result_delete = mysqli_query($koneksi, $query_delete);

                if ($result_delete) {
                    $_SESSION['transaction_info'] = [
                        'id_member' => $id_member,
                        'id_trxTableBilliard' => $id_trxTableBilliard,
                        'Date_checkout' => $date_checkout,
                        'Time_checkout' => $time_checkout,
                        'Amount' => $amount
                    ];

                    header("Location: stop-cetak.php");
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
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id_member'] . "</td>";
                        echo "<td>" . $row['Name'] . "</td>";
                        echo "<td>" . $row['Date'] . "</td>";
                        echo "<td>" . $row['Time'] . "</td>";
                        echo "<td>" . $row['id_table'] . "</td>";
                        echo "<td>";
                        echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='POST' target='_blank'>";
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
