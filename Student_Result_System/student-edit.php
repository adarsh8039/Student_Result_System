<?php
  session_start();
  $is_error = false;
  $input_name_error="";
  $input_rollno_error="";
  $input_email_error="";
  $input_mobile_error="";
  $input_class_error="";
  $input_dob_error="";
  $input_image_error="";
  $success="";
  $unsuccess="";
  include 'include/_db.php';

  if($_SESSION['loggedin'] != true){
    header("location:index.php");
  }
  $StudentId = $_GET["StudentId"];
  if(isset($_POST['submit'])){

    require_once 'include/_function.php';
    $StudentId2 = $_POST["StudentId"];
    $StudentName = senitize_input( ucwords($_POST["StudentName"]) );
    $RollNo = senitize_input($_POST["RollNo"] );
    $StudentEmail = senitize_input($_POST["StudentEmail"] );
    $StudentMobile = senitize_input($_POST["StudentMobile"] );
    $Gender =  $_POST["Gender"] ;
    $DOB = $_POST["DOB"];
    $Status = $_POST["Status"];
    require_once 'include/_validation_student.php';

    if( $is_error == false ){
      $SelectSql="SELECT * FROM `student` WHERE RollNo ='$RollNo' AND StudentName ='strcasecmp($StudentName)'";
      $Selectresult = mysqli_query($conn, $SelectSql);
      $numExistRow = mysqli_num_rows($Selectresult);
      if($numExistRow > 0){
        $unsuccess="Student already exists.";
      }
      else{
        $sql="UPDATE `student` SET `StudentName` = '$StudentName', `RollNo` = '$RollNo', `StudentEmail`= '$StudentEmail', `StudentMobile` = '$StudentMobile', `Gender` = '$Gender', `DOB` = '$DOB', `Status` = '$Status', `UpdationDate` = current_timestamp() WHERE `student`.`StudentId` = '$StudentId2'";
        $result = mysqli_query($conn, $sql);
        if(!$result){
          $unsuccess="Something went wrong.";
        }
        else{
            $success="Student record updated successfully.";
            header("location: student-manage.php");
            exit;
        }
      }
    }
  }
  
  if(isset($_POST['UploadImage'])){
    if(!empty($_FILES["StudentImage"])){

      $file_name=$_FILES["StudentImage"]["name"];
      $file_size=$_FILES["StudentImage"]["size"];
      $file_tmp=$_FILES["StudentImage"]["tmp_name"];
      $file_type=$_FILES["StudentImage"]["type"];
      $StudentId = $_POST["StudentId"];
      $imageFileType = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));

      if($file_size > 1048576){
        $input_image_error="Sorry, file must be less than 1 mb.";
      }
      elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $input_image_error = "Sorry, only JPG, JPEG & PNG files are allowed.";
      }
      else{
        move_uploaded_file($file_tmp,"uploaded-image/".$file_name);
        $sql="UPDATE `student` SET `Image` = '$file_name' WHERE `student`.`StudentId` = '$StudentId'";
        $result=mysqli_query($conn,$sql);
        header("location: student-manage.php");
      }
    }
  }
  $query = "SELECT * FROM `student` INNER JOIN `class` ON class.ClassId = student.ClassId where `StudentId` = '$StudentId'";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_array($result);

?>
<!DOCTYPE html>
<html>

<head>
  <title>Admin | Edit student data</title>  
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
            <li><a href="#">Student \&nbsp;</a></li>
            <li><a href="student-edit.php">Manage Student \&nbsp;</a></li>
            <li><a href="#">Edit Student</a></li>
          </ul>
        </div>
      </div>
      <h2>Create Student Class</h2>
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
      <form method="post" action="Student-edit.php" enctype="multipart/form-data">
        <div class="form-group has-success">
          <input type="hidden" name="StudentId" class="form-control"  id="StudentId" value="<?php echo $row["StudentId"]; ?>">
        </div>

        <div class="form-group has-success">
          <label for="StudentName" class="control-label">Student Full Name</label>
          <input type="text" name="StudentName" class="form-control"  id="StudentName" placeholder="Enter Student name" value="<?php echo $row["StudentName"]; ?>">
          <label class="err-msg"><?php echo $input_name_error; ?></label>
        </div>

        <div class="form-group has-success">
          <label for="RollNo" class="control-label">Roll Number</label>
          <input type="number" name="RollNo" required="required" class="form-control" id="RollNo" placeholder="Enter roll number" value="<?php echo $row["RollNo"]; ?>">
          <label class="err-msg"><?php echo  $input_rollno_error; ?></label>
        </div>

        <div class="form-group has-success">
          <label for="StudentEmail" class="control-label">Email</label>
          <input type="email" name="StudentEmail" required="required" class="form-control" id="StudentEmail" placeholder="Enter email address" value="<?php echo $row["StudentEmail"]; ?>">
          <label class="err-msg"><?php echo  $input_email_error; ?></label>
        </div>

        <div class="form-group has-success">
          <label for="StudentMobile" class="control-label">Mobile Number</label>
          <input type="number" name="StudentMobile" required="required" class="form-control" id="StudentMobile" placeholder="Enter mobile number" value="<?php echo $row["StudentMobile"]; ?>">
          <label class="err-msg"><?php echo  $input_mobile_error; ?></label>
        </div>

        <div class="form-group has-success">
          <label for="Gender" class="control-label">Gender</label>
          <div>
            <?php  $gndr = $row["Gender"];
            if($gndr == "Male"){?>
              <label><input type="radio" name="Gender" value="Male" checked>Male</label> 
              <label><input type="radio" name="Gender" value="Female" >Female</label> 
              <label><input type="radio" name="Gender" value="Other" >Other</label>
            <?php }?>

            <?php  
            if($gndr == "Female"){?>
              <label><input type="radio" name="Gender" value="Male" >Male</label> 
              <label><input type="radio" name="Gender" value="Female" checked>Female</label> 
              <label><input type="radio" name="Gender" value="Other" >Other</label>
            <?php }?>

            <?php  
            if($gndr == "Other"){?>
              <label><input type="radio" name="Gender" value="Male" >Male</label> 
              <label><input type="radio" name="Gender" value="Female" >Female</label> 
              <label><input type="radio" name="Gender" value="Other" checked>Other</label>
            <?php }?>
          </div>
          <label class="err-msg"></label>
        </div>

        <div class="form-group has-success">
          <label for="StudentClass" class="control-label">Class</label>
          <div>
            <input type="text" name="StudentClass"class="form-control" value="<?php echo $row["ClassName"]; ?>&nbsp;-&nbsp;(<?php echo $row["Section"]; ?>)" id="StudentClass" readonly>
          </div>
          <label class="err-msg"></label>
        </div>

        <div class="form-group has-success">
          <label for="DOB" class="control-label">DOB</label>
          <input type="date" name="DOB" required="required" class="form-control" id="DOB" value="<?php echo $row["DOB"]; ?>">
          <label class="err-msg"><?php echo  $input_dob_error; ?></label>
        </div>

        <div class="form-group has-success">
          <label for="Status" class="control-label">Status</label>
          <div>
            <label><input type="radio" name="Status" value="1" <?php echo $row['Status']==1?"checked":''; ?>>Active</label>
            <label><input type="radio" name="Status" value="0" <?php echo $row['Status']==0?"checked":''; ?>>Block</label>
          </div>
          <label class="err-msg"></label>
        </div>
        <hr>
                        
        <div class="form-group has-success">
          <div><label for="" class="control-label">Current Image</label></div>
          <img src="uploaded-image/<?php echo $row["Image"]; ?>" alt="Loading..." height="10%" width="15%">  
          <div><label for="StudentImage" class="control-label">Choose new Image</label></div>
          <input type="file" name="StudentImage" class="form-control" id="StudentImage" required="required">
          <label class="err-msg"><?php echo  $input_image_error; ?></label>
        </div>

        <div class="form-group has-success">
          <button type="submit" name="UploadImage" class="btn btn-success">Upload Image <span><i class="fa fa-check"></i></span></button>
        </div>
        <hr>

        <div class="form-group has-success">
          <button type="submit" name="submit" class="btn btn-warning">Update <span><i class="fa fa-check"></i></span></button>
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