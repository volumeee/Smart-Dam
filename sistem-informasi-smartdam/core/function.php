<?php 


function select_data(){
$host = "localhost";
$user = "root";
$pass = "";
$db = "bendungan";

$link = mysqli_connect($host,$user,$pass,$db);


$query = "SELECT * FROM tabel1 ORDER BY id_data DESC";
return mysqli_query($link,$query);

}

function ketinggian_update(){
$host = "localhost";
$user = "root";
$pass = "";
$db = "bendungan";

$link = mysqli_connect($host,$user,$pass,$db);

$query = "SELECT * FROM tabel1 ORDER BY id_data DESC LIMIT 1";
return mysqli_query($link,$query);



}


function count_data(){
		$host = "localhost";
	$user = "root";
	$pass = "";
	$db = "bendungan";

	$link = mysqli_connect($host,$user,$pass,$db);

	$query = "SELECT count(id_data) as counts FROM tabel1";
	return mysqli_query($link,$query);

	}





 ?>