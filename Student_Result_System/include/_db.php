<?php
    $servername="localhost";
    $username="root";
    $password="";
    $database="sem6";

    $conn=mysqli_connect($servername,$username,$password,$database);
    if(!$conn){
        echo "Database doesn't connect";
    }
?>