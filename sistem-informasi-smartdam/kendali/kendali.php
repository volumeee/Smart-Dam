<?php
//Pengecekan status LED pada file API
if(isset($_GET['light'])){
$light = $_GET['light'];
}else{
$light = "OFF";
}


//Perintah untuk mengubah status LED pada file API
if($light == "on") {
$file = fopen("light.json", "w") or die("can't open file");
fwrite($file, '{"light": "on"}');
fclose($file);
}
else if ($light == "off") {
$file = fopen("light.json", "w") or die("can't open file");
fwrite($file, '{"light": "off"}');
fclose($file);
}
$json = file_get_contents("light.json") or die("can't open file");
$json_light = json_decode($json, true);
?>

<html>
<head>
<!--Header Web -->
<title>Modul Web-IoT</title>

<script src="https://code.jquery.com/jquery-
2.1.4.min.js"></script>

<script
src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.
min.js"></script>
<link
href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstra
p.min.css" rel="stylesheet">

<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-
awesome/4.3.0/css/font-awesome.min.css">

<script src="light.js" type="text/javascript"></script>
</head>
<body>
<div class="content">
<div style="center">
<header>
<!--Penulisan Judul-->
<h1 align="center">LATIHAN</h1>
<h1 align="center">KENDALI IOT BERBASIS
WEB</h1>
<h1 align="center">FAKULTAS ILMU
KOMPUTER</h1>
<h1 align="center">UNIVERSITAS DUTA BANGSA
SURAKARTA</h1>
</header>
</div>
<div class="badan">
<div class="row" style="margin-top: 20px;">
<div class="col-md-8 col-md-offset-2">
<!--Pembuatan Button dan Pengiriman Status LED ke file API
-->
<a id="light_on" href="?light=on" class="btn btn-success
btn-block btn-lg">Turn On</a>
<br />

<a id="light_off" href="?light=off" class="led btn btn-
danger btn-block btn-lg">Turn Off</a>

<br />
<div class="light-status well" style="margin-top: 5px;
text-align:center">
<!--Pengecekan Status LED pada file API -->
<?php
if($light=="on") {



echo("LED Nyala");
}
else if ($light=="off") {
echo("LED Mati");
}
else {
echo ("Tidak ditemukan");
}
?>
</div>
<!--Setting tampilan lampu berdasarkan status LED di file
API -->
<div class="light-status well" style="margin-top: 5px;
text-align:center;">
<img id="light_img_on" src="on.png"
style="height:200px;">
<img id="light_img_off" src="off.png"
style="height:200px;">
</div>
<!--Footer Web -->
<div id="footer">
<h4 align="center">Copyright 2022 </br> </h4>
<h5 align="center">Modul Pemrograman WEB Internet of
Things </br>
Nurchim</h5>
</div>
</div>
</div>
</body>
</html>
