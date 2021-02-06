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

    $sql = "SELECT * FROM tb_user WHERE user_id = ?";

    $user_id = "";
    if (isset($_GET["id"])){
        $user_id = mysqli_real_escape_string($conn, $_GET["id"]);
    }else{
        exit();
    }
    
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        $sql_err = "SQL Error";
    }else{
        mysqli_stmt_bind_param($stmt, 'i', $user_id);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result);
    }

    include("back/updatepro.php");
    include_once("../navbar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User</title>
</head>
<body>
    <div class="container-fluid">
        <h3 class="text-dark mb-4">USER FORM</h3>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text m-0 font-weight-bold">User</p>
            </div>
            <div class="card-body">
                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">


                    <form action="update.php?id=<?php echo $user_id; ?>" enctype="multipart/form-data" method="POST">
                        <div class="form-group">
                            <label for="id" class="visually"><strong>User ID</strong></label>
                            <input type="text" class="form-control" id="id" name="id" placeholder="User IC Number" value="<?php echo $row["user_id"]; ?>" disabled>
                        </div>

                        <input type="hidden" name="user_id" value="<?php echo $row["user_id"]; ?>">

                        <div class="form-group">
                            <label for="name" class="visually"><strong>Name</strong></label>
                            <input type="text" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" id="name" name="name" placeholder="User Real Name" value="<?php echo $row["name"]; ?>">
                            <span class="help-block"><?php echo $name_err; ?></span>
                        </div>

                        <div class="form-group">
                            <label for="user" class="visually"><strong>User Name</strong></label>
                            <input type="text" class="form-control <?php echo (!empty($user_err)) ? 'is-invalid' : ''; ?>" id="user" name="user" placeholder="User Displayed Name" value="<?php echo $row["username"]; ?>">
                            <span class="help-block"><?php echo $user_err; ?></span>
                        </div>


                        <!-- <div class="row">
                        
                        </div> -->

                        <div class="form-group">
                            <label for="cont" class="visually"><strong>Contact Number</strong></label>
                            <input type="text" class="form-control <?php echo (!empty($cont_err)) ? 'is-invalid' : ''; ?>" id="cont" name="cont" placeholder="Contact Number without '-'" value="<?php echo $row["contact_num"]; ?>">
                            <span class="help-block"><?php echo $cont_err; ?></span>
                        </div>

                        <div class="form-group">
                            <label for="mail" class="visually"><strong>Email Address</strong></label>
                            <input type="text" class="form-control <?php echo (!empty($mail_err)) ? 'is-invalid' : ''; ?>" id="mail" name="mail" placeholder="Email Address" value="<?php echo $row["email"]; ?>">
                            <span class="help-block"><?php echo $mail_err; ?></span>
                        </div>

                        <div class="form-group">
                            <label for="addr" class="visually"><strong>Mailing Address</strong></label>
                            <input type="text" class="form-control <?php echo (!empty($addr_err)) ? 'is-invalid' : ''; ?>" id="addr" name="addr" placeholder="Mailing Address" value="<?php echo $row["address"]; ?>">
                            <span class="help-block"><?php echo $addr_err; ?></span>
                        </div>



                        <button type="submit" class="btn btn-success mb-3" onclick="return confirm('Do you want to save the changes');">Update</button>
                        <input type="reset" value="Reset" class="btn btn-warning mb-3">
                        <a href="read.php" class="btn btn-dark mb-3 float-right">Cancel</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
    include_once("../footer.php");

    if (!empty($sqlErr)){
?>
        <script>
            let error = "<?php echo $sqlErr; ?>";
            alert(error);
        </script>
<?php 
    }
    mysqli_close($conn);
?>