<?php

$konek = mysqli_connect("localhost", "root", "", "iot_anggrek");

$sql_ID = mysqli_query($konek, "SELECT MAX(ID) FROM sensor");

$data_ID = mysqli_fetch_array($sql_ID);

$ID_akhir = $data_ID['MAX(ID)'];
$ID_awal =  $ID_akhir - 6 ;

$tanggal = mysqli_query($konek, "SELECT DATE_FORMAT(tanggal, '%H:%i:%s') AS waktu from sensor WHERE ID>='$ID_awal' and ID<='$ID_akhir' ORDER BY ID ASC");

$supply = mysqli_query($konek, "SELECT kelembapan from sensor WHERE ID>='$ID_awal' and ID<='$ID_akhir' ORDER BY ID ASC");


?>

<div class="card-body">
    <canvas id="mychart1"></canvas>
    <script type="text/javascript">
        var canvas1 = document.getElementById('mychart1');
        var data1 = {
            labels : [
                <?php
                    while($data_tanggal = mysqli_fetch_array($tanggal))   
                    {
                        echo '"'.$data_tanggal['waktu'].'",';
                    }             
                ?>
            ],
            datasets : [
                {
                label : "Kelembapan", 
                fill : true,
                backgroundColor : "rgba(52, 231, 43, 0.2)",
                borderColor : "rgba(52, 231, 43, 1)",
                lineTension : 0.5,
                pointRadius : 5,
                data : [
                    <?php
                        while($data_supply = mysqli_fetch_array($supply))
                        {
                            echo $data_supply['kelembapan'].',' ;
                        }
                    ?>
                ]
            }
        ] 

        } ;

        var options1 = {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Waktu' // Label untuk sumbu x
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Nilai' // Label untuk sumbu y
                    }
                }
            },
            showLines: true,
            animation: { duration: 5 }
        };

        var myLineChart1 = new Chart(canvas1, {
            type: 'line',
            data: data1,
            options: options1
        });
    </script>
</div>