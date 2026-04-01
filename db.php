<?php
    $server = "localhost";
    $user = "root";
    $pass = ""; //password 
    $dbname = "blogpostdb";

    $conn = new mysqli($server, $user, $pass, $dbname);
    if(!$conn)
    {
        echo "error!: {$conn->connection_error}";
    }
?>

