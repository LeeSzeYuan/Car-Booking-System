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

    $sql = "SELECT * FROM tb_booking 
    JOIN tb_user ON tb_booking.user_id = tb_user.user_id 
    JOIN tb_vehicle ON tb_booking.v_id = tb_vehicle.v_id
    JOIN tb_brand ON tb_vehicle.b_id = tb_brand.b_id
    JOIN tb_status ON  tb_booking.b_status = tb_status.s_id
    WHERE book_id = ?";

    if (isset($_GET["id"])){
        $book_id = mysqli_real_escape_string($conn, $_GET["id"]);
    }else{
        exit();
    }
    
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        $sql_err = "SQL Error";
    }else{
        mysqli_stmt_bind_param($stmt, 'i', $book_id);

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
    <title>Reservation</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row align-items-start">
            <div class="col-md-8 col-xl-8 mb-12"><h2 class="text-dark mb-4">Reservation Detail</h2></div>

        </div>


        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 font-weight-bold">Reservation Info</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Book ID</th>
                                        <th><?php echo $row["book_id"] ?></th>
                                    </tr>

                                    <tr>
                                        <th scope="col">Vehicle</th>
                                        <td><a href="../vehicle/detail.php?id=<?php echo $row["v_id"] ?>"><?php echo $row["v_type"] ?> - <?php echo $row["v_id"] ?></a></td>
                                    </tr>

                                    <tr>
                                        <th scope="col">Brand</th>
                                        <td><i><?php echo $row["b_name"] ?></i></td>
                                    </tr>

                                    <tr>
                                        <th scope="col">Username</th>
                                        <td><i><a href="../users/detail.php?id=<?php echo $row["user_id"] ?>"><?php echo $row["username"] ?></a></i></td>
                                    </tr>

                                    <tr>
                                        <th scope="col">Total Price(RM)</th>
                                        <td><?php echo $row["total_price"] ?></td>
                                    </tr>

                                    <tr>
                                        <th scope="col">Start Date</th>
                                        <td><?php echo $row["b_date"] ?></td>
                                    </tr>

                                    <tr>
                                        <th scope="col">Resturn Date</th>
                                        <td><?php echo $row["r_date"] ?></td>
                                    </tr>

                                    <tr>
                                        <th scope="col">Status</th>
                                        <td>
                                        <?php
                                            if ($row["b_status"] == 1){
                                                echo '<button class="btn btn-secondary btn-sm">'.$row["s_desc"].'</button>';
                                            }else if ($row["b_status"] == 2){
                                                echo '<button class="btn btn-success btn-sm">'.$row["s_desc"].'</button>';
                                            }else{
                                                echo '<button class="btn btn-danger btn-sm">'.$row["s_desc"].'</button>';
                                            }
                                        
                                        ?>

                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                
                
                <br>
                <a href="accept.php?id=<?php echo $row["book_id"]; ?>" class="btn btn-success btn-sm" onclick="return confirm('Approve this booking?')"><i class="fa fa-check"></i>&nbspApprove</a>&nbsp
                <a href="reject.php?id=<?php echo $row["book_id"]; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Reject this booking?')"><i class="fa fa-times"></i>&nbspReject</a>&nbsp

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