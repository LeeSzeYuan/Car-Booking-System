<?php
    require_once("../../dbconfig.php");
    if(!session_id())//if session_id is not found
	{
		session_start();
	}
	
	if(isset($_SESSION['id']) != session_id())
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
            JOIN tb_status ON  tb_booking.b_status = tb_status.s_id";

    $parameter = "";
        
    if (isset($_GET["brand"])){
        $brand = $_GET["brand"];
        $sql .= " WHERE tb_brand.b_id = $brand";

        $parameter.= "brand=".$brand;
    }

    if (isset($_GET["status"]) && $_GET["status"] != ""){
        $status = $_GET["status"];
        $sql .= " AND b_status = $status";

        $parameter.= "&status=".$status;
    }

    if (isset($_GET["name"])){
        
        $name = mysqli_real_escape_string($conn, $_GET["name"]);
        $sql .= " WHERE (tb_vehicle.v_type LIKE '%".$name."%' or tb_vehicle.v_id LIKE '%".$name."%' 
                or tb_status.s_desc LIKE '%".$name."%' or tb_brand.b_name LIKE '%".$name."%'
                or tb_booking.book_id LIKE '%".$name."%')";

        $parameter.= "name=".$name;
    }else{
        $_GET["name"] = "";
    }


    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        $sql_err = "SQL Error";
        echo $sql_err;
    }else{
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
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
            <div class="col-md-8 col-xl-8 mb-12"><h2 class="text-dark mb-4">Reservation List</h2></div>

            <div class="col-md-3 col-xl-3 mb-4">
                <button class="btn btn-success" onclick="hide()"><i class="fa fa-filter"></i> Filter</button>
            </div>
        </div>

        <script>
            function hide() {
                var x = document.getElementById("filter");
                if (x.style.display === "none") {
                    x.style.display = "block";
                } else {
                    x.style.display = "none";
                }
            }
        </script>

        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 font-weight-bold">Reservation Info</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                            <form action="read.php" method="GET">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="type here..." aria-label="Recipient's username" aria-describedby="button-addon2" name = "name" value="<?php echo $_GET["name"]; ?>">
                                    <button type="submit" class="btn btn-outline-dark" type="button" id="button-addon2" style="font-size: 13px;">Search</button>
                                    <a href="read.php" class="btn btn-outline-danger"  type="button" id="button-addon2" style="font-size: 13px;">Cancel</a>
                                </div>
                            </form>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Booking ID</th>
                                        <th scope="col">Vehicle ID</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Start Date</th>
                                        <th scope="col">End Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(isset($_GET["page"])){
                                            $pageNum = $_GET["page"] - 1;
                                        }else{
                                            $pageNum = 1 - 1;
                                        }
                
                                        
                                        $initItemNum = 5 * $pageNum + 1;
                                        $finalItemNum = 5* $pageNum + 5;
                
                                        $numOfRows = mysqli_num_rows($result);
                                        $numOfPages = ceil($numOfRows / 5);
                                        $counter = 0;
                
                                        if ($numOfRows > 0) {
                                            $num = 1;
                                            while($row = mysqli_fetch_array($result)){
                                                $counter++;
                                                if($counter >= $initItemNum && $counter <= $finalItemNum){
                                    ?>
                                                    <tr>
                                                        <th scope='row'><?php echo $num ?></th>
                                                        <th scope='row'><?php echo $row["book_id"] ?></th>
                                                        <td><a href="../vehicle/detail.php?id=<?php echo $row["v_id"] ?>"><?php echo $row["v_type"] ?></a></td>
                                                        <td><a href="../users/detail.php?id=<?php echo $row["user_id"] ?>"><?php echo $row["username"] ?></a></td>
                                                        <td><?php echo $row["b_date"] ?></td>
                                                        <td><?php echo $row["r_date"] ?></td>
                                                        
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

                                                        <td>
                                                            <a href="detail.php?id=<?php echo $row["book_id"]; ?>" class="btn btn-info btn-sm"><i class="fa fa-book"></i></a>&nbsp
                                                        </td>
                                    
                                                        <td>
                                                            <a href="accept.php?id=<?php echo $row["book_id"]; ?>" class="btn btn-success btn-sm" onclick="return confirm('Approve this booking?')"><i class="fa fa-check"></i></a>&nbsp
                                                            <a href="reject.php?id=<?php echo $row["book_id"]; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Reject this booking?')"><i class="fa fa-times"></i></a>&nbsp
                                                        </td>
                                                
                                    <?php
                                                    echo "</tr>";
                                                }
                                                $num++;
                                            }
                                            
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <nav aria-label="Page navigation news">
                    <ul class="pagination justify-content-end flex-wrap">
                        <li class="page-item <?php if ($_GET['page'] == 1 || !isset($_GET['page'])) 
                                                        echo "disabled"; ?>">

                            <a class="page-link" href="<?php echo (!empty($parameter))? "?".$parameter."&" : '?'; ?>page=<?php if (isset($_GET['page'])){
                                                                        if ($_GET["page"] == 1)
                                                                            echo  $_GET["page"];
                                                                        else 
                                                                            echo  $_GET["page"] - 1;
                                                                        }else{
                                                                            echo "1";
                                                                        }
                                                            ?>">Previous</a></li>
                                        <?php
                                            for ($i = 1 ; $i <= $numOfPages ; $i++){ 
                                        ?>
                                                <li class="page-item">
                                                    <a class="page-link" href="<?php echo (!empty($parameter))? "?".$parameter."&" : '?'; ?>page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                                </li>
                                        <?php
                                            }
                                        ?>
                                        <li class="page-item <?php if($_GET['page'] == $numOfPages)
                                                                echo "disabled"; ?>">
                                            <a class="page-link" href="<?php echo (!empty($parameter))? "?".$parameter."&" : '?'; ?>page=<?php if (isset($_GET['page'])){
                                                                                        if($_GET["page"] + 1 > $numOfPages)
                                                                                            echo  $_GET["page"];
                                                                                        else 
                                                                                            echo  $_GET["page"]+1;
                                                                                    }else{
                                                                                        echo "2";
                                                                                    }
                                                                                    
                                                                            ?>">Next</a>
                                        </li>
                    </ul>
                </nav>
            
            </div>

            <div class="col-md-2 col-xl-3 mb-2" id="filter" style="display: none;">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">

                            <form action="read.php" method="GET"> 
                                    <?php
                                        $sql1 = "SELECT * FROM tb_brand;";
                                        $stmt1 = mysqli_stmt_init($conn);

                                        mysqli_stmt_prepare($stmt1, $sql1);
                                        
                                        mysqli_stmt_execute($stmt1);
                                        $result1 = mysqli_stmt_get_result($stmt1);
                                        
                                    ?>
                                <label for="brand" class="form-label">Brand</label>
                                <select class="form-select" aria-label="Default select example" name="brand">
                                    <option value="">Open this menu</option>
                                    <?php
                                        while ($row1 = mysqli_fetch_array($result1)){
                                            if ($_GET["brand"] == $row1["b_id"]){
                                    ?>  
                                        <option value="<?php echo $row1["b_id"]; ?>" selected><?php echo $row1["b_name"]; ?></option>
                                    <?php
                                            }else{
                                    ?>
                                        <option value="<?php echo $row1["b_id"]; ?>"><?php echo $row1["b_name"]; ?></option>
                                    <?php
                                            }
                                        }
                                    ?>
                                </select><br>


                                <?php
                                        $sql2 = "SELECT * FROM tb_status;";
                                        $stmt2 = mysqli_stmt_init($conn);

                                        mysqli_stmt_prepare($stmt2, $sql2);
                                        
                                        mysqli_stmt_execute($stmt2);
                                        $result2 = mysqli_stmt_get_result($stmt2);
                                        
                                    ?>
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" aria-label="Default select example" name="status">
                                    <option value="">Open this menu</option>
                                    <?php
                                        while ($row2 = mysqli_fetch_array($result2)){
                                            if ($_GET["status"] == $row2["s_id"]){
                                    ?>  
                                        <option value="<?php echo $row2["s_id"]; ?>" selected><?php echo $row2["s_desc"]; ?></option>
                                    <?php
                                            }else{
                                    ?>
                                        <option value="<?php echo $row2["s_id"]; ?>"><?php echo $row2["s_desc"]; ?></option>
                                    <?php
                                            }
                                        }
                                    ?>
                                </select><br>
                                        
                                <input type="submit" value="Apply" class="btn btn-primary">
                                <a href="read.php" class="btn btn-warning">Cancel</a><br><br>
                            </form>

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
    mysqli_close($conn);
?>