<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/main.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <div class="wrapper">
            <nav>
                <div class="logo">
                    <h1>Break<span>Room.id</span></h1>
                </div>  
                <input type="checkbox" id="click">
                <label for="click" class="mobile_menu_btn">
                    <i class="fa-solid fa-bars-staggered"></i>
                </label>
                <ul>
                <li><a href="index.php">Beranda</a></li>
                <li><a href="#" id="tableAvailable">Table Available</a></li>
                <li><a href="#" id="foodBeverage">Food & Beverage</a></li>
                <li><a href="#" id="store">Store</a></li>
                <li><a href="#" id="contact">Contact</a></li>
                <li><a href="login.php" class="login-btn">Login</a></li>
                </ul>
            </nav>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="breakroom_text">
            <span>BreakRoom.id :</span>
            <h3>Greetings Billiards Without gambling!</h3>
            <p>Where every moment tells a story<br> and every game brings joy. </p>
            <button class="primary_btn">Book a Table</button>
            <button>About Us</button>
        </div>
    </div>  

    <div class="cards-container">
        <div class="owl-carousel owl-carousel1 owl-theme">
          <div>
            <div class="card text-center"><img class="card-img-top" src="assets/image/testi1.jpg" alt="">
              <div class="card-body">
                <h5>Ricky Yang<br />
                </h5>
                <p class="card-text">"Tempat billiard ini adalah tempat yang saya rekomendasikan! Saya sering menggunakan layanan sewa online mereka dan itu sangat nyaman. Tempatnya bersih dan terawat dengan baik, membuat pengalaman bermain billiard semakin menyenangkan."</p>
              </div>
            </div>
          </div>
          <div>
            <div class="card text-center"><img class="card-img-top" src="assets/image/testi2.jpg" alt="">
              <div class="card-body">
                <h5>Angeline Magdalena Ticoalu<br />
                </h5>
                <p class="card-text">"Saya sangat senang dengan pengalaman bermain billiard di tempat ini. Sewa online sangat memudahkan saya untuk merencanakan kunjungan saya. Tempatnya nyaman dan fasilitasnya bagus sekali!"</p>
              </div>
            </div>
          </div>
          <div>
            <div class="card text-center"><img class="card-img-top" src="assets/image/testi3.jpg" alt="">
              <div class="card-body">
                <h5>Irsal A Nasution<br />
                </h5>
                <p class="card-text">"Tempat ini luar biasa! Saya suka bagaimana saya bisa memesan meja billiard secara online dan tiba-tiba berada di sana tanpa harus menunggu. Suasananya sangat nyaman, dan peralatan billiardnya terawat dengan baik." </p>
              </div>
            </div>
          </div>
          <div>
            <div class="card text-center"><img class="card-img-top" src="assets/image/testi4.jpg" alt="">
              <div class="card-body">
                <h5>Fathrah Masum<br />
                </h5>
                <p class="card-text">"Saya baru-baru ini menemukan tempat ini dan saya sangat terkesan! Proses penyewaan online sangat lancar, dan ketika saya tiba di sana, saya langsung merasa nyaman. Fasilitasnya bagus dan saya pasti akan kembali lagi!"</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="popupOverlay" style="display:none;">
        <div id="popupBox">
            <div id="popupContent">
                <p>Silahkan Login Terlebih Dahulu</p>
                <button id="closePopup">Close</button>
            </div>
        </div>
      </div>

      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
      <script src="js/main.js"></script>
      <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tombolTampilkanPopup = ["tableAvailable", "foodBeverage", "store", "contact"];
            const overlayPopup = document.getElementById("popupOverlay");
            const tombolTutupPopup = document.getElementById("closePopup");
        
            function togglePopup() {
                overlayPopup.style.display = (overlayPopup.style.display == "flex") ? "none" : "flex";
            }
        
            tombolTampilkanPopup.forEach(id => {
                const elemen = document.getElementById(id);
                if (elemen) {
                    elemen.addEventListener('click', function(event) {
                        event.preventDefault();
                        togglePopup();
                    });
                }
            });
        
            tombolTutupPopup.addEventListener('click', togglePopup);
        });
        </script>
</body>
</html>