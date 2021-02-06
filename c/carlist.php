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

    $sql = "SELECT * FROM tb_vehicle JOIN tb_brand ON tb_vehicle.b_id = tb_brand.b_id";

    $parameter = "";
    
    if (isset($_GET["brand"])){
        $sql .= " WHERE tb_brand.b_id = ?";
        $brand = mysqli_real_escape_string($conn, $_GET["brand"]);
        $parameter.= "brand=".$brand;
    }

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        $sql_err = "SQL Error";
    }else{
        if (isset($brand))
            mysqli_stmt_bind_param($stmt, 'i', $brand);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
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
                <div class="col-3" style="width: auto;max-width: 100%;margin-right: auto;margin-left: auto;">
                    <h1 class="text-light">Filter</h1>

                    <form>
                        <div class="card">
                            <div class="card-body"><label>Brand</label>

                                <div class="dropdown">
                                    <?php
                                            $sql1 = "SELECT * FROM tb_brand;";
                                            $stmt1 = mysqli_stmt_init($conn);

                                            mysqli_stmt_prepare($stmt1, $sql1);
                                            
                                            mysqli_stmt_execute($stmt1);
                                            $result1 = mysqli_stmt_get_result($stmt1);
                                            
                                        ?>
                                    <select class="form-select" aria-label="Default select example" name="brand">
                                        <option value="" selected>Open this menu</option>
                                        <?php
                                            while ($row1 = mysqli_fetch_array($result1)){
                                                if ($brand == $row1["b_id"]){
                                        ?>  
                                            <option class="dropdown-item" value="<?php echo $row1["b_id"]; ?>" selected><?php echo $row1["b_name"]; ?></option>
                                        <?php
                                                }else{
                                        ?>
                                            <option value="<?php echo $row1["b_id"]; ?>"><?php echo $row1["b_name"]; ?></option>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </select><br>
                                </div><br>
                                
                                <div class="btn-group" role="group">
                                    <input type="submit" value="Apply" class="btn btn-primary">
                                    <input type="button" onclick="location.href='carlist.php';" value="Go to Google" class="btn btn-warning" />
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="col">
                    <div class="card"></div>
                    <h1>CAR LIST</h1>

                    <?php 
                        if(isset($_GET["page"])){
                            $pageNum = $_GET["page"] - 1;
                        }else{
                            $pageNum = 1 - 1;
                        }

                        
                        $initItemNum = 3 * $pageNum + 1;
                        $finalItemNum = 3* $pageNum + 3;

                        $numOfRows = mysqli_num_rows($result);
                        $numOfPages = ceil($numOfRows / 3);
                        $counter = 0;

                        if ($numOfRows > 0) {
                            while ($row = mysqli_fetch_array($result)){
                                $counter++;
                                if($counter >= $initItemNum && $counter <= $finalItemNum){
                    ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="media"><img class="mr-3" src="<?php echo (empty($row["v_img_path"]))? "../a/vehicle/".$row["v_img_path"]: "noimage.png"; ?>">
                                                <div class="media-body">
                                                    <h5 style="color: black;"><?php echo $row["v_type"]; ?></h5>
                                                    <ul>
                                                        <li>Rental Rate: RM <?php echo $row["v_price"]; ?>.00/day</li>
                                                        <li>Year Produced: <?php echo $row["v_year"]; ?></li>
                                                    </ul>
                                                </div>
                                            </div><button class="btn btn-warning" type="button"><?php echo $row["b_name"]; ?></button>
                                            <div class="btn-group float-right" role="group">
                                                <a class="btn btn-primary" role="button" href="detail.php?id=<?php echo $row["v_id"]; ?>">VIEW</a>
                                                <a class="btn btn-success" href="bookings/create.php" target="_blank" role="button">BOOK It!</a>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                    <?php
                                }
                            }
                        }
                    ?>

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
            </div>
        </div>
    </section>
</body>

</html>

<?php 
    include_once("footer.php");
?>