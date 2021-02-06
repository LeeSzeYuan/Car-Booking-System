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

    $sql = "SELECT * FROM tb_user WHERE usertype = 'A'";

    $parameter = "";
    

    if (isset($_GET["name"])){
        
        $name = mysqli_real_escape_string($conn, $_GET["name"]);
        $sql .= " AND username LIKE '%".$name."%' or user_id LIKE '%".$name."%' or name LIKE '%".$name."%'";

        $parameter.= "name=".$name;
    }else{
        $_GET["name"] = "";
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
    <title>Users</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row align-items-start">
            <div class="col-md-8 col-xl-8 mb-12"><h2 class="text-dark mb-4">USERS LIST</h2></div>

            <div class="col-md-3 col-xl-3 mb-4">
                <a href="read.php" class="btn btn-primary">View Customer Users</a>&nbsp&nbsp&nbsp
                <!-- <button class="btn btn-success" onclick="hide()"><i class="fa fa-filter"></i></button> -->
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
                        <p class="text-primary m-0 font-weight-bold">User Info</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                            <form action="read.php" method="GET">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="type here..." aria-label="Recipient's username" aria-describedby="button-addon2" name = "name" value="<?php echo $_GET["name"]; ?>">
                                    <button type="submit" class="btn btn-outline-dark" type="button" id="button-addon2" style="font-size: 13px;">Search</button>
                                    <a class="btn btn-outline-danger" type="button" href="read.php" id="button-addon2" style="font-size: 13px;">Cancel</a>
                                </div>
                            </form>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">User ID</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Contact Number</th>
                                        <th scope="col">Email</th>
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
                                                        <td><i class="fas fa-user"></i><?php echo $row["user_id"] ?></td>
                                                        <td><?php echo $row["username"] ?></td>
                                                        <td><?php echo $row["name"] ?></td>
                                                        <td><?php echo $row["contact_num"] ?></td>
                                                        <td><?php echo $row["email"] ?></td>
                                    
                                                        <td>
                                                            <a href="detail.php?id=<?php echo $row["user_id"]; ?>" class="btn btn-info btn-sm"><i class="fa fa-book"></i></a>&nbsp
                                                            <a href="update.php?id=<?php echo $row["user_id"]; ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>&nbsp
                                                            <a href="delete.php?id=<?php echo $row["user_id"]; ?>" class="btn btn-danger btn-sm <?php echo ($row["user_id"] == $_SESSION["user_id"])? "disabled": ""; ?>" onclick="return confirm('Are you sure to delete this user');"\><i class="fa fa-trash"></i></a>
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
        </div>
        
    </div>

</body>
</html>

<?php
    include_once("../footer.php");
    mysqli_close($conn);
?>