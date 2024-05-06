document.addEventListener('DOMContentLoaded', function() {
    const transactions = JSON.parse(localStorage.getItem('transactions')) || [];
    const tableBody = document.querySelector('table tbody');

    transactions.forEach(transaction => {
        const row = `<tr>
            <td>${transaction.nama}</td>
            <td>${transaction.table}</td>
            <td>${transaction.tanggal}</td>
            <td>${transaction.jamCheckIn}</td>
            <td>${transaction.jamCheckOut}</td>
            <td>${transaction.jumlah}</td>
            <td><button onclick="deleteTransaction(this)">Delete</button></td>
        </tr>`;
        tableBody.innerHTML += row;
    });
});

function deleteTransaction(btn) {
    const row = btn.parentNode.parentNode;
    const index = Array.from(row.parentNode.children).indexOf(row);
    const transactions = JSON.parse(localStorage.getItem('transactions'));
    transactions.splice(index, 1);
    localStorage.setItem('transactions', JSON.stringify(transactions));
    row.parentNode.removeChild(row);
    alert('Transaksi dihapus');
}
