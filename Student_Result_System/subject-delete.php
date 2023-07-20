<?php

    include("include/_db.php");
    $SubjectId=$_GET["id"];
    $sql="DELETE FROM `subject` WHERE `subject`.`id` = '$SubjectId'";
    $result=mysqli_query($conn,$sql);
    header("location: subject-manage.php");
?>