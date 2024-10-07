<?php
session_start();
require 'config.php';

if($_SERVER['REQUEST_METHOD']== 'POST'){
    $idpem = $_POST['idpem'];
    $idbar = $_POST['id_barang'];
    $manufaktur = $_POST['manufaktur'];
    $jumlah = $_POST['jumlah'];
    $harga = $_POST['harga'];

    $total = intval($jumlah) * intval($harga);

    //barang baru
    $stmt = $conn->prepare("SELECT jumlah_barang FROM stok where id_barang = '$idbar'");
    $stmt->execute();
    $stmt->bind_result($barang);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("SELECT id_barang, jumlah_pembelian FROM pembelian where id_pembelian = '$idpem'");
    $stmt->execute();
    $stmt->bind_result($idlama,$jumlahpem);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("UPDATE pembelian SET id_barang = ?,manufaktur = ?,jumlah_pembelian = ?,harga = ?,total_pembelian = ? where id_pembelian = ?");
    $stmt->bind_param("ssssss",$idbar,$manufaktur,$jumlah,$harga,$total,$idpem);
    $stmt->execute();
    $stmt->close();

    if($idlama == $idbar){
        $stok = intval($barang) - intval($jumlahpem) + intval($jumlah); 
        $stmt = $conn->prepare("UPDATE stok SET jumlah_barang = ? where id_barang = ?");
        $stmt->bind_param("ss",$stok, $idbar);
    }else{
        $stmt = $conn->prepare("SELECT jumlah_barang FROM stok where id_barang = '$idlama'");
        $stmt->execute();
        $stmt->bind_result($baranglama);
        $stmt->fetch();
        $stmt->close();

        $stok = intval($baranglama) - intval($jumlahpem); 
        $stmt = $conn->prepare("UPDATE stok SET jumlah_barang = ? where id_barang = ?");
        $stmt->bind_param("ss",$stok, $idlama);
        $stmt->execute();

        $stok = intval($barang) + intval($jumlah); 
        $stmt = $conn->prepare("UPDATE stok SET jumlah_barang = ? where id_barang = ?");
        $stmt->bind_param("ss",$stok, $idbar);
    }

    

    if($stmt->execute()){
        $_SESSION['massage'] = ['type'=> 'success', 'text'=>'Data departemen berhasil diperbaharui.'];
    }else{
        $_SESSION['massage'] = ['type'=> 'success', 'text'=>'Data departemen gagal diperbaharui.'];
    }
    $stmt->close();
    header("Location: pembelian.php");
    exit();
}else{
    header("Location: pembelian.php");
    exit();
}
?>