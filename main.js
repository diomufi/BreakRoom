(function () {
  "use strict";

  var carousels = function () {
    $(".owl-carousel1").owlCarousel({
      loop: true,
      center: true,
      margin: 0,
      responsiveClass: true,
      nav: false,
      responsive: {
        0: {
          items: 1,
          nav: false,
        },
        680: {
          items: 2,
          nav: false,
          loop: false,
        },
        1000: {
          items: 3,
          nav: true,
        },
      },
    });
  };

  $(document).ready(function () {
    carousels();
  });
})();

document.getElementById("startButton").addEventListener("click", startBooking);

function startBooking() {
  var currentTime = new Date();
  var hours = currentTime.getHours().toString().padStart(2, "0");
  var minutes = currentTime.getMinutes().toString().padStart(2, "0");
  var timeString = hours + ":" + minutes;
  document.getElementById("StartTimeLabel").innerHTML =
    "Waktu dimulai pada jam " + timeString;
  setTimeout(function () {
    document.getElementById("StartTimeLabel").innerHTML = "";
  }, 5000);
}
