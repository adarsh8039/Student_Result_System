<?php
  include 'include/_db.php';
  if(!empty($_POST["classid"])){

    $cid=intval($_POST['classid']);
    $sql = "SELECT StudentName,StudentId FROM student WHERE ClassId = $cid  order by StudentName";
    $result = mysqli_query($conn,$sql)
    ?><option value="">--Select Student --  </option><?php
    while($row=mysqli_fetch_assoc($result)){ ?>
      <option value="<?php echo htmlentities($row['StudentId']); ?>"><?php echo htmlentities($row['StudentName']); ?></option>
      <?php
    }
  }

  // Code for Subjects
  if(!empty($_POST["classid1"])) {
    $cid1= $_POST['classid1'];
    $status=0;	
    $sql = "SELECT `subject`.`SubjectName` , `subject`.`SubjectId` FROM `subject_combination` join  `subject` on  `subject`.`SubjectId` = `subject_combination`.`SubjectId` WHERE `subject_combination`.`ClassId` = $cid1 and `subject_combination`.`Status` != '0' order by `subject`.`SubjectName`";
    $result = mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result)){ ?>
      <p> <?php echo htmlentities($row['SubjectName']); ?><input type="text"  name="marks[]" value="" class="form-control" required="" placeholder="Enter marks out of 100" autocomplete="off"></p>
      <?php  
    }
  }
  ?>

  <?php

  if(!empty($_POST["studclass"])){
    $id= $_POST['studclass'];
    $dta=explode("$",$id);
    $id=$dta[0];
    $id1=$dta[1];
    $sql = "SELECT StudentId,ClassId FROM result WHERE StudentId = $id1 and ClassId = $id ";
    $result = mysqli_query($conn,$sql);
    $numExistRow = mysqli_num_rows($result);
    $cnt=1;
    if($numExistRow > 0){ ?>
      <p>
        <?php
          echo "<span style='color:red'> Result Already Declare .</span>";
          echo "<script>$('#submit').prop('disabled',true);</script>";
        ?>
      </p>
      <?php
    }
  }
?>
