<?php
session_start();
require 'config.php';

if($_SERVER['REQUEST_METHOD']== 'POST'){
    $idpen = $_POST['idpen'];
    $idbar = $_POST['id_barang'];
    $nama = $_POST['nama'];
    $jumlah = $_POST['jumlah'];
    $status = $_POST['status'];
    $tanggal = $_POST['tanggal'];

    $stmt = $conn->prepare("SELECT harga_barang FROM stok where id_barang = '$idbar'");
    $stmt->execute();
    $stmt->bind_result($harga);
    $stmt->fetch();
    $stmt->close();

    $total = intval($harga) * intval($jumlah);

    $date=date_create($tanggal);

    date_add($date,date_interval_create_from_date_string("30 days"));
    $jt = date_format($date,"Y-m-d");

    $denda = 0;

    $stmt = $conn->prepare("SELECT jumlah_barang FROM stok where id_barang = '$idbar'");
    $stmt->execute();
    $stmt->bind_result($barang);
    $stmt->fetch();
    $stmt->close();

    $stok = intval($barang) - intval($jumlah); 
    if($stok < 0 ){
        header("Location: ribet.php");
        exit();
    }

    $stmt = $conn->prepare("UPDATE stok SET jumlah_barang = ? where id_barang = ?");
    $stmt->bind_param("ss",$stok, $idbar);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO penjualan (id_penjualan, id_barang, nama_pemesan,jumlah_pesanan,total_penjualan,tanggal_pesan,status_pesanan,denda,total_bayar,jatuh_tempo) VALUES (?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssssss",$idpen,$idbar,$nama,$jumlah,$total,$tanggal,$status,$denda,$total,$jt);

    if($stmt->execute()){
        $_SESSION['massage'] = ['type'=> 'success', 'text'=>'Data departemen berhasil ditambah.'];
    }else{
        $_SESSION['massage'] = ['type'=> 'success', 'text'=>'Data departemen gagal ditambah.'];
    }
    $stmt->close();
    header("Location: ribet.php");
    exit();
}else{
    header("Location: ribet.php");
    exit();
}
?>