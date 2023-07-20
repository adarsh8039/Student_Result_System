<?php
  session_start();
  $is_error = false;
  $input_SubjectName_error="";
  $input_SubjectCode_error="";
  $success="";
  $unsuccess="";
  include 'include/_db.php';

  if($_SESSION['loggedin'] != true){
    header("location:index.php");
  }
  if(!empty($_POST)){

    require_once 'include/_function.php';

    $SubjectId=$_POST["id"];
    $SubjectName = senitize_input( ucfirst(strtolower($_POST["SubjectName"])) );
    $SubjectCode = senitize_input( $_POST["SubjectCode"] );

    require_once 'include/_validation_subject.php';

    if( $is_error == false ){
      $SelectSql="SELECT * FROM `subject` WHERE `SubjectName`='$SubjectName' AND `SubjectCode` ='$SubjectCode'";
      $Selectresult = mysqli_query($conn, $SelectSql);
      $numExistRow = mysqli_num_rows($Selectresult);
      if($numExistRow > 0){
        $unsuccess="Subject Already Exists.";
      }
      else{
        $sql = "UPDATE `subject` SET `SubjectName` = '$SubjectName', `SubjectCode` = '$SubjectCode', `UpdationDate` = CURRENT_TIME() WHERE `subject`.`id` = '$SubjectId'";
        $result = mysqli_query($conn, $sql);
        if(!$result){
          $unsuccess="Something went wrong.";
        }
        else{
          $success="Subject updated successfully.";
          header("location: subject-manage.php");
        }
      }
    }
  }
  $id = $_GET['id'];
  $query = "SELECT * FROM `subject` where `subject`.`SubjectId` = '$id'";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html>

<head>
  <title>Admin | Subject edit</title>
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
            <li><a href="#">Subject \&nbsp;</a></li>
            <li><a href="subject-manage.php">Manage Subject \&nbsp;</a></li>
            <li><a href="#">Edit Subject</a></li>
          </ul>
        </div>
      </div>
      <h2>Edit subject</h2>
      <hr>
      <?php
        if($success){
          echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>$success
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        }
        if($unsuccess){
          echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>$unsuccess
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        }
      ?>
      <form method="post" action="subject-edit.php">

        <input type="hidden" name="id" value="<?php echo $row['id']; ?>" >

        <div class="form-group has-success">
          <label for="SubjectName" class="control-label">Subject Name</label>
          <input type="text" name="SubjectName" class="form-control"  value="<?php echo $row['SubjectName']; ?>" id="SubjectName" placeholder="Enter subject name">
          <label class="err-msg"><?php echo $input_SubjectName_error; ?></label>
        </div>

        <div class="form-group has-success">
          <label for="SubjectCode" class="control-label">Subject Code</label>
          <input type="number" name="SubjectCode" required="required" class="form-control" value="<?php echo $row['SubjectCode']; ?>" id="SubjectCode" placeholder="Enter subject code">
          <label class="err-msg"><?php echo  $input_SubjectCode_error; ?></label>
        </div>

        <div class="form-group has-success">
          <button type="submit" name="submit" class="btn btn-success">Submit <span><i class="fa fa-check"></i></span></button>
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