<?php
require 'config.php';
require 'header.php';

$iduser = $_SESSION['user'];

// Ambil data user dari database
$stmt = $conn->prepare("SELECT username, password FROM user WHERE id_user = ?");
$stmt->bind_param("i", $iduser);
$stmt->execute();
$stmt->bind_result($username, $email);
$stmt->fetch();
$stmt->close();

// Ambil data nama usaha dan alamat dari database
$stmt = $conn->prepare("SELECT nama, alamat FROM namausaha LIMIT 1");
$stmt->execute();
$stmt->bind_result($namaUsaha, $alamatUsaha);
$stmt->fetch();
$stmt->close();

$sql = "SELECT * from penjualan where status_pesanan = 'belum'";
$result = mysqli_query($conn, $sql);
$penjualan = mysqli_num_rows( $result );

$sql = "SELECT * from penjualan where status_pesanan = 'lunas'";
$result = mysqli_query($conn, $sql);
$penjualan_done = mysqli_num_rows( $result );

$sql = "SELECT * from pembelian where status = 'belum'";
$result = mysqli_query($conn, $sql);
$pembelian = mysqli_num_rows( $result );

$sql = "SELECT * from pembelian where status = 'lunas'";
$result = mysqli_query($conn, $sql);
$pembelian_done = mysqli_num_rows( $result );

// Simpan pesan ke variabel dan hapus dari session
$message = null;
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>


<div class="wrapper">
    <header>
        <h4><?php echo htmlspecialchars($namaUsaha); ?></h4>
        <p><?php echo htmlspecialchars($alamatUsaha); ?></p>
    </header>

    <?php include 'sidebar.php'; ?>
    
    <style>
        .cards-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between; /* Ensure space between cards */
        }
        .cards-container .card {
            flex: 1 1 23%; /* Cards will take 23% of the width with space between */
            margin: 10px 0;
            box-sizing: border-box;
            min-width: 250px; /* Minimal width to ensure responsive */
        }
        .card-icon-wrapper {
            background-color: #f0f0f0;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-icon {
            font-size: 1.8rem;
            color: #333;
        }

        /* Styling for the full-width card */
        .full-width-card {
            width: 100%;
            margin-top: 20px;
            box-sizing: border-box;
        }

        .container-fluid {
            padding: 0 10px;
        }
    </style>

    <div class="content" id="content">
        <div class="container-fluid mt-3">
            <div class="cards-container">
                <!-- Card 1: Total Pegawai -->
                <div class="card card-merek">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Penjualan Belum Dibayar</h5>
                                <h4><p><?php echo $penjualan?></p></h4>
                            </div>
                            <div class="card-icon-wrapper">
                                <i class="fas fa-exclamation-triangle card-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Penghargaan -->
                <div class="card card-stok">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5>Penjualan Lunas</h5>
                                <h4><p><?php echo $penjualan_done?></p></h4>
                            </div>
                            <div class="card-icon-wrapper">
                                <i class="fas fa-award card-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Peringatan -->
                <div class="card card-polis">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5>Pembelian belum lunas</h5>
                                <h4><p><?php echo $pembelian?></p></h4>
                            </div>
                            <div class="card-icon-wrapper">
                                <i class="fas fa-exclamation-triangle card-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Peringatan -->
                <div class="card card-tipe">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5>Pembelian lunas</h5>
                                <h4><p><?php echo $pembelian_done?></p></h4>
                            </div>
                            <div class="card-icon-wrapper">
                                <i class="fas fa-users card-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- Full-width card for Aplikasi Kepegawaian -->
            <div class="full-width-card">
                <div class="card w-100">
                    <div class="card-header"><strong>Aplikasi Kepegawaian</strong></div>
                    <img src="logo/bg4.jpg" class="img-fluid" style="display:block; margin:auto;">
                </div>
            </div>
        </div>
    </div>

    <?php require 'footer.php'; ?>
</div>
</body>
</html>
