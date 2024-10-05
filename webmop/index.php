<?php
require 'config.php';
require 'header.php';

$iduser = $_SESSION['user'];

// Ambil data user dari database
$stmt = $conn->prepare("SELECT username, email FROM user WHERE id_user = ?");
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

//get data from db
$sql = "SELECT * from pegawai";
$result = mysqli_query($conn, $sql);
$pegawai = mysqli_num_rows( $result );

$sql = "SELECT * from penghargaan";
$result = mysqli_query($conn, $sql);
$penghargaan = mysqli_num_rows( $result );

$sql = "SELECT * from peringatan";
$result = mysqli_query($conn, $sql);
$peringatan = mysqli_num_rows( $result );

$sql = "SELECT * from cuti";
$result = mysqli_query($conn, $sql);
$cuti = mysqli_num_rows( $result );

// Ambil data dari tabel departemen
$result = $conn->query("SELECT * FROM departemen");

// Dapatkan nomor urut terbaru untuk iddep baru
$stmt = $conn->query("SELECT id_departemen FROM departemen ORDER BY id_departemen DESC LIMIT 1");
$latestiddep = $stmt->fetch_assoc();
$urut = 1;
if ($latestiddep) {
    $latestNumber = (int) substr($latestiddep['id_departemen'], 1);
    $urut = $latestNumber + 1;
}
$newiddep = 'D' . str_pad($urut, 3, '0', STR_PAD_LEFT);

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
                <div class="card card-tipe">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Total Pegawai</h5>
                                <h4><p><?php echo $pegawai?></p></h4>
                            </div>
                            <div class="card-icon-wrapper">
                                <i class="fas fa-users card-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Penghargaan -->
                <div class="card card-stok">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5>Penghargaan</h5>
                                <h4><p><?php echo $penghargaan?></p></h4>
                            </div>
                            <div class="card-icon-wrapper">
                                <i class="fas fa-award card-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Peringatan -->
                <div class="card card-merek">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5>Peringatan</h5>
                                <h4><p><?php echo $peringatan?></p></h4>
                            </div>
                            <div class="card-icon-wrapper">
                                <i class="fas fa-exclamation-triangle card-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Cuti -->
                <div class="card card-polis">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5>Cuti</h5>
                                <h4><p><?php echo $cuti?></p></h4>
                            </div>
                            <div class="card-icon-wrapper">
                                <i class="fas fa-calendar-alt card-icon"></i>
                            </div>
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
