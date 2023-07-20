<?php
    session_start();
    if($_SESSION['loggedin'] != true){
        header("location:index.php");
    }
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin | Manage student</title>
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
                        <li><a href="#">Student \&nbsp;</a></li>
                        <li><a href="#">Manage Student</a></li>
                    </ul>
                </div>
            </div>
            <h2>Manage student</h2>
            <hr>
            <div class="row">
				<div class="col-md-12">
					<div class="table-wrap">
						<table class="table table-responsive-xl" id="myTable">
						    <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Photo</th>
                                    <th>Roll no.</th>
                                    <th>Name</th>
                                    <th>Class</th>
                                    <th>Register Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
						    </thead>
						    <tbody>
                                <?php
                                $sno=1;
                                include 'include/_db.php';
                                $sql="SELECT * FROM `student` INNER JOIN `class` ON class.ClassId = student.ClassId";
                                $result=mysqli_query($conn,$sql);
                                while($row = mysqli_fetch_array($result)){ ?>
                                    <tr>
                                        <td><?php echo $sno; ?></td>
                                        <td><img src="uploaded-image/<?php echo $row["Image"];?>" alt="Loading..." height="50px" width="50px"></td>
                                        <td><?php echo $row["RollNo"]; ?></td>
                                        <td><?php echo $row["StudentName"]; ?></td>
                                        <td><?php echo $row["ClassName"]; ?>&nbsp;-&nbsp;(<?php echo $row["Section"]; ?>)</td>
                                        <td><?php echo $row["RegDate"]; ?></td>
                                        <td>
                                            <?php                                              
                                                if($row["Status"] == 1){
                                                    echo "Active";
                                                }
                                                else{
                                                    echo "Blocked";
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <a style="color:green; font-size:20px;" href="student-edit.php?StudentId=<?php echo $row["StudentId"]; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
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