<?php
    $brand = "";
    $brand_err = "";

    $sql_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (empty(trim(($_POST["brand"])))){
            $brand_err = "Please enter the name of the brand";
        }else{
            $brand = mysqli_real_escape_string($conn, $_POST["brand"]);
        }

        if (empty($brand_err)){
            $sql = "INSERT INTO tb_brand(b_name) VALUES(?);";

            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)){
                $sql_err = "SQL Error";
            }else{
                mysqli_stmt_bind_param($stmt, "s", $brand);
    
                if (mysqli_stmt_execute($stmt)){
                    mysqli_stmt_close($stmt);
                    echo "<script>alert('The brand is created');window.location.replace('read.php');</script>";
                }else{
                    $sql_err = mysqli_error($conn);
                }
            }
        }
    }

?>

