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
  <title>Admin | Subject manage</title>
  <!-- head content  -->
  <?php include('include/_htmlHeadLink.php');?>
  <style>
    @media (max-width: 1199.98px) {
      .table-responsive-xl {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch; 
      }

      .table-responsive-xl > .table-bordered {
        border: 0; 
      } 
    }

    .table-wrap {
      overflow-x: scroll; 
    }
  </style>
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
            <li><a href="#">Manage Subject</a></li>
          </ul>
        </div>
      </div>
      <h2>Manage  Subject</h2>
      <hr>
      <div class="row">
				<div class="col-md-12">
					<div class="table-wrap">
					  <table class="table table-responsive-xl" id="myTable">
						  <thead>
						    <tr>
                  <th>#</th>
                  <th>Subject Name</th>
                  <th>Subject Code</th>
                  <th>Creation Date</th>
                  <th>Updation Date</th>
                  <th>Action</th>
						    </tr>
						  </thead>
						  <tbody>
                <?php
                  $sno=1;
                  include 'include/_db.php';
                  $sql="SELECT * FROM `subject`";
                  $result=mysqli_query($conn,$sql);
                  while($row=mysqli_fetch_assoc($result)){ ?>
                    <tr>
                      <td><?php echo $sno; ?></td>
                      <td><?php echo $row["SubjectName"]; ?></td>
                      <td><?php echo $row["SubjectCode"]; ?></td>
                      <td><?php echo $row["CreationDate"]; ?></td>
                      <td><?php echo $row["UpdationDate"]; ?></td>
                      <td>
                        <a style="color:green; font-size:20px;" href="subject-edit.php?id=<?php echo $row['SubjectId'] ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <!-- <a style="color:red; font-size:20px;" href="subject-delete.php?id="><i class="fa fa-trash-o" aria-hidden="true"></i></a> -->
                      </td>
                    </tr>
                  <?php $sno = $sno+1;} ?>
						  </tbody>
						</table>
					</div>
				</div>
			</div>
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
  <!-- DataTable -->
  <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
  <script src="include/_customjs.js"></script>
  <script src="include/_dataTable.js"></script>
</body>
</html>