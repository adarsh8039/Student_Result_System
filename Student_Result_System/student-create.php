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

  if($_SESSION['loggedin'] != true){
    header("location:index.php");
  }
  if(!empty($_POST)){

    require_once 'include/_function.php';

    $StudentName = senitize_input( ucwords($_POST["StudentName"]) );
    $RollNo = senitize_input( $_POST["RollNo"] );
    $StudentEmail = senitize_input($_POST["StudentEmail"] );
    $StudentMobile = senitize_input( $_POST["StudentMobile"] );
    $Gender = senitize_input( $_POST["Gender"] );
    $StudentClass = senitize_input( $_POST["StudentClass"] );
    $DOB = senitize_input( $_POST["DOB"] );

    require_once 'include/_validation_student.php';
      
    require_once 'include/_db.php';
    if(isset($_FILES["StudentImage"])){

      $file_name=$_FILES["StudentImage"]["name"];
      $file_size=$_FILES["StudentImage"]["size"];
      $file_tmp=$_FILES["StudentImage"]["tmp_name"];
      $file_type=$_FILES["StudentImage"]["type"];
      $imageFileType = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));

      if($file_size > 1000000){
        $input_image_error="* File must be less than 1 mb.";
      }
      elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $input_image_error = "Sorry, only JPG, JPEG & PNG files are allowed.";
      }
      else{
        move_uploaded_file($file_tmp,"uploaded-image/".$file_name);
        if( $is_error == false ){
          $SelectSql="SELECT * FROM `student` WHERE `StudentName`='$StudentName' AND `RollNo`='$RollNo' AND `ClassId`='$StudentClass'";
          $Selectresult = mysqli_query($conn, $SelectSql);
          $numExistRow = mysqli_num_rows($Selectresult);
          if($numExistRow > 0){
            $unsuccess="Student already exists.";
          }
          else{
            $sql = "INSERT INTO `student` (`StudentName`, `RollNo`, `StudentEmail`, `StudentMobile`, `Gender`, `DOB`, `Image`, `ClassId`, `RegDate`, `UpdationDate`, `Status`) VALUES ('$StudentName','$RollNo', '$StudentEmail', '$StudentMobile', '$Gender', '$DOB', '$file_name', '$StudentClass', current_timestamp(), NULL, '1')";
            $result = mysqli_query($conn, $sql);
            if(!$result){
              $unsuccess="Something went wrong.";
            }
            else{
              $success="New student added.";
            }
          }
        }
      }
    }
  }

?>
<!DOCTYPE html>
<html>

<head>
  <title>Admin | Add student</title>  
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
            <li><a href="#">Add Student</a></li>
          </ul>
        </div>
      </div>
      <h2>Add new student</h2>
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

      <form method="post" action="Student-create.php" enctype="multipart/form-data">
        <div class="form-group has-success">
          <label for="StudentName" class="control-label">Student Full Name</label>
          <input type="text" name="StudentName" class="form-control"  id="StudentName" placeholder="Enter Student name">
          <label class="err-msg"><?php echo $input_name_error; ?></label>
        </div>

        <div class="form-group has-success">
          <label for="RollNo" class="control-label">Roll Number</label>
          <input type="number" name="RollNo" required="required" class="form-control" id="RollNo" placeholder="Enter roll number">
          <label class="err-msg"><?php echo  $input_rollno_error; ?></label>
        </div>

        <div class="form-group has-success">
          <label for="StudentEmail" class="control-label">Email</label>
          <input type="email" name="StudentEmail" required="required" class="form-control" id="StudentEmail" placeholder="Enter email address">
          <label class="err-msg"><?php echo  $input_email_error; ?></label>
        </div>

        <div class="form-group has-success">
          <label for="StudentMobile" class="control-label">Mobile Number</label>
          <input type="number" name="StudentMobile" required="required" class="form-control" id="StudentMobile" placeholder="Enter mobile number">
          <label class="err-msg"><?php echo  $input_mobile_error; ?></label>
        </div>

        <div class="form-group has-success">
          <label for="Gender" class="control-label">Gender</label>
          <div>
              <input type="radio" name="Gender" value="Male" required="required" checked="">Male 
              <input type="radio" name="Gender" value="Female" required="required">Female 
              <input type="radio" name="Gender" value="Other" required="required">Other
          </div>
		  <label class="err-msg"></label>
        </div>

        <div class="form-group has-success">
          <label for="StudentClass" class="control-label">Class</label>
            <div>
              <select name="StudentClass" class="form-control" id="StudentClass" required="required">
                <option value="">-- Select Class --</option>
                <?php
                include 'include/_db.php';
                $sql="SELECT * FROM `class`";
                $result=mysqli_query($conn,$sql);
                while($row=mysqli_fetch_assoc($result)){ ?>
                  <option value="<?php echo $row["ClassId"]; ?>"><?php echo $row["ClassName"]; ?>&nbsp;Section-<?php echo $row["Section"]; ?></option>
                <?php } ?>  
              </select>
                  <label class="err-msg"><?php echo  $input_class_error; ?></label>
            </div>
        </div>

        <div class="form-group has-success">
          <label for="DOB" class="control-label">DOB</label>
          <input type="date" name="DOB" required="required" class="form-control" id="DOB">
          <label class="err-msg"><?php echo  $input_dob_error; ?></label>
        </div>

        <div class="form-group has-success">
          <label for="StudentImage" class="control-label">Image</label>
          <input type="file" name="StudentImage" required="required" class="form-control" id="StudentImage">
          <label class="err-msg"><?php echo  $input_image_error; ?></label>
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