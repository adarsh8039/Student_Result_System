<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Your result</title>
  <link rel="stylesheet" href="include/_customcss.css">
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/ca8553cb9f.js" crossorigin="anonymous"></script>
  <script src="jquery/jquery.js"></script>
  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="include/_java-script.js"></script>

</head>

<body>
    <div class="main-wrapper">
        <div class="content-wrapper">
            <div class="content-container">
                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div style="margin-top: 10px;" class="col-md-12">
                                <h2 class="title" align="center">Result Management System</h2>
                            </div>
                        </div>    
                    </div>

                    <section style="background-color: #E0E0E0;" class="section" id="exampl">
                        <div class="container-fluid">
                            <div class="row">
                                <div style="background-color: white; border-radius:10px;  margin: 1% 20%; width: 60%;" class="">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div align="center" style="margin-top: 5px;"class="panel-title">
                                                <h3 align="center">Student Result Details</h3>
                                                <hr />
                                                <?php
                                                include 'include/_db.php';
                                                $rollno = $_POST['rollno'];
                                                $StudentClass = $_POST['StudentClass'];
                                                // $_SESSION['rollno']=$rollno;
                                                // $_SESSION['StudentClass']=$StudentClass;
                                                $sql = "SELECT student.StudentName, student.RollNo, student.RegDate, student.StudentId, student.Status, student.Image, class.ClassName, class.Section from student join class on class.ClassId = student.ClassId where student.RollNo = $rollno and student.ClassId = $StudentClass ";
                                                $result = mysqli_query($conn,$sql);
                                                $numExistRow1 = mysqli_num_rows($result);
                                                $cnt=1;
                                                if($numExistRow1 > 0){
                                                    while($row=mysqli_fetch_assoc($result)){ ?>          
                                                        <table style="width:70%;">
                                                            <tr>
                                                                <td><b>Student Name : </b></td>
                                                                <td><?php echo htmlentities($row["StudentName"]);?></td>
                                                                <td rowspan="3"><img src="uploaded-image/<?php echo $row["Image"];?>" alt="Loading..." height="150px" width="150px"></td>
                                                            </tr>

                                                            <tr>
                                                                <td><b>Student Roll Id : </b></td>
                                                                <td><?php echo htmlentities($row["RollNo"]);?></td>
                                                            </tr>

                                                            <tr>
                                                                <td><b>Student Class : </b></td>
                                                                <td><?php echo $row["ClassName"]; ?>&nbsp;Section-<?php echo $row["Section"]; ?></td>
                                                            </tr>
                                                        </table>
                                                    <?php } ?>                
                                            </div>
                                            <br>
                                            <div class="panel-body p-20">
                                                <table class="table table-hover table-bordered" border="1" width="100%">
                                                    <thead>
                                                        <tr style="text-align: center">
                                                            <th style="text-align: center">#</th>
                                                            <th style="text-align: center"> Subject</th>    
                                                            <th style="text-align: center">Marks</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php                                              
                                                        $sql ="SELECT t.StudentName, t.RollNo, t.ClassId, t.marks, t.SubjectId, `subject`.`SubjectName` FROM (SELECT sts.StudentName, sts.RollNo, sts.ClassId, tr.marks, SubjectId FROM student AS sts JOIN  result AS tr ON tr.StudentId = sts.StudentId) AS t JOIN `subject` ON `subject`.`SubjectId` = t.SubjectId WHERE (t.RollNo = $rollno AND t.ClassId = $StudentClass)";
                                                        $result = mysqli_query($conn,$sql);
                                                        $numExistRow2 = mysqli_num_rows($result);
                                                        $cnt=1;
                                                        $totlcount=0;
                                                        if($numExistRow2 > 0){
                                                            while($row=mysqli_fetch_assoc($result)){ ?>
                                                                <tr>
                                                                    <th scope="row" style="text-align: center"><?php echo htmlentities($cnt);?></th>
                                                                    <td style="text-align: center"><?php echo htmlentities($row["SubjectName"]);?></td>
                                                                    <td style="text-align: center"><?php echo htmlentities($totalmarks = $row["marks"]);?></td>
                                                                </tr>
                                                                <?php 
                                                                $totlcount += $totalmarks;
                                                            $cnt++;}
                                                            ?>
                                                                <tr>
                                                                    <th scope="row" colspan="2" style="text-align: center">Total Marks</th>
                                                                    <td style="text-align: center"><b><?php echo htmlentities($totlcount); ?></b> out of <b><?php echo htmlentities($outof=($cnt-1)*100); ?></b></td>
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row" colspan="2" style="text-align: center">Percntage</th>           
                                                                    <td style="text-align: center"><b><?php echo  htmlentities($totlcount*(100)/$outof); ?> %</b></td>
                                                                </tr>

                                                                <tr>                            
                                                                    <td colspan="3" align="center"><i class="fa fa-print fa-2x" aria-hidden="true" style="cursor:pointer" OnClick="CallPrint(this.value)" ></i></td>
                                                                </tr>
                                                                                        
                                                                <?php } 
                                                                else { ?>        
                                                                    <div class="alert alert-warning left-icon-alert" role="alert">
                                                                    <strong>Notice!</strong> Your result not declare yet 
                                                                <?php } ?>
                                                                </div>

                                                                <?php 
                                                                }
                                                                else{?>
                                                                    <div class="alert alert-danger left-icon-alert" role="alert">
                                                                    <strong>Oh snap!</strong>
                                                                    <?php
                                                                        echo htmlentities("Invalid Roll Id");
                                                                }   ?>
                                                            </div>
                                                    </tbody>
                                                    </table>
                                                        </div>
                                            </div>
                                         </div>
                                         <div class="form-group">
                                            <div class="col-sm-6">
                                            <a href="result-find.php">Back to Home</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function($) {
            
        });

        function CallPrint(strid) {
            var prtContent = document.getElementById("exampl");
            var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
            WinPrint.document.write(prtContent.innerHTML);
            WinPrint.document.close();
            WinPrint.focus();
            WinPrint.print();
            WinPrint.close();
        }
    </script>
</body>
</html>
