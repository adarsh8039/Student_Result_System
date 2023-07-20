<!DOCTYPE html>
<html lang="en">

<head>
  <title>Edit Result</title>  
  <!-- head content  -->
  <?php include('include/_htmlHeadLink.php');?>
</head>

<body>
    <section class="bg-dark vh-100 d-flex">
        <div class="col-3 m-auto">
            <div class="card">
                <div class="card-body">
                    <div class="border rounded-circle mx-auto d-flex" style="width:100px; height:100px;"><i class="fa fa-user fa-3x m-auto"></i></div>
                    <form action="result.php" method="post">
                        <div class="md-form">
                            <label for="rollno">Enter roll number</label>
                            <input type="number" name="rollno" id="rollno" class="form-control" required="required" autocomplete="off">
                        </div>
                        <br>

                        <div class="md-form">
                            <label for="StudentClass" class="control-label">Select your Class</label>
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
                        </div>
                        <br>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success">Search <span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
                        </div>
                        <br>
                        <div class="col-sm-6 has-success">
                            <a href="dashboard.php">Back to Home</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>