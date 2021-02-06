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

        $id = mysqli_real_escape_string($conn, $_POST["id"]);

        if (empty($brand_err)){
            $sql = "UPDATE tb_brand SET b_name=? WHERE b_id=?;";

            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)){
                $sql_err = "SQL Error";
            }else{
                mysqli_stmt_bind_param($stmt, "ss", $brand, $id);
    
                if (mysqli_stmt_execute($stmt)){
                    mysqli_stmt_close($stmt);
                    echo "<script>alert('The changes is saved');window.location.replace('read.php');</script>";
                }else{
                    $sql_err = mysqli_error($conn);
                }
            }
        }
    }

?>