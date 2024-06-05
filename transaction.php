<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

// Memuat file connection.php
require_once "connection.php";

// Lakukan query SQL untuk mengambil data transaksi
$sql = "SELECT id_Transaction, id_member, id_trxTableBilliard, Date_checkout, Time_checkout, Amount FROM transaction";
$result = mysqli_query($koneksi, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Records</title>
    <link rel="stylesheet" href="css/transaction.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="fontawesome/fontawesome-free-6.2.1-web/css/all.css">
</head>
<body>
    <?php include "sidebar.php" ?>

    <div class="content">
        <div class="container">
            <h2>Transaction Records</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID Transaksi</th>
                            <th>ID Member</th>
                            <th>ID Book</th>
                            <th>Tanggal Checkout</th>
                            <th>Waktu Checkout</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Tampilkan data dari hasil query
                        if ($result && mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row["id_Transaction"] . "</td>";
                                echo "<td>" . $row["id_member"] . "</td>";
                                echo "<td>" . $row["id_trxTableBilliard"] . "</td>";
                                echo "<td>" . $row["Date_checkout"] . "</td>";
                                echo "<td>" . $row["Time_checkout"] . "</td>";
                                // Format amount sebagai Rupiah
                                echo "<td>Rp " . number_format($row["Amount"], 0, ',', '.') . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Tidak ada data yang ditemukan</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<?php
// Tutup koneksi database (jika perlu)
//mysqli_close($koneksi);
?>
