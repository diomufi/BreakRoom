<?php
session_start();

function connectDB() {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'breakroom';
    $koneksi = mysqli_connect($servername, $username, $password, $database);
    if (!$koneksi) {
        die('Koneksi Gagal:' . mysqli_connect_error());
    }
    return $koneksi;
}

function addUser($nama, $username, $email, $password) {
    $koneksi = connectDB();
    $query = "INSERT INTO user (Nama, Username, Email, Password) VALUES ('$nama', '$username', '$email', '$password')";
    $result = mysqli_query($koneksi, $query);
    mysqli_close($koneksi);
    return $result;
}

function login($email, $password) {
    $koneksi = connectDB();
    $queryAdmin = "SELECT * FROM admin WHERE Email='$email'";
    $queryUser = "SELECT * FROM user WHERE Email='$email'";
    
    $resultAdmin = mysqli_query($koneksi, $queryAdmin);
    $resultUser = mysqli_query($koneksi, $queryUser);
    
    if (mysqli_num_rows($resultAdmin) == 1) {
        $row = mysqli_fetch_assoc($resultAdmin);
        if ($password == $row['Password']) {
            $_SESSION['user_role'] = $row['Role'];
            $_SESSION['username'] = $row['Nama'];
            if ($row['Role'] === 'admin' || $row['Role'] === 'officer') {
                mysqli_close($koneksi);
                return 'admin.php';
            } else {
                mysqli_close($koneksi);
                return 'dashboard.php';
            }
        } else {
            mysqli_close($koneksi);
            return 'Password salah';
        }
    }
    elseif (mysqli_num_rows($resultUser) == 1) {
        $row = mysqli_fetch_assoc($resultUser);
        if ($password == $row['Password']) {
            $_SESSION['user_role'] = 'user';
            $_SESSION['username'] = $row['Nama'];
            mysqli_close($koneksi);
            return 'dashboard.php';
        } else {
            mysqli_close($koneksi);
            return 'Password salah';
        }
    } else {
        mysqli_close($koneksi);
        return 'Email tidak ditemukan';
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $result = login($email, $password);
        if (strpos($result, '.php') !== false) {
            header("Location: $result");
            exit;
        } else {
            echo "<script>alert('$result');</script>";
        }
    } elseif (isset($_POST['signup'])) {
        $nama = $_POST['nama'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['pswd'];
        $result = addUser($nama, $username, $email, $password);
        if ($result) {
            echo "<script>alert('Registrasi berhasil, silakan login');</script>";
        } else {
            echo "<script>alert('Gagal melakukan registrasi');</script>";
        }
    }
}
?>

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
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="chk" aria-hidden="true">Sign up</label>
        <input type="text" name="nama" placeholder="Name" required="">
        <input type="text" name="username" placeholder="Username" required="">
        <input type="email" name="email" placeholder="Email" required="">
        <input type="password" name="pswd" placeholder="Password" required="">
        <button type="submit" name="signup">Sign up</button>
    </form>
    </div>
    <div class="login">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
          <label for="chk" aria-hidden="true">Login</label>
          <input type="email" name="email" placeholder="Email" required="">
          <input type="password" name="password" placeholder="Password" required="">
          <button type="submit" name="login">Login</button>
      </form>            
  </div>
</div>
</body>
</html>
