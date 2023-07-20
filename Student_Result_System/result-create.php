<?php
  session_start();
  $success="";
  $unsuccess="";
  include 'include/_db.php';

  if($_SESSION['loggedin'] != true){
    header("location:index.php");
  }
  if(isset($_POST['submit'])){
    $marks = array();
    $class = $_POST['class'];
    $studentid = $_POST['studentid']; 
    $mark = $_POST['marks'];
    
    $sql = "SELECT `subject`.`SubjectName` , `subject`.`SubjectId` FROM `subject_combination` join  `subject` on  `subject`.`SubjectId` = `subject_combination`.`SubjectId` WHERE `subject_combination`.`ClassId` = $class order by `subject`.`SubjectName`";
    $result = mysqli_query($conn,$sql);
    $sid1 = array();
    while($row = mysqli_fetch_assoc($result)){
      array_push($sid1,$row['SubjectId']);
    } 
      
    for($i=0; $i<count($mark); $i++){
      $mar = $mark[$i];
      $sid = $sid1[$i];
      $sql = "INSERT INTO `result` (StudentId,ClassId,SubjectId,marks,PostingDate) VALUES($studentid, $class, $sid, $mar,current_timestamp())";
      $result = mysqli_query($conn,$sql);
      if(!$result){
        $unsuccess="Something went wrong.";
      }
      else{
        $success="Result info added successfully.";
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin | Declare result</title>
  <!-- head content  -->
  <?php include('include/_htmlHeadLink.php');?>
  <script>
    function getStudent(val) {
      $.ajax({
        type: "POST",
        url: "get_student.php",
        data:'classid='+val,
        success: function(data){
          $("#studentid").html(data);
        }
      });

      $.ajax({
        type: "POST",
        url: "get_student.php",
        data:'classid1='+val,
        success: function(data){
          $("#subject").html(data);
        }
      });
    }
  </script>
  
  <script>
    function getresult(val,clid){   
      var clid=$(".clid").val();
      var val=$(".stid").val();;
      var abh=clid+'$'+val;
      $.ajax({
        type: "POST",
        url: "get_student.php",
        data:'studclass='+abh,
        success: function(data){
          $("#reslt").html(data);     
        }
      });
    }
  </script>
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
            <li class="active">Creat Result</li>
          </ul>
        </div>
      </div>
      <h2>Declare Student Result</h2>
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
      <form method="post" action="result-create.php">
        <div class="form-group has-success">
          <label for="ClassName" class="control-label">Class</label>
          <div>
            <select name="class" class="form-control clid" id="classid" onChange="getStudent(this.value);" required="required">
              <option value="">-- Select Class --</option>
              <?php
                include 'include/_db.php';
                $sql="SELECT * FROM `class`";
                $result=mysqli_query($conn,$sql);
                while($row=mysqli_fetch_assoc($result)){ 
              ?>
              <option value="<?php echo $row["ClassId"]; ?>"><?php echo $row["ClassName"]; ?>&nbsp;Section-<?php echo $row["Section"]; ?></option>
              <?php } ?>  
            </select>
          </div>
        </div>
        <br>

        <div class="form-group has-success">
          <label for="StudentName" class="control-label">Student Name</label>
          <select name="studentid" class="form-control stid" id="studentid" required="required" onChange="getresult(this.value);">

          </select>
        </div>
        <br>

        <div class="form-group has-success">
          <div id="reslt">

          </div>
        </div>

        <div class="form-group has-success">
          <label for="subjects" class="control-label">Subjects</label>
          <div id="subject">
                              
          </div>
        </div>

        <div class="form-group has-success">
          <button type="submit" name="submit" id="submit" class="btn btn-success">Submit <span><i class="fa fa-check"></i></span></button>
        </div>
      </form>
    </div>
  </div>
  <!-- jQuery CDN - Slim version (=without AJAX) -->
  <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
  <!-- Popper.JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
  <!-- Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  <!-- jQuery Custom Scroller CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="include/_customjs.js"></script>
</body>
</html>