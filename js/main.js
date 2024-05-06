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
  event.preventDefault();

  var name = document.getElementById('name').value;
  var date = document.getElementById('date').value;
  var time = document.getElementById('time').value; 
  var tableNumber = document.getElementById('table').value;

  if (!name || !date || !time || !tableNumber) {
      alert('Isi data tanpa terlewati');
      return;
  }

  var booking = {
      name: name,
      date: date,
      checkInTime: time, 
      tableNumber: tableNumber
  };

  var bookings = JSON.parse(localStorage.getItem('bookings')) || [];
  bookings.push(booking);
  localStorage.setItem('bookings', JSON.stringify(bookings));
  alert('Informasi Booking telah tersimpan');

  var currentTime = new Date();
  var hours = currentTime.getHours().toString().padStart(2, '0');
  var minutes = currentTime.getMinutes().toString().padStart(2, '0');
  var timeString = hours + ":" + minutes;
  document.getElementById("StartTimeLabel").innerHTML = "Memulai pada pukul " + timeString;

  setTimeout(function () {
      document.getElementById("StartTimeLabel").innerHTML = "";
  }, 5000);

  document.getElementById('name').value = '';
  document.getElementById('date').value = '';
  document.getElementById('time').value = '';
  document.getElementById('table').value = '';
}


