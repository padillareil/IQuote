<?php

    $servername = "192.168.101.68";
    $database = "VIAC_PROD_NEW";
    $username = "sa";
    $password = "SB1Admin";

    try {
        $conn = new PDO("sqlsrv:server=$servername;database=$database;TrustServerCertificate=true", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }


?> 