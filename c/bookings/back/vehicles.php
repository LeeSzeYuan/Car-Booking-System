<?php
    
    require_once("../../../dbconfig.php");
    $brand;

    if (isset($_GET['brand'])){
        $brand = $_GET['brand'];
    }

    $sql = "SELECT * FROM tb_vehicle WHERE b_id = $brand";

    $result = mysqli_query($conn, $sql);

    $vehicles = array();
    while($vehicle = mysqli_fetch_assoc($result)){
        $vehicles[] = $vehicle;
    }

    echo json_encode($vehicles);

?>