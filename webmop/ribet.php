<?php
require 'config.php';
$barang = $conn->query("SELECT * FROM stok");

$barang1 = $conn->query("SELECT * FROM stok");

$result = $conn->query("SELECT * FROM penjualan");

$timezone = date_default_timezone_get();
date_default_timezone_set($timezone);
$date = date('Y-m-d');
$date = date_create($date);

while ($departemen1 = $result->fetch_assoc()) {
    $date1 = date_create($departemen1["jatuh_tempo"]);

    $barang;
    $difference;

    if($departemen1["status_pesanan"] == "belum" && $date1 <= $date){
        $idbarang = $departemen1["id_barang"];
        
        $stmt = $conn->prepare("SELECT harga_barang FROM stok where id_barang = '$idbarang'");
        $stmt->execute();
        $stmt->bind_result($barang);
        $stmt->fetch();
        $stmt->close();

        $difference =  date_diff($date, $date1);;
        $denda = intval($difference->days) * intval($barang)/100;

        $stmt = $conn->prepare("UPDATE penjualan SET denda = ? where id_penjualan = ?");
        $stmt->bind_param("ss",$denda, $departemen1["id_penjualan"]);
        $stmt->execute();
        $stmt->close();
    }else{
        $denda = 0;
        $stmt = $conn->prepare("UPDATE penjualan SET denda = ? where id_penjualan = ?");
        $stmt->bind_param("ss",$denda, $departemen1["id_penjualan"]);
        $stmt->execute();
        $stmt->close();
    }
}
    header("Location: penjualan.php");
?>