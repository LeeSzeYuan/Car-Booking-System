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

    include_once("back/createpro.php");
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
        <h3 class="text-dark mb-4">BRAND FORM<</h3>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text m-0 font-weight-bold">Brand</p>
            </div>
            <div class="card-body">
                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">

                    <form action="create.php" method="POST">
                        <div class="form-group">
                            <label for="brand" class="visually"><strong>Brand Name</strong></label>
                            <input type="text" class="form-control <?php echo (!empty($brand_err)) ? 'is-invalid' : ''; ?>" id="brand" name="brand" placeholder="name of the brand">
                            <span class="help-block"><?php echo $brand_err; ?></span>
                        </div>
                        <button type="submit" class="btn btn-success mb-3">Add!</button>
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