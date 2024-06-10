<?php 
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'breakroom';
$koneksi = mysqli_connect($servername, $username, $password, $database);
if(!$koneksi) {
    die('Connection Failed:' . mysqli_connect_error());
}
 ?>
