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

    $sql = "SELECT * FROM tb_vehicle JOIN tb_brand ON tb_vehicle.b_id = tb_brand.b_id WHERE v_id = ?";

    if (isset($_GET["id"])){
        $v_id = mysqli_real_escape_string($conn, $_GET["id"]);
    }else{
        exit();
    }
    
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        $sql_err = "SQL Error";
    }else{
        mysqli_stmt_bind_param($stmt, 'i', $v_id);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result);
    }

    include_once("../navbar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row align-items-start">
            <div class="col-md-8 col-xl-8 mb-12"><h2 class="text-dark mb-4">VEHICLE DETAIL</h2></div>

        </div>


        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 font-weight-bold">Vehicle Info</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                            <img src="<?php echo $row["v_img_path"] ?>" class="img-thumbnail" alt="vehicle image">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Vehicle ID</th>
                                        <th><?php echo $row["v_id"] ?></th>
                                    </tr>

                                    <tr>
                                        <th scope="col">Name</th>
                                        <td><?php echo $row["v_type"] ?></td>
                                    </tr>

                                    <tr>
                                        <th scope="col">Brand</th>
                                        <td><i><?php echo $row["b_name"] ?></i></td>
                                    </tr>

                                    <tr>
                                        <th scope="col">Rental Rate(Per DAY)</th>
                                        <td><?php echo $row["v_price"] ?></td>
                                    </tr>

                                    <tr>
                                        <th scope="col">Year Produced</th>
                                        <td><?php echo $row["v_year"] ?></td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                
                
                <br>
                <div class="card shadow">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 font-weight-bold">Vehicle Detail</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                            <div><?php echo $row["v_detail"] ?></div>
                        </div>
                    </div>
                </div><br>
                <a href="update.php?id=<?php echo $row["v_id"]; ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> EDIT</a>&nbsp
                <a href="delete.php?id=<?php echo $row["v_id"]; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this brand');"><i class="fa fa-trash"></i> DELETE</a>

                <a href="#" class="btn btn-dark btn-sm float-right" onclick="history.go(-1)"><i class="fa fa-chevron-left"></i>&nbspBACK</a>
            
            </div>

        </div>
        
    </div>

</body>
</html>

<?php
    include_once("../footer.php");
    mysqli_close($conn);
?>