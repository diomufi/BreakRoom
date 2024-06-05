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
    <title>Book Table</title>
    <link rel="stylesheet" href="css/tablebook.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="fontawesome/fontawesome-free-6.2.1-web/css/all.css">
    <script src="js/main.js"></script>
</head>
<body>
    <div class="wrapper">
        <input type="checkbox" id="btn" hidden>
        <label for="btn" class="menu-btn"><i class="ph-thin ph-device-tablet-speaker"></i></label>
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
            <h3>Book Table</h3>
            <form id="bookingForm" action="" onsubmit="startBooking(); return false;">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required><br>
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required><br>
                <label for="time">Time:</label>
                <input type="time" id="time" name="time" required><br>
                <label for="table">Table Number:</label>
                <input type="number" id="table" name="table" required><br>
                <label for="StartTimeLabel" id="StartTimeLabel"></label>
                <input type="submit" value="Start" onclick="startBooking()">
            </form>
        </div>
    </div>
    

</body>
</html>
