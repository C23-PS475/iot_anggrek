<?php 

$konek = mysqli_connect("localhost", "root", "", "iot_anggrek");
$sql = mysqli_query($konek, "SELECT * FROM sensor ORDER BY id DESC LIMIT 1");
$data = mysqli_fetch_array($sql);
$kelembapan = $data["kelembapan"];
$suhu = $data["suhu"];



echo '<span id="kelembapan">' . $kelembapan . '</span>';
echo '<span id="suhu">' . $suhu . '</span>';
?>
