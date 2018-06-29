<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "kategorie_baum";

 $conn = mysqli_connect($servername, $username, $password, $dbname);

 if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
 }
 else{
 	// echo 'connection successfull';
 }

// $query = "SELECT * FROM kat_index WHERE VS4_KAT_ID = 000001";

// $result = mysqli_query($conn, $query);

// $row = mysqli_fetch_assoc($result);

// print_r($row);




?>