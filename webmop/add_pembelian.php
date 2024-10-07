<?php
session_start();
require 'config.php';

if($_SERVER['REQUEST_METHOD']== 'POST'){
    $idpem = $_POST['idpem'];
    $idbar = $_POST['id_barang'];
    $manufaktur = $_POST['manufaktur'];
    $jumlah = $_POST['jumlah'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];

    $total = intval($jumlah) * intval($harga);

    $stmt = $conn->prepare("SELECT jumlah_barang FROM stok where id_barang = '$idbar'");
    $stmt->execute();
    $stmt->bind_result($barang);
    $stmt->fetch();
    $stmt->close();

    $stok = intval($barang) + intval($jumlah); 

    $stmt = $conn->prepare("INSERT INTO pembelian (id_pembelian,id_barang,manufaktur,jumlah_pembelian,harga,total_pembelian,status) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssss",$idpem,$idbar,$manufaktur,$jumlah,$harga,$total,$status);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("UPDATE stok SET jumlah_barang = ? where id_barang = ?");
    $stmt->bind_param("ss",$stok, $idbar);

    if($stmt->execute()){
        $_SESSION['massage'] = ['type'=> 'success', 'text'=>'Data departemen berhasil ditambah.'];
    }else{
        $_SESSION['massage'] = ['type'=> 'success', 'text'=>'Data departemen gagal ditambah.'];
    }
    $stmt->close();
    header("Location: pembelian.php");
    exit();
}else{
    header("Location: pembelian.php");
    exit();
}
?>