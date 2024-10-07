<?php
//session_start();
require 'config.php';
 require 'header.php'; 
//include('sidebar.php');
//if (!isset($_SESSION['iduser'])) {
  // header("Location: login.php");
    //exit();
//}

$iduser = $_SESSION['user'];

// Ambil data user dari database
$stmt = $conn->prepare("SELECT username, password FROM user WHERE id_user = ?");
$stmt->bind_param("i", $iduser);
$stmt->execute();
$stmt->bind_result($username, $password);
$stmt->fetch();
$stmt->close();

// Ambil data nama usaha dan alamat dari database
$stmt = $conn->prepare("SELECT nama, alamat FROM namausaha LIMIT 1");
$stmt->execute();
$stmt->bind_result($namaUsaha, $alamatUsaha);
$stmt->fetch();
$stmt->close();

// Ambil data dari tabel departemen
$result = $conn->query("SELECT * FROM penjualan");

// Dapatkan nomor urut terbaru untuk iddep baru
$stmt = $conn->query("SELECT id_penjualan FROM penjualan ORDER BY id_penjualan DESC LIMIT 1");
$latestiddep = $stmt->fetch_assoc();
$urut = 1;
if ($latestiddep) {
    $latestNumber = $latestiddep['id_penjualan'];
    $urut = $latestNumber + 1;
}
$newiddep = $urut;

// Simpan pesan ke variabel dan hapus dari session
$message = null;
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

$barang = $conn->query("SELECT * FROM stok");

$barang1 = $conn->query("SELECT * FROM stok");

?>


<div class="wrapper">
    <header>
        <h4><?php echo htmlspecialchars($namaUsaha); ?></h4>
        <p><?php echo htmlspecialchars($alamatUsaha); ?></p>
    </header>

    <?php include 'sidebar.php'; ?>
    <div class="content" id="content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <h4>Penjualan</h4>
                    <div>
                        <button type="button" class="btn btn-primary mb-3 mr-2" data-bs-toggle="modal" data-bs-target="#adddepartemenModal"><i class='fas fa-plus'></i> Tambah </button>
                        <button type="button" class="btn btn-secondary mb-3" id="printButton"><i class='fas fa-print'></i>Cetak</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="departemenTable" class="table table-bordered table-striped table-hover">    
                            <thead class="text-center">
                                <tr>
                                    <th class='text-center'>No</th>
                                    <th class='text-center'>Kode Pembelian</th>
                                    <th class='text-center'>ID barang</th>
                                    <th class='text-center'>Nama Pemesan</th>
                                    <th class='text-center'>Jumlah</th>
                                    <th class='text-center'>Total Penjualan</th>
                                    <th class='text-center'>Tanggal Pesan</th>
                                    <th class='text-center'>Status</th>
                                    <th class='text-center'>Denda</th>
                                    <th class='text-center'>Total Bayar</th>
                                    <th class='text-center'>Jatuh Tempo</th>
                                    <th class='text-center'>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result && $result->num_rows > 0) {
                                    $no = 1;
                                    while ($departemen = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td class='text-center'>" . $no++ . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($departemen['id_penjualan']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($departemen['id_barang']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($departemen['nama_pemesan']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($departemen['jumlah_pesanan']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($departemen['total_penjualan']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($departemen['tanggal_pesan']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($departemen['status_pesanan']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($departemen['denda']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($departemen['total_bayar']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($departemen['jatuh_tempo']) . "</td>";
                                        echo "<td class='text-center'>";
                                        echo "<div class='d-flex justify-content-center'>";
                                        echo "<form action=\"status_penjualan.php\" method=\"post\"> 
                                                <button class='btn btn-warning btn-sm edit-btn mr-1' style=\"background-color: chocolate;\" name=\"id\" type=\"submit\" value=\"".$departemen['id_penjualan']."\">change status</button> 
                                              </form>";
                                        echo "<button class='btn btn-danger btn-sm delete-btn' data-id='" . htmlspecialchars($departemen['id_penjualan']) . "'><i class='fas fa-trash'></i> Delete</button>";
                                        echo "</div>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center'>No data found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require 'footer.php'; ?>
</div>

<!-- Modal Add departemen -->
<div class="modal fade" id="adddepartemenModal" tabindex="-1" aria-labelledby="adddepartemenModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adddepartemenModalLabel">Masukan Penjualan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="add_penjualan.php" method="post">
                    <div class="mb-3">
                        <label for="iddep" class="form-label">Kode Penjualan</label>
                        <input type="text" class="form-control" id="iddep" name="idpen" value="<?php echo htmlspecialchars($newiddep); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="id_departemen" class="form-label">ID Barang</label>
                        <br>
                        <select name="id_barang" id="edit_id_departemen" style="width:100%;"required>
                    <?php 
                        while ($pilihan = $barang->fetch_row()) {
                            echo "<option value=". $pilihan[0]." style=\"text-align:center;\">". $pilihan[1]."</option>" ; 
                    }
                    ?> 
                    </select>
                    </div>
                    <div class="mb-3">
                        <label for="iddep" class="form-label">Nama Pemesan</label>
                        <input type="text" class="form-control" id="iddep" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="iddep" class="form-label">Jumlah</label>
                        <input type="text" class="form-control" id="iddep" name="jumlah" required>
                    </div>
                    <div class="mb-3">
                        <label for="iddep" class="form-label">tanggal</label>
                        <input type="date" class="form-control" id="iddep" name="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="id_departemen" class="form-label">Status</label>
                        <select name="status" id="edit_id_departemen" style="width:100%;" required>
                             <option value="lunas">lunas</option>  
                             <option value="belum">belum</option>  
                    </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
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

<script>
    $(document).ready(function() {
        // Adjust DataTables' scrolling to avoid overlapping with the footer
        function adjustTableHeight() {
            var footerHeight = $('footer').outerHeight();
            var tableHeight = 'calc(100vh - 290px - ' + footerHeight + 'px)';

            $('#departemenTable').DataTable().destroy();
            $('#departemenTable').DataTable({
                "pagingType": "simple_numbers",
                "scrollY": tableHeight,
                "scrollCollapse": true,
                "paging": true
            });
        }

        // Call the function to adjust table height initially
        adjustTableHeight();

        // Adjust table height on window resize
        $(window).resize(function() {
            adjustTableHeight();
        });

        // Populate edit modal with data
        $('#editdepartemenModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var iddep = button.data('id');
            var idbar = button.data('idbar');
            var manufaktur = button.data('manu');
            var jumlah = button.data('jumlah');
            var harga = button.data('harga');
            
            var modal = $(this);
            modal.find('#edit_idpem').val(iddep);
            modal.find('#edit_idbar').val(idbar);
            modal.find('#edit_idbar1').val(idbar);
            modal.find('#edit_manufaktur').val(manufaktur);
            modal.find('#edit_jumlah').val(jumlah);
            modal.find('#edit_harga').val(harga);
        });

        // Show message if it exists in the session
        <?php if ($message): ?>
            Swal.fire({
                title: '<?php echo $message['type'] === 'success' ? 'Success!' : 'Error!'; ?>',
                text: '<?php echo $message['text']; ?>',
                icon: '<?php echo $message['type'] === 'success' ? 'success' : 'error'; ?>'
            });
        <?php endif; ?>

        // Handle delete button click
        $(document).on('click', '.delete-btn', function() {
            var iddep = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'Apa benar data tersebut dihapus',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'delete_penjualan.php',
                        type: 'POST',
                        data: { iddep: iddep },
                        success: function(response) {
                            console.log(response); // Debugging
                            if (response.includes('Success')) {
                                Swal.fire(
                                    'Deleted!',
                                    'Data berhasil dihapus.',
                                    'success'
                                ).then(function() {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    response,
                                    'error'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText); // Debugging
                            Swal.fire(
                                'Error!',
                                'An error occurred: ' + error,
                                'error'
                            );
                        }
                    });
                }
            });   
        });        
        //Print ke PDF        
        $(document).ready(function() {
            // Other existing scripts...

            // Handle print button click
            $('#printButton').click(function() {
                window.location.href = 'print_departemen.php';
            });
        });
    });
</script>
</body>
</html>