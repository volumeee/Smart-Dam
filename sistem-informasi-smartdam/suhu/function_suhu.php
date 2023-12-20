<?php 


function select_data_suhu(){
$host = "localhost";
$user = "root";
$pass = "";
$db = "bendungan";

$link = mysqli_connect($host,$user,$pass,$db);


$query = "SELECT * FROM suhu ORDER BY id DESC";
return mysqli_query($link,$query);

}

function suhu_update(){
$host = "localhost";
$user = "root";
$pass = "";
$db = "bendungan";

$link = mysqli_connect($host,$user,$pass,$db);

$query = "SELECT * FROM suhu ORDER BY id DESC LIMIT 1";
return mysqli_query($link,$query);



}


function count_data(){
		$host = "localhost";
	$user = "root";
	$pass = "";
	$db = "bendungan";

	$link = mysqli_connect($host,$user,$pass,$db);

	$query = "SELECT count(id) as counts FROM suhu";
	return mysqli_query($link,$query);

	}





 ?>