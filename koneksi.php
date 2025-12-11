<?php 
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "kisi_uas";

    $conn = new mysqli($server, $username, $password, $database);

    if($conn->connect_error) {
        die("Koneksi Error");
    }
?>