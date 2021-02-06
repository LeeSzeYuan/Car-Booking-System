<?php
    $id = "";
    $id_err = "";
    $name = "";
    $name_err = "";
    $brand = "";
    $brand_err = "";
    $rental = "";
    $rental_err = "";
    $year = "";
    $year_err = "";
    $detail = "";

    $errMSG = "";

    $sql_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        if (empty(trim(($_POST["id"])))){
            $id_err = "Please enter the vehicle plate number";
        }else{
            $id = mysqli_real_escape_string($conn, $_POST["id"]);
        }

        if (empty(trim(($_POST["name"])))){
            $name_err = "Please enter the name of the vehicle";
        }else{
            $name = mysqli_real_escape_string($conn, $_POST["name"]);
        }

        if (empty(trim(($_POST["brand"])))){
            $brand_err = "Please choose the name of the brand";
        }else{
            $brand = mysqli_real_escape_string($conn, $_POST["brand"]);
        }

        if (empty(trim(($_POST["rental"])))){
            $rental_err = "Please enter the rental rate";
        }else{
            $rental = mysqli_real_escape_string($conn, $_POST["rental"]);
        }

        if (empty(trim(($_POST["year"])))){
            $year_err = "Please enter the year produced";
        }else{
            $year = mysqli_real_escape_string($conn, $_POST["year"]);
        }

        $detail = $_POST["detail"];


        $imgFile = $_FILES['image']['name'];
        $tmp_dir = $_FILES['image']['tmp_name'];
        $imgSize = $_FILES['image']['size'];
    
        $upload_dir = 'images/'; // upload directory
    
        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
    
        // valid image extensions
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
        
        // rename uploading image
        $pic = rand(1000,1000000).".".$imgExt;
    
        // allow valid image file formats
        if(in_array($imgExt, $valid_extensions)){   
            // Check file size '5MB'
            if($imgSize > 5000000){
                $errMSG = 'Sorry, your file is too large.';
                header("location: create.php");
            }
        }
        else{
            $errMSG = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';  
        }

        if ($imgSize == 0){
            $errMSG = "";
        }

        if (empty($id_err)&&empty($name_err)&&empty($brand_err)&&empty($rental_err)&&empty($year_err)&&empty($errMSG)){

            $path = $upload_dir.$pic;


            $sql = "INSERT INTO tb_vehicle(v_id, v_type, b_id, v_price, v_year, v_detail, v_img_path) VALUES(?,?,?,?,?,?,?);";

            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)){
                $sql_err = "SQL Error";
            }else{
                mysqli_stmt_bind_param($stmt, "ssissss", $id, $name, $brand, $rental, $year, $detail, $path);
    
                if (mysqli_stmt_execute($stmt)){
                    move_uploaded_file($tmp_dir, $upload_dir.$pic);

                    mysqli_stmt_close($stmt);
                    echo "<script>alert('The vehicle is created');window.location.replace('read.php');</script>";
                }else{
                    $sql_err = mysqli_error($conn);
                }
            }
        }
    }

?>