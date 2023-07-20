<?php

    if($StudentName == ""){
        $input_name_error = "* Student name required.";            
        $is_error = true;
    }

    if($RollNo == ""){
        $input_rollno_error = "* Enter roll number.";            
        $is_error = true;
    }

    if($StudentMobile == ""){
        $input_mobile_error = "* Mobile number required.";            
        $is_error = true;
    }

    if($StudentEmail == ""){
        $input_email_error = "* Student email required.";            
        $is_error = true;
    }elseif (!filter_var($StudentEmail, FILTER_VALIDATE_EMAIL)) {
        $input_email_error = "* Please provide valid email format";        
        $is_error = true;
    }

    if($DOB == ""){
        $input_dob_error = "* Student DOB required";            
        $is_error = true;
    }

?>