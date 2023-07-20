<?php
    session_start();
    if($_SESSION['loggedin'] != true){
        header("location:index.php");
    }
    else{
      include 'include/_db.php';
      if(isset($_GET['acid'])){
      $acid=$_GET['acid'];
      $Status=1;
      $sql="UPDATE `subject_combination` SET  `Status` = $Status WHERE `id` = '$acid'";
      $result=mysqli_query($conn,$sql);
      }

      // for Deactivate Subject
      if(isset($_GET['did']))
      {
      $did=$_GET['did'];
      $Status=0;
      $sql="UPDATE `subject_combination` SET  `Status` = $Status WHERE `id` = '$did'";
      $result=mysqli_query($conn,$sql);
      }
    }
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin | Manage subject of class</title>
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
                        <li><a href="#">Manage subject of class</a></li>
                    </ul>
                </div>
            </div>
            <h2>Manage Subject of class</h2>
            <hr>
            <div class="row">
				<div class="col-md-12">
					<div class="table-wrap">
						<table class="table table-responsive-xl" id="myTable">
						    <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Class and Section</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
						    </thead>
						    <tbody>
                                <?php
                                $sno=1;
                                $sql="SELECT * FROM `subject_combination` INNER JOIN `class` ON class.ClassId = subject_combination.ClassId INNER JOIN `subject` ON `subject`.`SubjectId` = `subject_combination`.`SubjectId`";
                                $result=mysqli_query($conn,$sql);
                                while($row=mysqli_fetch_assoc($result)){ ?>
                                    <tr>
                                        <td><?php echo $sno; ?></td>
                                        <td><?php echo $row["ClassName"]; ?>&nbsp;Section-<?php echo $row["Section"]; ?></td>
                                        <td><?php echo $row["SubjectName"]; ?></td>
                                        <td>
                                            <?php $Status = $row["Status"]; 
                                            if($Status=='0'){
                                                echo htmlentities('Inactive');
                                            }
                                            else{
                                                echo htmlentities('Active');
                                            }?>
                                        </td>
                                        <td>
                                            <?php 
                                            if($Status=='0'){ ?>
                                                <a href="sc-manage.php?acid=<?php echo $row["id"] ;?>" onclick="confirm('do you really want to ativate this subject');"><i class="fa fa-check" title="Acticvate Record"></i> </a>                                              
                                            <?php } 
                                            
                                            else {?>
                                                <a href="sc-manage.php?did=<?php echo $row["id"] ;?>" onclick="confirm('do you really want to deativate this subject');"><i class="fa fa-times" title="Deactivate Record"></i> </a>
                                            <?php }?>
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