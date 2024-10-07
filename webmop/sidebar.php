<div class="sidebar">
    <div class="user-info">
        <img src=<?php echo 'img/' . $user['foto_user']?> alt="User Photo" class="user-photo">
        <p class="user-name"><?php echo htmlspecialchars($user['username']); ?></p>
    </div>
    <ul>
        <li><a href="index.php"><span><i class="fas fa-home"></i> Home</span></a></li>
        <li><a href="perusahaan.php"><span><i class="fas fa-building"></i> Identitas Usaha</span></a></li>
        <li>
            <a href="#" class="menu-toggle"><span><i class="fas fa-users"></i> Master</span><i class="fas fa-chevron-right arrow"></i></a>
            <ul class="sub-menu">
                <li><a href="stok.php"><span>Stok</span></a></li>
                <li><a href="pembelian.php"><span>Pembelian</span></a></li>
                <li><a href="ribet.php"><span>Penjualan</span></a></li>
            </ul>
        </li>
        <li><a href="logout.php"><span><i class="fas fa-sign-out-alt"></i> Logout</span></a></li>
    </ul>
    <div class="toggle-sidebar">
        <i class="fas fa-bars"></i>
    </div>
</div>
