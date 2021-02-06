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
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark mb-0">Dashboard</h3>
        </div>
        <div class="row">
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-left-info py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-uppercase text-info font-weight-bold text-xs mb-1"><span>Total RESERVATION</span></div>
                                <?php
                                    $total = "SELECT COUNT(book_id) as total FROM tb_booking;";
                                    $result_total = mysqli_query($conn, $total);
                                    $row_total = mysqli_fetch_array($result_total);
                                ?>
                                <div class="text-dark font-weight-bold h5 mb-0"><span><?php echo $row_total["total"]; ?></span></div>
                            </div>
                            <div class="col-auto"><i class="fas fa-bookmark fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-left-success py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-uppercase text-success font-weight-bold text-xs mb-1"><span>Total EARNING</span></div>
                                <?php
                                    $date = date("Y-m-d");
                                    $earning = "SELECT SUM(total_price) as earning FROM tb_booking WHERE b_status = 2 AND b_date < '$date';";
                                    $result_earning = mysqli_query($conn, $earning);
                                    $row_earning = mysqli_fetch_array($result_earning);
                                ?>
                                <div class="text-dark font-weight-bold h5 mb-0"><span>RM <?php echo $row_earning["earning"]; ?>.00</span></div>
                            </div>
                            <div class="col-auto"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-left-warning py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-uppercase text-warning font-weight-bold text-xs mb-1"><span>NUMBER OF USERS</span></div>
                                <?php
                                    $number = "SELECT COUNT(user_id) as number FROM tb_user WHERE usertype = 'C';";
                                    $result_number = mysqli_query($conn, $number);
                                    $row_number = mysqli_fetch_array($result_number);
                                ?>
                                <div class="text-dark font-weight-bold h5 mb-0"><span><?php echo $row_number["number"]; ?></span></div>
                            </div>
                            <div class="col-auto"><i class="fas fa-users fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-left-info py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-uppercase text-info font-weight-bold text-xs mb-1"><span>PENDING RESERVATION</span></div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <?php
                                            $pending = "SELECT COUNT(book_id) as pending FROM tb_booking WHERE b_status = 1;";
                                            $result_pending = mysqli_query($conn, $pending);
                                            $row_pending = mysqli_fetch_array($result_pending);
                                        ?>
                                        <div class="text-dark font-weight-bold h5 mb-0 mr-3" style="margin-left: 10px;"><span><?php echo $row_pending["pending"]; ?></span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto"><i class="fas fa-clipboard-list fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="text-primary font-weight-bold m-0">Vehicle (classified according to brands)</h6>
                    </div>
                    <?php
                        $sql = "SELECT tb_brand.b_id, b_name, COUNT(v_id) as Amount FROM tb_brand JOIN tb_vehicle ON tb_brand.b_id = tb_vehicle.b_id GROUP BY tb_brand.b_id;";
                        $result = mysqli_query($conn, $sql);
                    ?>
                    <div class="card" style="margin: 10px;">
                        <table class="table">
                            <tr>
                                <th scope="col">Brand</th>
                                <th scope="col">Vehicle Amount</th>
                            </tr>
                        <?php
                            while($row = mysqli_fetch_array($result)){
                        ?>
                            <tr>
                                <th scope="row"><a href="../vehicle/read.php?brand=<?php echo $row["b_id"] ?>" target="_blank"><?php echo $row["b_name"]; ?></a></th>
                                <td><?php echo $row["Amount"]; ?></td>
                            </tr>
                        <?php
                            }
                        ?>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="row">
                    <h4 class="text-dark mb-0">Reservations</h4>
                </div>
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="card text-white bg-success shadow">
                            <div class="card-body">
                                <p class="m-0">Approved</p>
                                <?php
                                    $approved = "SELECT COUNT(book_id) as approved FROM tb_booking WHERE b_status = 2;";
                                    $result_approved = mysqli_query($conn, $approved);
                                    $row_approved = mysqli_fetch_array($result_approved);
                                ?>
                                <p class="text-white small m-0 font-weight-bold"><?php echo $row_approved["approved"]; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card text-white bg-secondary shadow">
                            <div class="card-body">
                                <p class="m-0">Pending</p>
                                <?php
                                    $pending = "SELECT COUNT(book_id) as pending FROM tb_booking WHERE b_status = 1;";
                                    $result_pending = mysqli_query($conn, $pending);
                                    $row_pending = mysqli_fetch_array($result_pending);
                                ?>
                                <p class="text-white small m-0 font-weight-bold"><?php echo $row_pending["pending"]; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card text-white bg-danger shadow">
                            <div class="card-body">
                                <p class="m-0">Rejected</p>
                                <?php
                                    $rejected = "SELECT COUNT(book_id) as rejected FROM tb_booking WHERE b_status = 3;";
                                    $result_rejected = mysqli_query($conn, $rejected);
                                    $row_rejected = mysqli_fetch_array($result_rejected);
                                ?>
                                <p class="text-white small m-0 font-weight-bold"><?php echo $row_rejected["rejected"]; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card text-white bg-info shadow">
                            <div class="card-body">
                                <p class="m-0">Total</p>
                                <?php
                                    $total = "SELECT COUNT(book_id) as total FROM tb_booking;";
                                    $result_total = mysqli_query($conn, $total);
                                    $row_total = mysqli_fetch_array($result_total);
                                ?>
                                <p class="text-white small m-0 font-weight-bold"><?php echo $row_total["total"]; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
    include_once("../footer.php");
?>