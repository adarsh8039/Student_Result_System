<?php
  session_start();
  if($_SESSION['loggedin'] != true){
    header("location:index.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin | Dashboard</title>
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
      <h2>Dashboard</h2>
      <hr>
      <div class="row row-cols-1 row-cols-md-2 g-4">
        <div class="col">
          <div class="card text-dark bg-info">
            <a id="dashboard-hover" href="student-manage.php">
              <i class="fa fa-users fa-5x" aria-hidden="true" style="color: steelblue; margin: 10px 20px"></i>
              <div class="card-body">
                <h5 class="card-title">Total students</h5>
                <?php 
                require_once 'include/_db.php';
                $sql = "SELECT `StudentId` from `student` ";
                $result = mysqli_query($conn, $sql);
                $num = mysqli_num_rows($result);
                ?>
              <p class="card-text text-dark"><?php echo htmlentities($num);?></p>
            </a>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card text-dark bg-warning">
            <a href="class-manage.php">
              <i class="fa fa-address-card fa-5x" aria-hidden="true" style="color: lightslategrey; margin: 10px 20px"></i>
              <div class="card-body">
                <h5 class="card-title">Total Class listed</h5>
                <?php 
                require_once 'include/_db.php';
                $sql = "SELECT `ClassId` from `class` ";
                $result = mysqli_query($conn, $sql);
                $num = mysqli_num_rows($result);
                ?>
              <p class="card-text text-dark"><?php echo htmlentities($num);?></p>
            </a>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card text-white bg-danger">
            <a href="subject-manage.php">
              <i class="fa fa-book fa-5x" aria-hidden="true" style="color: lightsteelblue; margin: 10px 20px"></i>
              <div class="card-body">
                <h5 class="card-title">Subject listed</h5>
                <?php 
                require_once 'include/_db.php';
                $sql = "SELECT `SubjectId` from `subject` ";
                $result = mysqli_query($conn, $sql);
                $num = mysqli_num_rows($result);
                ?>
              <p class="card-text text-white"><?php echo htmlentities($num);?></p>
            </a>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card text-white bg-success">
            <a href="result-manage.php">
              <i class="fa fa-file-code-o fa-5x" aria-hidden="true" style="color: lightgreen; margin: 10px 20px"></i>
              <div class="card-body">
                <h5 class="card-title">Result Declared</h5>
                <?php 
                require_once 'include/_db.php';
                $sql = "SELECT distinct `StudentId` from `result` ";
                $result = mysqli_query($conn, $sql);
                $num = mysqli_num_rows($result);
                ?>
              <p class="card-text text-white"><?php echo htmlentities($num);?></p>
            </a>
            </div>
          </div>
        </div>
      </div>
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
  <script>
    $(".bootstrap-growl").remove();
    $.bootstrapGrowl("Welcome to School Management System!",{
      type: 'success',
      // offset: {from: "top", amount:250},
      align: 'right',
      delay: 5000,
      width: 250,
      allow_dismiss: true,
      stackup_spacing: 10
    });
  </script>
</body>

</html>