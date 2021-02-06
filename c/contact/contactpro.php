<?php

    $name="";
    $mail="";
    $mesg="";

    date_default_timezone_set("Asia/Kuala_Lumpur");
    $date = date('Y-m-d h:i:s', time());


    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {   
        $name = $_POST["name"];
        $mail = $_POST["email"];
        $mesg = $_POST["question"];

        $sql = "INSERT INTO contact(name, email, message, time) VALUES(?,?,?,?);";

        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            $sql_err = "SQL Error";
            echo $sql_err;
        }else{
            mysqli_stmt_bind_param($stmt, "ssss", $name, $mail, $mesg, $date);

            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_close($stmt);
                echo "<script>alert('Your message is sent');window.location.replace('main.php');</script>";
            }else{
                $sql_err = mysqli_error($conn);
                echo $sql_err;
            }
        
        }
        
    }

?>