<?php

    $name = "";
    $name_err = "";
    $user = "";
    $user_err = "";
    $cont = "";
    $cont_err = "";
    $mail = "";
    $mail_err = "";
    $addr = "";
    $addr_err = "";

    $errMSG = "";

    $sql_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        if (empty(trim(($_POST["name"])))){
            $name_err = "Please enter the real name of the user";
        }else{
            $name = mysqli_real_escape_string($conn, $_POST["name"]);
        }

        if (empty(trim(($_POST["user"])))){
            $user_err = "Please choose the nick name of the user";
        }else{
            $user = mysqli_real_escape_string($conn, $_POST["user"]);
        }

        if (empty(trim(($_POST["cont"])))){
            $cont_err = "Please enter the contact number";
        }else{
            $cont = mysqli_real_escape_string($conn, $_POST["cont"]);
        }

        if (empty(trim(($_POST["mail"])))){
            $mail_err = "Please enter the email address";

        }elseif (!filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL))  {
            $mail_err = 'Invalid email format';
        }else{
            $mail = mysqli_real_escape_string($conn, $_POST["mail"]);
        }

        if (empty(trim(($_POST["addr"])))){
            $addr_err = "Please enter the mailing address";
        }else{
            $addr = mysqli_real_escape_string($conn, $_POST["addr"]);
        }

        if (empty($user_err)&&empty($name_err)&&empty($cont_err)&&empty($mail_err)&&empty($addr_err)){


            $user_id = $_POST["user_id"];

            $sql = "UPDATE tb_user SET name = ?, username = ?, contact_num = ?, email = ?, address = ? WHERE user_id = '".$user_id."';";

            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)){
                $sql_err = "SQL Error";
            }else{
                mysqli_stmt_bind_param($stmt, "sssss", $name, $user, $cont, $mail, $addr);
                
                if (mysqli_stmt_execute($stmt)){

                    mysqli_stmt_close($stmt);
                    echo "<script>alert('The changes is saved');window.location.replace('read.php');</script>";
                }else{
                    $sql_err = mysqli_error($conn);
                }
            }
        }
    }

?>