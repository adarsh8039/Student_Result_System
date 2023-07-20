<?php
    include("include/_db.php");
    $ClassId=$_GET["ClassId"];
    $sql="DELETE FROM `class` WHERE `class`.`ClassId` = '$ClassId'";
    $result=mysqli_query($conn,$sql);
    header("location: class-manage.php");
    exit;
?>