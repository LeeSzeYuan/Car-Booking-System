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

    if (isset($_GET["sort"])){
        if ($_GET["sort"] == 1)
            $sql = "SELECT * FROM tb_brand ORDER BY b_name;";
        else if ($_GET["sort"] == 2)
            $sql = "SELECT * FROM tb_brand ORDER BY b_id;";
        else
            $sql = "SELECT * FROM tb_brand;";

        $parameter = "sort=".$_GET["sort"];
    }else{
        $sql = "SELECT * FROM tb_brand;";
    }
    
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        $sql_err = "SQL Error";
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
    <title>Brand</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row align-items-start">
            <div class="col-md-8 col-xl-8 mb-12"><h2 class="text-dark mb-4">BRAND LIST</h2></div>

            <div class="col-md-3 col-xl-3 mb-4">
                <a href="create.php" class="btn btn-primary ">Add Brand</a>
            </div>
        </div>


        <h3>Sort By</h3>
        <form action="read.php"  class="row" method="GET"> 
            <div class="col-md-5 col-lg-5 col-xl-3 mb-12">
                <select class="form-select" aria-label="Default select example" name="sort">
                    <option value="">Open this Menu</option>
                    <?php
                        $types = [1, 2, 3];
                        $sortby = ["Name", "ID", "default"];

                        foreach($types as $type){
                    ?>
                        <option value="<?php echo $type; ?>"><?php echo $sortby[$type-1]; ?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>

            <div class="col-md-5 col-lg-5 col-xl-3 mb-12 d-flex justify-content-center">
                <input type="submit" value="Apply" class="btn btn-primary">&nbsp
                <a href="?" class="btn btn-warning">Cancel</a>
            </div>
        </form><br>
        
        
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">Vehicle Brand Info</p>
            </div>
            <div class="card-body">
                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Brand</th>
                                <th scope="col">Brand ID</th>
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
                                            echo "<tr>";
                                                echo "<th scope='row'>".$num."</th>";
                                                echo "<td>".$row["b_name"]."</td>";
                                                echo "<th scope='row'>".$row["b_id"]."</th>";
                            ?>
                                                <td>
                                                    <a href="update.php?id=<?php echo $row["b_id"]; ?>" class="btn btn-warning"><i  class="fa fa-edit"></i> EDIT</a>&nbsp
                                                    <a href="delete.php?id=<?php echo $row["b_id"]; ?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete this brand');"><i class="fa fa-trash"></i>DELETE</a>
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
</body>
</html>

<?php
    include_once("../footer.php");
    mysqli_close($conn);
?>