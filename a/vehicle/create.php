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

    $sql = "SELECT * FROM tb_brand;";


    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        $sql_err = "SQL Error";
    }else{
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

    }

    include_once("back/createpro.php");
    include_once("../navbar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <!-- <script src="https://cdn.ckeditor.com/ckeditor5/25.0.0/classic/ckeditor.js"></script> -->
    <script src="https://fred-wang.github.io/mathml.css/mspace.js"></script>

    <title>Vehicle</title>
</head>
<body>
    <div class="container-fluid">
        <h3 class="text-dark mb-4">VEHICLE FORM</h3>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text m-0 font-weight-bold">Vehicle</p>
            </div>
            <div class="card-body">
                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                    <img id="blah" src="#" alt="vehicle image" />


                    <form action="create.php" enctype="multipart/form-data" method="POST">
                        <div class="form-group">
                            <label for="id" class="visually"><strong>Vehicle ID</strong></label>
                            <input type="text" class="form-control <?php echo (!empty($id_err)) ? 'is-invalid' : ''; ?>" id="id" name="id" placeholder="Vehicle Plate Number without any Spacing">
                            <span class="help-block"><?php echo $id_err; ?></span>
                        </div>

                        <div class="form-group">
                            <label for="name" class="visually"><strong>Vehicle Name</strong></label>
                            <input type="text" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" id="name" name="name" placeholder="Vehicle Model Name">
                            <span class="help-block"><?php echo $name_err; ?></span>
                        </div>

                        <div class="form-group">
                            <label for="brand" class="visually"><strong>Brand</strong></label>
                            <select class="form-select  <?php echo (!empty($brand_err)) ? 'is-invalid' : ''; ?>" aria-label="Default select example" name="brand" id="brand">
                                <option selected value="">Open this select menu</option>
                                <?php
                                    while($row = mysqli_fetch_array($result)){
                                ?>
                                        <option value="<?php echo $row["b_id"]; ?>"><?php echo $row["b_name"]; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                            <span class="help-block"><?php echo $brand_err; ?></span>
                        </div>


                        <!-- <div class="row">
                        
                        </div> -->

                        <div class="form-group">
                            <label for="rental" class="visually"><strong>Rental Rate</strong></label>
                            <input type="text" class="form-control <?php echo (!empty($rental_err)) ? 'is-invalid' : ''; ?>" id="rental" name="rental" placeholder="Rental Rate (per day)">
                            <span class="help-block"><?php echo $rental_err; ?></span>
                        </div>

                        <div class="form-group">
                            <label for="year" class="visually"><strong>Year Produced</strong></label>
                            <input type="text" class="form-control <?php echo (!empty($year_err)) ? 'is-invalid' : ''; ?>" id="year" name="year" placeholder="Year Produced">
                            <span class="help-block"><?php echo $year_err; ?></span>
                        </div>

                        <div class="form-group">
                            <label for="detail"><strong>Vehicle Detail</strong></label>
                            <textarea name="detail" id="editor" cols="15" rows="20" placeholder="text"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="control-label form-label"><strong>Vehicle Image</strong></label>
                            <input class="form-control" type="file" name="image" onchange="readURL(this);" />
                            <span class="help-block"><?php echo $errMSG;?></span>
                        </div>
                        <script>
                            function readURL(input) {
                                if (input.files && input.files[0]) {
                                    var reader = new FileReader();

                                    reader.onload = function (e) {
                                        $('#blah')
                                            .attr('src', e.target.result)
                                            .width(150)
                                            .height(200);
                                    };

                                    reader.readAsDataURL(input.files[0]);
                                }
                            }
                        </script>


                        <button type="submit" class="btn btn-success mb-3">Create</button>
                        <a href="read.php" class="btn btn-primary mb-3">Cancel</a>
                    </form>

                    <script>
                        CKEDITOR.replace('editor', {
                            uiColor: '',
                            height: 500,
                            codeSnippet_theme: 'Vs',
                            removePlugins: 'base64Image,image,image2'
                        });
                    </script>

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