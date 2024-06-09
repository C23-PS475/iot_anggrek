<?php

    $konek = mysqli_connect("localhost", "root", "", "iot_anggrek");

    $kelembapan = $_GET["kelembapan"];   
    $suhu = $_GET["suhu"];
    $relay = $_GET["relay"];


    mysqli_query($konek,"ALTER TABLE sensor AUTO_INCREMENT=1");
    mysqli_query($konek, "INSERT INTO sensor(kelembapan, suhu, relay_duration)VALUES('$kelembapan', '$suhu', '$relay')");
    

?>