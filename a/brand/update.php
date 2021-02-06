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

    $sql = "SELECT * FROM tb_brand WHERE b_id = ?;";

    if (isset($_GET["id"])){
        $id = $_GET["id"];

        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            $sql_err = "SQL Error";
        }else{
            mysqli_stmt_bind_param($stmt, "i", $id);

            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_array($result);
        }
    }

    include_once("back/updatepro.php");
    include_once("../navbar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brand</title>
</head>
<body>
    <div class="container-fluid">
        <h3 class="text-dark mb-4">UPDATE FORM</h3>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">Vehicle Brand Info</p>
            </div>
            <div class="card-body">
                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                    <form action="update.php" method="POST">
                        <div class="form-group">
                            <label for="brand" class="visually"><strong>Brand Name</strong></label>
                            <input type="text" class="form-control <?php echo (!empty($brand_err)) ? 'is-invalid' : ''; ?>" id="brand" name="brand" placeholder="name of the brand" value="<?php echo $row["b_name"]; ?>">
                            <span class="help-block"><?php echo $brand_err; ?></span>

                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                        </div>

                        <button type="submit" class="btn btn-success mb-3" onclick = "return confirm('Do you want to save the changes?')">Update</button>
                        <a href="read.php" class="btn btn-primary mb-3">Cancel</a>
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