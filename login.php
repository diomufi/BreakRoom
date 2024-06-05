<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/logreg.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="js/main.js"></script>
</head>
<body>
<?php
session_start();
// Dummy data untuk contoh
$login_error = false;
$dummy_user_email = "user@mufi.com";
$dummy_user_password = "user123";
$dummy_admin_email = "admin@mufi.com";
$dummy_admin_password = "admin123";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($role == "admin" && $email == $dummy_admin_email && $password == $dummy_admin_password) {
        $_SESSION['user_role'] = 'admin';
        $_SESSION['username'] = 'Dio Masafan Mufio Rois';
        header("Location: admin.php");
        exit;
    } elseif ($role == "user" && $email == $dummy_user_email && $password == $dummy_user_password) {
        $_SESSION['user_role'] = 'user';
        $_SESSION['username'] = 'Mufio Masafan';
        header("Location: dashboard.php");
        exit;
    } else {
      echo "<script>alert('Hayo, passwordnya salah loh');</script>";
    }
}
?>

<header>
<div class="wrapper">
    <nav>
      <div class="logo">
        <h1>Break<span>Room.id</span></h1>
      </div>

      <input type="checkbox" id="click" />
      <label for="click" class="mobile_menu_btn">
        <i class="fa-solid fa-bars-staggered"></i>
      </label>
      <ul>
        <li><a href="index.php">Beranda</a></li>
        <li><a href="#">Table Available</a></li>
        <li><a href="#">Food & Beverage</a></li>
        <li><a href="#">Store</a></li>
        <li><a href="#">Contact</a></li>
        <li><a href="login.php" class="login-btn">Login</a></li>
      </ul>
    </nav>
  </div>
</header>
<div class="main">      
<input type="checkbox" id="chk" aria-hidden="true">
    <div class="signup">
    <form>
        <label for="chk" aria-hidden="true">Sign up</label>
        <input type="text" name="txt" placeholder="User name" required="">
        <input type="email" name="email" placeholder="Email" required="">
        <input type="password" name="pswd" placeholder="Password" required="">
        <button>Sign up</button>
      </form>
    </div>
    <div class="login">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
          <label for="chk" aria-hidden="true">Login</label>
          <input type="email" name="email" placeholder="Email" required="">
          <input type="password" name="password" placeholder="Password" required="">
          <button type="submit" name="role" value="user">Login User</button>
          <button type="submit" name="role" value="admin">Login Admin</button>
      </form>            
  </div>
</div>
</body>
</html>
