<?php



    
    


global $conn;


function insert($message_received,$jarak){

$host = "localhost"; 
$user = "root";
$pass = ""; 
$db = "xxxxxxxxxxxxxx";

$conn = mysqli_connect($host,$user,$pass,$db);


	$query = mysqli_query($conn,"INSERT INTO xxxxxx (data_sensor,jarak) VALUES ('".$message_received."','".$jarak."')");
	return $query;
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $message_received = $_POST["message_sent"];
        $jarak = $_POST["jarak"];
        echo "Welcome ESP32, the message you sent me is: " . $message_received;
        insert($message_received,$jarak);

    }else{
        
        die("tidak ada request post");
        
    }

?>