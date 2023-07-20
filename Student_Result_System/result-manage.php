<?php
    session_start();
    if($_SESSION['loggedin'] != true){
        header("location:index.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin | Manage Result</title>  
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
                    <li><a href="#">Result \&nbsp;</a></li>
                    <li class="active">Manage Result</li>
                </ul>
                </div>
            </div>
            <h2>Manage Result</h2>
            <hr>
            <div class="row">
			    <div class="col-md-12">
					<div class="table-wrap">
						<table class="table table-responsive-xl" id="myTable">
						    <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student Name</th>
                                    <th>Roll Id</th>
                                    <th>Class</th>
                                    <th>Posting Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
						    </thead>
						    <tbody>
                                <?php
                                $sno=1;
                                include 'include/_db.php';
                                $sql = "SELECT  distinct student.StudentName,student.RollNo,student.RegDate,student.StudentId,student.Status,class.ClassName,class.Section from result join student on student.StudentId = result.StudentId  join class on class.ClassId = result.ClassId";
                                $result=mysqli_query($conn,$sql);
                                while($row=mysqli_fetch_assoc($result)){ ?>
                                    <tr>
                                        <td><?php echo $sno; ?></td>
                                        <td><?php echo $row["StudentName"]; ?></td>
                                        <td><?php echo $row["RollNo"]; ?></td>
                                        <td><?php echo $row["ClassName"]; ?>&nbsp;Section-<?php echo $row["Section"]; ?></td>
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
                                            <a style="color:green; font-size:20px;" href="result-edit.php?StudentId=<?php echo $row['StudentId'] ?>"><i class="fa fa-pencil-square-o" aria-hidden="true" title="Edit Record"></i></a>
                                            <!-- <a style="color:red; font-size:20px;" href="class-delete.php?ClassId="><i class="fa fa-trash-o" aria-hidden="true"></i></a> -->
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

    <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="include/_customjs.js"></script>
    <script src="include/_dataTable.js"></script>
</body>
</html>