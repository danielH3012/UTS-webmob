<?php
session_start();
require 'config.php';

if($_SERVER['REQUEST_METHOD']== 'POST'){
    $idpem = $_POST['id'];

    $stmt = $conn->prepare("SELECT status FROM pembelian where id_pembelian = '$idpem'");
    $stmt->execute();
    $stmt->bind_result($status);
    $stmt->fetch();
    $stmt->close();

    if($status == "lunas"){
        $status = "belum";
    }else{
        $status = "lunas";
    }

    $stmt = $conn->prepare("UPDATE pembelian SET status = ? WHERE id_pembelian = ?");
    $stmt->bind_param("ss",$status,$idpem);

    if($stmt->execute()){
        echo "data berhasil dihapus";
    }else{
        echo "data gagal dihapus";
    }
    $stmt->close();
    header("Location: pembelian.php");

}
?>