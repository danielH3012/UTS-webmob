<?php
session_start();
require 'config.php';

if($_SERVER['REQUEST_METHOD']== 'POST'){
    $idpen = $_POST['id'];

    $stmt = $conn->prepare("SELECT status_pesanan FROM penjualan where id_penjualan = '$idpen'");
    $stmt->execute();
    $stmt->bind_result($status);
    $stmt->fetch();
    $stmt->close();

    if($status == "lunas"){
        $status = "belum";
    }else{
        $status = "lunas";
    }

    $stmt = $conn->prepare("UPDATE penjualan SET status_pesanan = ? WHERE id_penjualan = ?");
    $stmt->bind_param("ss",$status,$idpen);

    if($stmt->execute()){
        echo "data berhasil dihapus";
    }else{
        echo "data gagal dihapus";
    }
    $stmt->close();
    header("Location: ribet.php");

}
?>