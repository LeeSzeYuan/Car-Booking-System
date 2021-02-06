<?php
    $start = "";
    $start_err = "";
    $end = "";
    $end_err = "";
    $brand = "";
    $brand_err = "";
    $vehicle = "";
    $vehicle_err = "";


    $sql_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        if (empty(trim(($_POST["start"])))){
            $start_err = "Please choose a start date";
        }else{
            $start = mysqli_real_escape_string($conn, $_POST["start"]);
        }

        if (empty(trim(($_POST["end"])))){
            $end_err = "Please choose an end date";
        }else{
            $end = mysqli_real_escape_string($conn, $_POST["end"]);
        }

        if (empty(trim(($_POST["brand"])))){
            $brand_err = "Please choose the name of the brand";
        }else{
            $brand = mysqli_real_escape_string($conn, $_POST["brand"]);
        }

        if (empty(trim(($_POST["vehicle"])))){
            $vehicle_err = "Please choose a vehicle";
        }else{
            $vehicle = mysqli_real_escape_string($conn, $_POST["vehicle"]);
        }



        if (empty($start_err)&&empty($end_err)&&empty($brand_err)&&empty($vehicle_err)){

            $date1 = strtotime($start);  
            $date2 = strtotime($end);
            $diff = abs($date2 - $date1);
            $days = floor($diff / (60*60*24)); 

            $sql = "SELECT * FROM tb_vehicle WHERE v_id = '$vehicle'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $price = $days * $row["v_price"];


            $sql = "SELECT v_id
                    FROM tb_booking
                    WHERE (b_date <= '$start' AND r_date >= '$end') 
                    OR (b_date >= '$start' AND r_date <= '$end')
                    OR (b_date <= '$start' AND r_date > '$start'  AND r_date <= '$end')
                    OR (r_date >= '$end' AND b_date >= '$start'  AND b_date < '$end')";
            $result = mysqli_query($conn, $sql);
            
            while( $row = mysqli_fetch_array( $result)){
                $unavailable[] = $row; // Inside while loop
            }
            $unavailable = array_column($unavailable, 'v_id');

            if (in_array($vehicle, $unavailable)){
                $sql = "INSERT INTO tb_booking(v_id, user_id, b_date, r_date, total_price, b_status) VALUES(?,'".$_SESSION['user_id']."',?,?,?,1);";
            }else{
                $sql = "INSERT INTO tb_booking(v_id, user_id, b_date, r_date, total_price, b_status) VALUES(?,'".$_SESSION['user_id']."',?,?,?,2);";
            }

            

            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)){
                $sql_err = "SQL Error";
                echo $sql_err;
            }else{
                mysqli_stmt_bind_param($stmt, "ssss", $vehicle, $start, $end, $price);
    
                if (mysqli_stmt_execute($stmt)){
                    mysqli_stmt_close($stmt);

                    if (in_array($vehicle, $unavailable)){
                        echo "<script>alert('Your Booking is made.'); window.location.replace('read.php');</script>";
                    }else{
                        echo "<script>alert('Your Booking is made. And it is Approved!'); window.location.replace('read.php');</script>";
                    }
                    

                }else{
                    $sql_err = mysqli_error($conn);
                    echo $sql_err;
                }
            }
        }
    }

?>

