<?php
  session_start();
  $is_error = false;
  $input_error="";
  $input_numeric_error="";
  $input_section_error="";
  $success="";
  $unsuccess="";

  if($_SESSION['loggedin'] != true){
    header("location:index.php");
  }
  if(!empty($_POST)){

    require_once 'include/_function.php';

    $ClassName = senitize_input( ucfirst(strtolower($_POST["ClassName"])) );
    $ClassNameNumeric = senitize_input( $_POST["ClassNameNumeric"] ); 
    $Section = senitize_input( strtoupper($_POST["Section"] ));
    require_once 'include/_validation_class.php';

    require_once 'include/_db.php';
    if( $is_error == false ){
      $SelectSql="SELECT * FROM `class` WHERE `ClassName`='$ClassName' AND ClassNameNumeric='$ClassNameNumeric' AND Section='$Section'";
      $Selectresult = mysqli_query($conn, $SelectSql);
      $numExistRow = mysqli_num_rows($Selectresult);
      if($numExistRow > 0){
        $unsuccess="Class Already Exists.";
      }
      else{
        $sql = "INSERT INTO `class` (`ClassName`, `ClassNameNumeric`, `Section`, `CreationDate`, `UpdationDate`) VALUES ('$ClassName', '$ClassNameNumeric', '$Section', current_timestamp(), NULL)";
        $result = mysqli_query($conn, $sql);
        if(!$result){
          $unsuccess="Something went wrong.";
        }
        else{
          $success="New class inserted.";
        }
      }
    }
  }

?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin | Create class</title>
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
      <!-- <div class="header-back"> -->
        <div class="row">
          <div class="col-md-6">
            <ul class="breadcrumb">
              <li><a href="dashboard.php"><i class="fa fa-home"></i> Home \&nbsp;</a></li>
              <li><a href="#">Class \&nbsp;</a></li>
              <li class="active">Creat Class</li>
            </ul>
          </div>
        </div>
        <h2>Add New Class</h2>
        <hr>
      <!-- </div> -->
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
    
      <form method="post" action="class-create.php">
        <div class="form-group has-success">
          <label for="ClassName" class="control-label">Class Name</label>
          <input type="text" name="ClassName" class="form-control"  id="ClassName" placeholder="Eg- Third, Fourth, Sixth etc">
          <label class="err-msg"><?php echo $input_error; ?></label>
        </div>

        <div class="form-group has-success">
          <label for="ClassNameNumeric" class="control-label">Class Name in Numeric</label>
          <input type="number" name="ClassNameNumeric" required="required" class="form-control" id="ClassNameNumeric" placeholder="Eg- 1, 2, 4, 5 etc">
          <label class="err-msg"><?php echo  $input_numeric_error; ?></label>
        </div>

        <div class="form-group has-success">
          <label for="Section" class="control-label">Section</label>
          <input type="text" name="Section" class="form-control" required="required" id="Section" placeholder="Eg- A, B, C etc">
          <label class="err-msg"><?php echo $input_section_error; ?></label>
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