<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
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
    <title>Food And Beverage</title>
    <link rel="stylesheet" href="css/food.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="fontawesome/fontawesome-free-6.2.1-web/css/all.css">
</head>
<body>
    <div class="wrapper">
        <input type="checkbox" id="btn" hidden>
        <label for="btn" class="menu-btn"><i class="ph-thin ph-bowl-food"></i></label>
        </label>
        <nav id="sidebar">
            <div class="logo">
                <h1 style="text-align: center; color: white; font-size: 30px;">Break<span style="color: #ffe600;">Room.id</span></h1>
            </div>
            <ul class="list-items">
                <li><a href="admin.php"><i class="fas fa-home"></i>Home</a></li>
                <li><a href="tablebook.php"><i class="fas fa-table"></i>Table Book</a></li>
                <li><a href="food.php"><i class="fas fa-food-beverage"></i>Food And Beverage</a></li>
                <li><a href="livetable.php"><i class="fas fa-live-table"></i>Live Table</a></li>
                <li><a href="transaction.php"><i class="fas fa-trx"></i>Transaction</a></li>
                <li><a href="logout.php"><i class="fas fa-logout"></i>Log Out</a></li>
            </ul>
        </nav>
    </div>

    <div class="container">
        <div class="breakroom_text">
            <h3>Food And Beverage</h3>
            <form action="">
                <div class="form-group">
                    <label for="table">Table Number:</label>
                    <input type="number" id="table" name="table">
                
                <div class="form-group">
                    <label for="food">Food:</label>
                    <select id="food" name="food">
                        <option value="">Select Food</option>
                        <option value="nasi_goreng">Nasi Goreng</option>
                        <option value="mie_ayam">Mie Ayam</option>
                        <option value="sate">Sate</option>
                        <option value="ayam_goreng">Ayam Goreng</option>
                        <option value="rendang">Rendang</option>
                        <option value="soto">Soto</option>
                        <option value="gado_gado">Gado-gado</option>
                        <option value="bakso">Bakso</option>
                        <option value="sop_iga">Sop Iga</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="beverage">Beverage:</label>
                    <select id="beverage" name="beverage">
                        <option value="">Select Beverage</option>
                        <option value="es_teh">Es Teh</option>
                        <option value="es_kopi">Es Kopi</option>
                        <option value="jus_jeruk">Jus Jeruk</option>
                    </div>
                    </select>
                </div>
                <input type="submit" value="Submit">
            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
