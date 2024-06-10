<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit;
}
require_once "connection.php";
$sql = "SELECT id_Transaction, id_member, id_trxTableBilliard, Date_checkout, Time_checkout, Amount FROM transaction";
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;

if ($start_date && $end_date) {
    $sql .= " WHERE Date_checkout BETWEEN '$start_date' AND '$end_date'";
}

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

            <div class="filter-container">
                <form method="GET">
                    <label for="start_date">Tanggal Mulai:</label>
                    <input type="date" id="start_date" name="start_date" value="<?php echo $start_date; ?>">

                    <label for="end_date">Tanggal Akhir:</label>
                    <input type="date" id="end_date" name="end_date" value="<?php echo $end_date; ?>">

                    <button type="submit">Filter</button>
                    <button type="button" onclick="window.location.href='transaction-cetak.php?start_date=' + document.getElementById('start_date').value + '&end_date=' + document.getElementById('end_date').value">Print</button>
                </form>
            </div>

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
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row["id_Transaction"] . "</td>";
                                echo "<td>" . $row["id_member"] . "</td>";
                                echo "<td>" . $row["id_trxTableBilliard"] . "</td>";
                                echo "<td>" . $row["Date_checkout"] . "</td>";
                                echo "<td>" . $row["Time_checkout"] . "</td>";
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
?>