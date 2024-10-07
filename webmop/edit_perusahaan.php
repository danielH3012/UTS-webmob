<?php
session_start();
require 'config.php';

if($_SERVER['REQUEST_METHOD']== 'POST'){
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $notelp = $_POST['notelp'];
    $fax = $_POST['fax'];
    $email = $_POST['email'];
    $npwp = $_POST['npwp'];
    $bank = $_POST['bank'];
    $akun = $_POST['akun'];
    $atasnama = $_POST['an'];
    $pimpinan = $_POST['pimpinan'];


    $stmt = $conn->prepare("UPDATE namausaha SET nama = ?, alamat = ?, no_telp = ?,fax = ?,email = ?,npwp = ?,bank = ?,no_rek = ?,atas_nama = ?,pimpinan = ?  ");
    $stmt->bind_param("ssssssssss",$nama,$alamat,$notelp,$fax,$email,$npwp,$bank,$akun,$atasnama,$pimpinan);

    if($stmt->execute()){
        $_SESSION['massage'] = ['type'=> 'success', 'text'=>'Data departemen berhasil diperbaharui.'];
    }else{
        $_SESSION['massage'] = ['type'=> 'success', 'text'=>'Data departemen gagal diperbaharui.'];
    }
    $stmt->close();
    header("Location: perusahaan.php");
    exit();
}else{
    header("Location: perusahaan.php");
    exit();
}
?>