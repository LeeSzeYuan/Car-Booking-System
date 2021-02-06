<?php
	require_once("../../dbconfig.php");
	if(!session_id())//if session_id is not found
	{
		session_start();
	}
	
	if(isset($_SESSION['id']) != session_id() )
	{
		header("../login.php");
    }
    
    include_once("navbar.php");

    $sql = "SELECT * FROM tb_brand;";


    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        $sql_err = "SQL Error";
        echo $sql_err;
    }else{
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    }
    
    
    
    include_once("back/createpro.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Bookings</title>
</head>
<style>
    .help-block{
        color: red;
    }

</style>
<body>
    <div class="container-fluid">
        <h3 class="text-dark mb-4">RESERVATION FORM</h3>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text m-0 font-weight-bold">Reservation</p>
            </div>
            <div class="card-body">
                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">


                    <form action="create.php" enctype="multipart/form-data" method="POST">

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="start" class="form-label <?php echo (!empty($start_err)) ? 'is-invalid' : ''; ?>"><strong>Start Date</strong></label>
                                    <input type="date" name="start" id="start" class="form-control" min = <?php echo date("Y-m-d"); ?>>
                                    <span class="help-block"><?php echo $start_err; ?></span>
                                </div>
                            </div>

                            <?php 
                                $date = new DateTime();

                                $date->modify('+1 day');
                                $min = $date->format('Y-m-d');
                            ?>

                            <div class="col">
                                <div class="form-group">
                                    <label for="end" class="form-label <?php echo (!empty($end_err)) ? 'is-invalid' : ''; ?>"><strong>End Date</strong></label>
                                    <input type="date" name="end" id="end" class="form-control" min = <?php echo $min; ?>>
                                    <span class="help-block"><?php echo $end_err; ?></span>
                                </div>
                            </div>
                        </div>

                        <script>
                            $(document).ready(function(){
                                $("#start").bind('change', function(event) {
                                    // $("#end").min = $("#start").value;
                                    console.log(document.getElementById("start").value);
                                    let x = document.getElementById("start").value;

                                    let date = new Date(x);
                                    let minimum = new Date();
                                    minimum.setDate(date.getDate() + 1);
                                    console.log(minimum);

                                    let dd = minimum.getDate();
                                    let mm = minimum.getMonth() + 1;
                                    let y = minimum.getFullYear();

                                    
                                    if (mm < 10){
                                        mm = '0' + mm;
                                    }
                                    if (dd < 10){
                                        dd = '0' + dd;
                                    }

                                    x = y +'-' + mm + '-' + dd;
                                    console.log(x);
                                    
                                    document.getElementById("end").value = "";
                                    document.getElementById("end").min = x;
                                });
                            });

                        </script>

                        <div class="form-group">
                            <label for="brand" class="visually"><strong>Brand</strong></label>
                            <select class="form-control  <?php echo (!empty($brand_err)) ? 'is-invalid' : ''; ?>" aria-label="Default select example" name="brand" id="brand">
                                <option selected value="">Open this select menu</option>
                                <?php
                                    while($row = mysqli_fetch_array($result)){
                                ?>
                                        <option value="<?php echo $row["b_id"]; ?>"><?php echo $row["b_name"]; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                            <span class="help-block"><?php echo $brand_err; ?></span>
                        </div>

                        <div class="form-group">
                            <label for="vehicle" class="visually"><strong>vehicle</strong></label>
                            <select class="form-control  <?php echo (!empty($vehicle_err)) ? 'is-invalid' : ''; ?>" aria-label="Default select example" name="vehicle" id="vehicle">
                                <option selected value="">Please Choose A Brand First</option>
                            </select>
                            <span class="help-block"><?php echo $vehicle_err; ?></span>
                        </div>

                        <script type="text/javascript">
                            document.getElementById('brand').addEventListener('change', loadVehicles);
                            // document.getElementById('rooms').addEventListener('change', loadRooms);

                            function loadVehicles(){
                                let brand = document.getElementById('brand').value;

                                let xhr = new XMLHttpRequest();
                                xhr.open('GET', `back/vehicles.php?brand=${brand}`, true);
                                
                                xhr.onreadystatechange = function(){
                                    if (this.status === 200 && this.readyState === 4){
                                        
                                        let vehicles = JSON.parse(this.responseText);

                                        let output = "";

                                        output += `<option selected>Open this select menu</option>`;
                                        for (var i in vehicles){
                                            output+= `<option value="${vehicles[i].v_id}">${vehicles[i].v_type}</option>`;
                                        }
                                        
                                        
                                        document.getElementById('vehicle').innerHTML = output;
                                        
                                    }else if(this.status == 404){
                                        console.log('Fail');
                                    }
                                }
                                xhr.send();
                            }
                        </script><br>

                        <button type="submit" class="btn btn-success mb-3" onclick="return confirm('Make this booking?')">Create</button>
                        <a href="read.php" class="btn btn-primary mb-3 float-right" >Cancel</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
    include_once("footer.php");

    if (!empty($sqlErr)){
?>
        <script>
            let error = "<?php echo $sqlErr; ?>";
            alert(error);
        </script>
<?php 
    }
?>