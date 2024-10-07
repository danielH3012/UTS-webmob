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
    $idpen = $departemen1["id_penjualan"];

    if($departemen1["status_pesanan"] == "belum" && $date1 <= $date){
        $idbarang = $departemen1["id_barang"];
        
        
        $stmt = $conn->prepare("SELECT harga_barang FROM stok where id_barang = '$idbarang'");
        $stmt->execute();
        $stmt->bind_result($barang);
        $stmt->fetch();
        $stmt->close();

        $difference =  date_diff($date, $date1);;
        $denda = intval($difference->days) * intval($barang)/100;

        $stmt = $conn->prepare("SELECT total_bayar FROM penjualan where id_penjualan = '$idpen'");
        $stmt->execute();
        $stmt->bind_result($total);
        $stmt->fetch();
        $stmt->close();

        $total = intval($denda) + intval($total);

        $stmt = $conn->prepare("UPDATE penjualan SET denda = ?, total_bayar= ? where id_penjualan = ?");
        $stmt->bind_param("sss",$denda,$total, $departemen1["id_penjualan"]);
        $stmt->execute();
        $stmt->close();


    }else{
        $stmt = $conn->prepare("SELECT denda , total_bayar FROM penjualan where id_penjualan = ?");
        $stmt->bind_param("i", $idpen);
        $stmt->execute();
        $stmt->bind_result($denda1,$total1);
        $stmt->fetch();
        $stmt->close();

        $total1 = intval($total1) - intval($denda1) ;

        $denda1 = 0;

        $stmt = $conn->prepare("UPDATE penjualan SET denda = ?, total_bayar = ? where id_penjualan = ?");
        $stmt->bind_param("iii",$denda1,$total1, $departemen1["id_penjualan"]);
        $stmt->execute();
        $stmt->close();
    }
}
    header("Location: penjualan.php");
?>