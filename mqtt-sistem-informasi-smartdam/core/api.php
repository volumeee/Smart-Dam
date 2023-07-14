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
        $get 	= mysqli_query($link,"SELECT * FROM (SELECT * FROM tabel1 ORDER BY id_data DESC LIMIT 5 ) AS sub ORDER BY id_data ASC");
			while($hasil = mysqli_fetch_assoc($get)){
				$keluar['label'][]	= date_format(date_create($hasil['tanggal']),"H:i:s");
				$keluar['value'][] = $hasil['jarak'];

			
			}

			echo json_encode($keluar);
		die();

    } 
}

 ?>