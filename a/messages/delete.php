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
    

    if (isset($_GET["id"])){

        $id = mysqli_real_escape_string($conn, $_GET["id"]);

        $sql = "DELETE FROM contact WHERE id=?;";

        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            $sql_err = "SQL Error";
            echo $sql_err;
        }else{
            mysqli_stmt_bind_param($stmt, 'i', $id);
            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_close($stmt);
                header("location: read.php");
            }else{
                $sql_err = mysqli_error($conn);
                echo $sql_err;
            }
        }


    }

?>