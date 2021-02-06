<?php

    $id = "";

    $nameErr="";
    $icErr="";
    $contErr="";
    $mailErr="";
    $userErr="";
    $addrErr="";

    $name="";
    $ic="";
    $cont="";
    $mail="";
    $user="";
    $addr="";


    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {

        $id = $_POST["id"];

        if (empty(trim($_POST["name"]))) 
        {
            $nameErr = 'Name is required';
        } 
        elseif (!preg_match("/^[a-zA-Z-' ]*$/",$_POST["name"])) 
        {
            $nameErr = 'Only letters and white space allowed';
        }
        else
        {
            $name = trim($_POST["name"]);
        }

        if (empty(trim($_POST["username"]))) 
        {
            $userErr = 'Username is required';
        } 
        else
        {
            $user = trim($_POST["username"]);
        }


        if (empty(trim($_POST["ic"]))) 
        {
            $icErr = 'IC number is required';
        } 
        elseif (!preg_match("/^[0-9]{12}$/",$_POST["ic"])) 
        {
            $icErr = 'Please enter 12 digit without - ';
        }
        else
        {
            $ic = trim($_POST["ic"]);
        }


        if (empty(trim($_POST["address"]))) 
        {
            $addrErr = 'Address is required.';
        } 
        else
        {
            $addr = trim($_POST["address"]);
        }


        if (empty($_POST["contact"])) 
        {
            $contErr = 'Contact number is required.';
        } 
        elseif (!preg_match("/^[0-9]{10,11}$/",$_POST["contact"])) 
        {
            $contErr = 'Please enter correct format in digit. For example 01XXXXXXXX';
        }
        else
        {
            $cont = trim($_POST["contact"]);
        }


        if (empty(trim($_POST["email"]))) 
        {
            $mailErr = 'Email is required';
        } 
        elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) 
        {
            $mailErr = 'Invalid email format';
        }
        else
        {
            $mail = trim($_POST["email"]);
        }


        if(empty($nameErr)&&empty($icErr)&&empty($contErr)&&empty($mailErr)&&empty($userErr)&&empty($addrErr))
        {

            $sql = "UPDATE tb_user SET user_id = ?, username = ?, name = ?, contact_num = ?, email = ?, address = ? WHERE user_id = $id;";

            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)){
                $sql_err = "SQL Error";
                echo $sql_err;
            }else{
                mysqli_stmt_bind_param($stmt, "ssssss", $ic, $user, $name, $cont, $mail, $addr);
    
                if (mysqli_stmt_execute($stmt)){
                    mysqli_stmt_close($stmt);
                    echo "<script>alert('The changes is saved');window.location.replace('../main.php');</script>";
                }else{
                    $sql_err = mysqli_error($conn);
                    echo $sql_err;
                }
            
            }
        }
    }

?>