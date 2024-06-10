<?php
session_start();
require_once 'connection.php'; // Sesuaikan dengan nama file koneksi Anda
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

// Ambil informasi transaksi dari session
if (isset($_SESSION['transaction_info'])) {
    $transaction_info = $_SESSION['transaction_info'];
    
    // Query untuk mendapatkan informasi tambahan dari database (misalnya nama member)
    $id_member = $transaction_info['id_member'];
    $query_member = "SELECT Nama FROM member WHERE id_member = '$id_member'";
    $result_member = mysqli_query($koneksi, $query_member);
    $row_member = mysqli_fetch_assoc($result_member);

    $member_name = $row_member['Nama'];

    // Header HTML untuk struk transaksi
    $html = '<html><head>';
    $html .= '<style>
                body { font-family: Arial, sans-serif; }
                .container { width: 100%; max-width: 300px; margin: 0 auto; }
                .header { text-align: center; margin-bottom: 10px; }
                .header h1 { margin: 0; font-size: 20px; }
                .header h2 { margin: 0; font-size: 14px; }
                .header p { margin: 0; font-size: 10px; }
                hr { border: none; border-top: 1px dashed #000; margin: 5px 0; }
                .content { margin-bottom: 10px; }
                .content p { margin: 3px 0; font-size: 12px; }
                .footer { text-align: center; margin-top: 10px; font-size: 10px; }
              </style>';
    $html .= '<script type="text/javascript">
                function triggerPrint() {
                    window.print();
                }
              </script>';
    $html .= '</head><body onload="triggerPrint()">';

    // Informasi header struk
    $html .= '<div class="container">';
    $html .= '<div class="header">
                <h1>BreakRoom</h1>
                <h2>Jl.Simpang Golf Kav.11, Malang, Jawa Timur</h2>
                <p>Telepon: (021) 8976542456 | Email: breakroom@idn.com</p>
              </div>';
    $html .= '<hr/>';

    $html .= '<center><h3>Struk Transaksi</h3></center>';

    // Detail transaksi
    $html .= '<div class="content">';
    $html .= '<p><strong>ID Transaksi:</strong> ' . $transaction_info['id_trxTableBilliard'] . '</p>';
    $html .= '<p><strong>Nama Member:</strong> ' . $member_name . '</p>';
    $html .= '<p><strong>ID Pemesanan Meja:</strong> ' . $transaction_info['id_trxTableBilliard'] . '</p>';
    $html .= '<p><strong>Tanggal Checkout:</strong> ' . $transaction_info['Date_checkout'] . '</p>';
    $html .= '<p><strong>Waktu Checkout:</strong> ' . $transaction_info['Time_checkout'] . '</p>';
    $html .= '<p><strong>Jumlah Pembayaran:</strong> Rp ' . number_format($transaction_info['Amount'], 0, ',', '.') . '</p>';

    $html .= '</div>';
    $html .= '<div class="container">';
    $html .= '<div class="header">
                <p>Grettings Billiards Without Gambling!!</p>
              </div>';
    $html .= '<hr/>';
    $html .= '<hr/>';

    $html .= '<div class="footer">Generated by BreakRoom.idn | ' . date('Y-m-d') . '</div>';
    $html .= '</div>'; // Penutup container

    $html .= '</body></html>';

    // Muat HTML ke DOMPDF
    $dompdf->loadHtml($html);

    // Atur ukuran dan orientasi kertas (contoh: A6, portrait)
    $dompdf->setPaper('A6', 'portrait');

    // Render PDF (akan tampil jendela cetak PDF)
    $dompdf->render();

    // Tampilkan PDF dalam browser
    $dompdf->stream('struk-transaksi.pdf', array("Attachment" => false));
} else {
    // Jika tidak ada informasi transaksi dalam session, redirect ke halaman lain atau lakukan sesuai dengan logika aplikasi Anda
    echo "Informasi transaksi tidak tersedia.";
}
?>