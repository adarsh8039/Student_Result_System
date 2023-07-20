<?php
  session_start();
  $success="";
  $unsuccess="";
  include 'include/_db.php';

  if($_SESSION['loggedin'] != true){
    header("location:index.php");
  }

  if(isset($_POST['submit'])){
    require_once 'include/_function.php';
    $rowid = $_POST['id'];
    $marks = $_POST['marks'];

    foreach($_POST['id'] as $count => $id){
      $mrks=$marks[$count];
      $iid=$rowid[$count];
      for($i=0; $i<=$count; $i++) {      
        $sql = "UPDATE `result` SET `marks` = '$mrks' , `UpdationDate` = current_timestamp() WHERE `id` = '$iid'";
        $result = mysqli_query($conn, $sql);
        if(!$result){
          $unsuccess="Something went wrong.";
        }
        else{
          $success="Result record updated successfully.";
          header("location: result-manage.php");
          exit;
        }
      }
    }
  }
  $StudentId = $_GET["StudentId"];
  $query = "SELECT `student`.`StudentName` , `class`.`ClassName` , `class`.`Section` FROM `result` JOIN `student` ON `result`.`StudentId` = `result`.`StudentId` JOIN `subject` ON `subject`.`SubjectId` = `result`.`SubjectId` JOIN `class` ON `class`.`ClassId` = `student`.`ClassId` WHERE `student`.`StudentId` = '$StudentId' LIMIT 1";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin | Edit Student Result</title>
  <!-- head content  -->
  <?php include('include/_htmlHeadLink.php');?>
</head>
<body>
  <div class="wrapper">
    <!-- Sidebar  -->
    <?php include('include/_sidebar.php');?>
    <!-- Page Content  -->
    <div id="content">
      <!-- Topbar -->
      <?php include('include/_topbar.php');?>
      <div class="row">
        <div class="col-md-6">
          <ul class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home"></i> Home \&nbsp;</a></li>
            <li><a href="#">Result \&nbsp;</a></li>
            <li><a href="result-edit.php">Manage Result \&nbsp;</a></li>
            <li class="active">Edit Result</li>
          </ul>
        </div>
      </div>
      <h2>Edit Student Result</h2>
      <hr>
      <?php
        if($success){
          echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>$success
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        }
        if($unsuccess){
          echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>$unsuccess
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        }
      ?>
      <form method="post" action="result-edit.php">
        <div class="form-group has-success">
          <label for="ClassNameNumeric" class="col-sm-2 control-label">Full Name</label>
          <div div class="col-sm-10">
            <input type="text" class="form-control" value="<?php echo $row["StudentName"]; ?>" disabled  required="required" autocomplete="off">
          </div>
        </div>
        <br>

        <div class="form-group has-success">
          <label for="ClassName" class="col-sm-2 control-label">Class</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" value="<?php echo $row["ClassName"]; ?>&nbsp;Section-<?php echo $row["Section"]; ?>" disabled  required="required" autocomplete="off">
          </div>
        </div>
        <br>

        <?php 
          $sql = "SELECT distinct student.StudentName,student.StudentId,class.ClassName,class.Section,`subject`.`SubjectName`,result.marks,result.id as resultid from result join student on student.StudentId=result.StudentId join `subject` on `subject`.`SubjectId` = result.SubjectId join class on class.ClassId = student.ClassId where student.StudentId = $StudentId ";
          $result=mysqli_query($conn,$sql);
          while($row=mysqli_fetch_assoc($result)){ ?>

            <div class="form-group has-success">
              <label for="default" class="col-sm-2 control-label"><?php echo $row["SubjectName"]; ?></label>
              <div class="col-sm-10">
                <input type="hidden" name="id[]" value="<?php echo $row["resultid"]; ?>">
                <input type="text" name="marks[]" class="form-control" id="marks" value="<?php echo $row["marks"]; ?>" maxlength="5" required="required" autocomplete="off">
              </div>
              <br>
            </div>
        <?php } ?> 

        <div class="form-group has-success">
          <button type="submit" name="submit" class="btn btn-success">Update <span><i class="fa fa-check"></i></span></button>
        </div>
      </form>
    </div>
  </div>

  <!-- jQuery CDN - Slim version (=without AJAX) -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <!-- Popper.JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
  <!-- Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  <!-- jQuery Custom Scroller CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="include/_customjs.js"></script>
</body>
</html>