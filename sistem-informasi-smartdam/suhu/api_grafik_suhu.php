<?php 

if(isset($_GET['ambil'])) {

$host = "localhost";
$user = "root";
$pass = "";
$db = "bendungan";

$link = mysqli_connect($host,$user,$pass,$db);



    if($_GET['ambil'] == 'grafik1') {
        // do time stuff
        $keluar = array();
        $get 	= mysqli_query($link,"SELECT * FROM (SELECT * FROM suhu ORDER BY id DESC LIMIT 5 ) AS sub ORDER BY id ASC");
			while($hasil = mysqli_fetch_assoc($get)){
				$keluar['label'][]	= date_format(date_create($hasil['jam']),"H:i:s");
				$keluar['suhu'][] = $hasil['suhu'];
				$keluar['kelembaban'][] = $hasil['kelembaban'];

			
			}

			echo json_encode($keluar);
		die();

    } 
}

 ?>