document.addEventListener('DOMContentLoaded', function() {
    function loadBookingData() {
        const tableBody = document.getElementById('liveTable').getElementsByTagName('tbody')[0];
        const bookings = JSON.parse(localStorage.getItem('bookings')) || [];
    
        tableBody.innerHTML = ''; 
    
        bookings.forEach(function(booking, index) {
            const row = `<tr>
                            <td>${booking.name}</td>
                            <td>${booking.date}</td>
                            <td>${booking.checkInTime}</td>
                            <td>${booking.tableNumber}</td>
                            <td><button onclick="stopBooking(${index})">Stop</button></td>
                        </tr>`;
            tableBody.innerHTML += row;
        });
    }
    

    function stopBooking(index) {
        const bookings = JSON.parse(localStorage.getItem('bookings')) || [];
        const booking = bookings.splice(index, 1)[0]; 
        localStorage.setItem('bookings', JSON.stringify(bookings));
    
        const checkOutTime = new Date();
        const checkInDateTime = new Date(`${booking.date}T${booking.checkInTime}`);
        const diffMinutes = (checkOutTime - checkInDateTime) / 60000; 
        const amount = diffMinutes * 500;
    
        const transaction = {
            nama: booking.name,
            table: booking.tableNumber,
            tanggal: booking.date,
            jamCheckIn: booking.checkInTime,
            jamCheckOut: checkOutTime.toLocaleTimeString(),
            jumlah: `Rp ${amount.toLocaleString()}`
        };
    
        const transactions = JSON.parse(localStorage.getItem('transactions')) || [];
        transactions.push(transaction);
        localStorage.setItem('transactions', JSON.stringify(transactions));
    
        loadBookingData();
        alert('Berhasil Checkout');
    }
    

    window.stopBooking = stopBooking;

    loadBookingData();
});
