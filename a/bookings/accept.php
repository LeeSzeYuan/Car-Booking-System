<?php
    require_once("../../dbconfig.php");
    if(!session_id())//if session_id is not found
	{
		session_start();
	}
	
	if(isset($_SESSION['id']) != session_id() )
	{
		header("location: ../../login.php");
    }

    if ($_SESSION['usertype'] != 'A'){
        header("location: ../../login.php");
    }

    include("email.php");
    
    if (isset($_GET["id"])){

        $id = mysqli_real_escape_string($conn, $_GET["id"]);

        $sql = "UPDATE tb_booking SET b_status = 2 WHERE book_id= ? ;";

        $sqlu = "SELECT * FROM tb_booking JOIN tb_user ON tb_booking.user_id = tb_user.user_id WHERE book_id = $id;";
        $user = mysqli_query($conn, $sqlu);
        $user = mysqli_fetch_array($user);

        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            $sql_err = "SQL Error";
        }else{
            mysqli_stmt_bind_param($stmt, 's', $id);
            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_close($stmt);
                
                result($user["email"], $user["username"], 2);
                echo "<script>alert('This booking is approved');window.location.replace('read.php');</script>";
            }else{
                $sql_err = mysqli_error($conn);
            }
        }


    }

?>