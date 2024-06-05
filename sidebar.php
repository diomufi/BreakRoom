<div class="wrapper">
    <input type="checkbox" id="btn" hidden>
    <label for="btn" class="menu-btn"><i class="ph-thin ph-list"></i></label>
    <nav id="sidebar">
        <div class="logo">
            <h1 style="text-align: center; color: white; font-size: 30px;">Break<span style="color: #ffe600;">Room.id</span></h1>
        </div>
        <ul class="list-items">
            <li><a href="admin.php"><i class=""></i>Home</a></li>
            <li><a href="tablebook.php"><i class=""></i>Table Book</a></li>
            <li><a href="livetable.php"><i class=""></i>Live Table</a></li>
            <li><a href="transaction.php"><i class=""></i>Transaction</a></li>
            <li><a href="add-member.php"><i class=""></i>Add Member</a></li>
            <?php if($_SESSION['user_role'] === 'admin'): ?>
                <li><a href="add-table.php"><i class=""></i>Add Table</a></li>
                <li><a href="admin-manage.php"><i class=""></i>Admin Manage</a></li>
                <li><a href="add-admin.php"><i class=""></i>Add Admin</a></li>
            <?php endif; ?>
            <li><a href="logout.php"><i class=""></i>Log Out</a></li>
        </ul>
    </nav>
</div>
