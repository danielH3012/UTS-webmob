<?php
//session_start();
require 'config.php';
include('header.php'); 
//include('sidebar.php');
//if (!isset($_SESSION['iduser'])) {
  // header("Location: login.php");
    //exit();
//}

$iduser = $_SESSION['user'];

// Ambil data dari tabel departemen
$result = $conn->query("SELECT * FROM namausaha");
$usaha = $result->fetch_row();

// Simpan pesan ke variabel dan hapus dari session
$message = null;
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>
<header>
        <h4><?php echo htmlspecialchars($usaha[0]); ?></h4>
        <p><?php echo htmlspecialchars($usaha[1]); ?></p>
    </header>
 <?php include 'sidebar.php'; ?>
 <div class="content" id="content">
 
    <table border="3" style="width :100%;">
        <tr>
            <td style="width: 20%;background-color: darkgray; text-align:center;">NAMA</td>
            <td style="width: 80%; text-align: left; padding: 1%; padding-left: 5%;background-color:lightgray;"><?php echo $usaha[0];?></td>
        </tr>
        <tr>
            <td style="width: 20%;background-color:darkgray; text-align:center;">ALAMAT</td>
            <td style="width: 80%; text-align: left; padding: 1%; padding-left: 5%;background-color:lightgray;"><?php echo $usaha[1];?></td>
        </tr>
        <tr>
            <td style="width: 20%;background-color:darkgray; text-align:center;">NOMOR TELEPON</td>
            <td style="width: 80%; text-align: left; padding: 1%; padding-left: 5%;background-color:lightgray;"><?php echo $usaha[2];?></td>
        </tr>
        <tr>
            <td style="width: 20%;background-color:darkgray; text-align:center;">FAX</td>
            <td style="width: 80%; text-align: left; padding: 1%; padding-left: 5%;background-color:lightgray;"><?php echo $usaha[3];?></td>
        </tr>
        <tr>
            <td style="width: 20%;background-color:darkgray; text-align:center;">EMAIL</td>
            <td style="width: 80%; text-align: left; padding: 1%; padding-left: 5%;background-color:lightgray;"><?php echo $usaha[4];?></td>
        </tr>
        <tr>
            <td style="width: 20%;background-color:darkgray; text-align:center;">NPWP</td>
            <td style="width: 80%; text-align: left; padding: 1%; padding-left: 5%;background-color:lightgray;"><?php echo $usaha[5];?></td>
        </tr>
        <tr>
            <td style="width: 20%;background-color:darkgray; text-align:center;">BANK</td>
            <td style="width: 80%; text-align: left; padding: 1%; padding-left: 5%;background-color:lightgray;"><?php echo $usaha[6];?></td>
        </tr>
        <tr>
            <td style="width: 20%;background-color:darkgray; text-align:center;">NOMOR AKUN</td>
            <td style="width: 80%; text-align: left; padding: 1%; padding-left: 5%;background-color:lightgray;"><?php echo $usaha[7];?></td>
        </tr>
        <tr>
            <td style="width: 20%;background-color:darkgray; text-align:center;">ATAS NAMA</td>
            <td style="width: 80%; text-align: left; padding: 1%; padding-left: 5%;background-color:lightgray;"><?php echo $usaha[8];?></td>
        </tr>
        <tr>
            <td style="width: 20%;background-color:darkgray; text-align:center;">PIMPINAN</td>
            <td style="width: 80%; text-align: left; padding: 1%; padding-left: 5%;background-color:lightgray;"><?php echo $usaha[9];?></td>
        </tr>
    </table>
    <button style="width:100%" type="button" class="btn btn-primary mb-3 mr-2" data-bs-toggle="modal" data-bs-target="#adddepartemenModal"><i class='fas fa-plus'></i> Edit </button>
    <?php require 'footer.php'; ?>
 </div>

 <div class="modal fade" id="adddepartemenModal" tabindex="-1" aria-labelledby="adddepartemenModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adddepartemenModalLabel">edit usaha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="edit_perusahaan.php" method="post">
                <div class="form-group">
        <label>NAMA:</label> 
            <input type="txt" name="nama" value="<?php echo $usaha[0];?>" class="form-control" required/>
    </div>

    <div class="form-group">
        <label>ALAMAT:</label> 
            <input type="txt" name="alamat" value="<?php echo $usaha[1];?>" class="form-control" required/>
    </div>

    <div class="form-group">
        <label>NOMOR TELEPON:</label> 
            <input type="txt" name="notelp" value="<?php echo $usaha[2];?>" class="form-control" required/>
    </div>

    <div class="form-group">
        <label>FAX:</label> 
            <input type="txt" name="fax" value="<?php echo $usaha[3];?>" class="form-control" required/>
    </div>
    <div class="form-group">
        <label>EMAIL:</label> 
            <input type="txt" name="email" value="<?php echo $usaha[4];?>" class="form-control" required/>
    </div>
    <div class="form-group">
        <label>NPWP:</label> 
            <input type="txt" name="npwp" value="<?php echo $usaha[5];?>" class="form-control" required/>
    </div>
    <div class="form-group">
        <label>BANK:</label> 
            <input type="txt" name="bank" value="<?php echo $usaha[6];?>" class="form-control" required/>
    </div>
    <div class="form-group">
        <label>NOMOR ACCOUNT:</label> 
            <input type="txt" name="akun" value="<?php echo $usaha[7];?>" class="form-control" required/>
    </div>
    <div class="form-group">
        <label>ATAS NAMA:</label> 
            <input type="txt" name="an" value="<?php echo $usaha[8];?>" class="form-control" required/>
    </div>
    <div class="form-group">
        <label>PIMPINAN:</label> 
            <input type="txt" name="pimpinan" value="<?php echo $usaha[9];?>" class="form-control" required/>
    </div>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

</body>
</html>
