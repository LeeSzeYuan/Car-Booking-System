<?php 
	require_once("../dbconfig.php");
	if(!session_id())//if session_id is not found
	{
		session_start();
	}
	
	if(isset($_SESSION['id']) != session_id() )
	{
		include_once("navbar2.php");
    }else{
        include_once("navbar.php");
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

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home - CBS</title>
</head>
<style>
    img{
        width: 30%;
        height: 30%;
    }
</style>

<body id="page-top">

    <section class="text-light bg-warning" id="contact-2" style="background: url(&quot;assets/img/header.jpg&quot;);">
        <header></header>
        <h1 class="display-2 text-center" style="color: black;">Book Your Car here!</h1>
    </section>
    <section class="text-light bg-dark" id="contact-1">
        <div class="container">
            <div class="row text-primary flex-grow-1 flex-fill">
                <div class="col">
                    <div class="card"></div>
                    
                    <div class="card">
                        <div class="card-body">
                            <img class="mr-3 img-fluid" src="<?php echo (empty($row["v_img_path"]))? "../a/vehicle/".$row["v_img_path"]: "noimage.png"; ?>"><h1><?php echo $row["v_type"]; ?></h1>
                            <div class="media">
                                <div class="media-body">
                                    <div class="row">
                                        <div class="col">
                                            
                                            <h5 style="color: black;">Information</h5>
                                            <ul>
                                                <li>Plate Number: <p  style="color: black;"><?php echo $row["v_id"]; ?></p> </li>
                                                <li>Rental Rate: <p  style="color: black;">RM <?php echo $row["v_price"]; ?>.00/day</p> </li>
                                                <li>Year Produced: <p  style="color: black;"><?php echo $row["v_year"]; ?></p> </li>
                                            </ul>
                                        </div>

                                        <div class="col">
                                            <h5 style="color: black;">Detail Description</h5>
                                            <p  style="color: black;">
                                                <?php echo $row["v_detail"]; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div><button class="btn btn-warning" type="button"><?php echo $row["b_name"]; ?></button>
                            <div class="btn-group float-right" role="group">
                                <a class="btn btn-success" href="bookings/create.php" target="_blank" role="button">BOOK It!</a>
                            </div>
                        </div>
                    </div>
                    <hr>

                </div>
            </div>
        </div>
    </section>
</body>

</html>

<?php 
    include_once("footer.php");
?>