<?php

    $currErr="";
    $passErr="";

    $curr = "";
    $pass="";


    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {

        if(empty(trim($_POST["current"])))
        {
            $currErr = 'Current pasword is required';   
        } 
        elseif(strlen(trim($_POST["current"])) < 4)
        {
            $currErr = 'Password must have at least 4 characters';
        } 
        else
        {
            $curr = trim($_POST["current"]);
        }
  

        if(empty(trim($_POST["password"])))
        {
            $passErr = 'Pasword is required.';     
        } 
        elseif(strlen(trim($_POST["password"])) < 4)
        {
            $passErr = 'Password must have at least 4 characters.';
        } 
        elseif($_POST["password"]!=$_POST["confirm_password"])
        {
            $passErr = 'Password is not matching with the left field.';
        }
        else
        {
            $pass = trim($_POST["password"]);
        }

        if (!password_verify($pass, $row['password'])) 
        {
            echo '<script>alert("Current password incorrect. Try again.");</script>';
        }


        if(empty($passErr)&&empty($currErr)&&password_verify($pass, $row['password']))
        {

            $id = $_POST["id"];

            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);


            $sql = "UPDATE tb_user SET password = ?;";

            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)){
                $sql_err = "SQL Error";
                echo $sql_err;
            }else{
                mysqli_stmt_bind_param($stmt, "s", $hashed_password);
    
                if (mysqli_stmt_execute($stmt)){
                    mysqli_stmt_close($stmt);
                    echo "<script>alert('Your password is updated');window.location.replace('../../login.php');</script>";
                }else{
                    $sql_err = mysqli_error($conn);
                    echo $sql_err;
                }
            
            }
        }else{
            echo '<script>alert("Error occurs. Try again.")</script>';
        }
    }

?>