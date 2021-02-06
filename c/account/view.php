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

    $user_id = "";
    if (isset($_GET["id"])){
        $user_id = mysqli_real_escape_string($conn, $_GET["id"]);
    }else{
        exit();
    }

    $sql = "SELECT * FROM tb_user WHERE user_id = ?;";
    
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        $sql_err = "SQL Error";
    }else{
        mysqli_stmt_bind_param($stmt, 'i', $user_id);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result);
    }


?>

<!DOCTYPE html>
<html style="color: rgb(0,0,0);background: rgba(255,255,255,0);">
<style>
    .help-block{color:red;}
</style>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home - CBS</title>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
</head>

<body id="page-top" style="background: #f0f0f0;">
    <h1 class="display-3 text-center text-primary" style="margin-top: 50px;width: auto;font-size: 50px;margin-bottom: 30px;">Profile Edit</h1>
    <div style="height: auto;margin-right: auto;margin-left: auto;">
        <div class="container">

            <form style="margin-bottom: 3px;margin-right: auto;margin-left: auto;width: 90%;"action="profile.php?id=<?php echo $user_id; ?>" enctype="multipart/form-data" method="POST">

                <div class="form-row" style="height: 100%;margin-right: auto;margin-left: auto;margin-bottom: 10px;padding-bottom: 10px;">
                    <div class="col" style="padding-right: 10px;">
                        <div class="card">
                            <div class="card-body">
                                <h3>Personal Information</h3>
                                <div class="form-group" style="padding: 3px;">
                                    <label>Name:</label>
                                    <input class="form-control" type="text" name="name" placeholder="Your Real Name" value="<?php echo $row["name"]; ?>" disabled>
                                </div>

                                <div class="form-group" style="padding: 3px;">
                                    <label>IC Number</label>
                                    <input class="form-control" type="text" name="ic" placeholder="Identification Number(no '-')" minlength="12" maxlength="12" value="<?php echo $row["user_id"]; ?>" disabled>
                                </div>

                                <div class="form-group" style="padding: 3px;">
                                    <label>Home Address</label>
                                    <input class="form-control" type="text" name="address" placeholder="Home Address" value="<?php echo $row["address"]; ?>" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col" style="padding-left: 10px;">
                        <div class="card">
                            <div class="card-body">
                                <h3>Account Information</h3>

                                <div class="form-group" style="padding: 5px;">
                                    <label>Username:</label>
                                    <input class="form-control" type="text" name="username" placeholder="Displayed Name" value="<?php echo $row["username"]; ?>" disabled>
                                </div>

                                <div class="form-group" style="padding: 3px;">
                                    <label>Contact Number</label>
                                    <input class="form-control" type="tel" name="contact" placeholder="Contact Number" minlength="10" maxlength="13" value="<?php echo $row["contact_num"]; ?>" disabled>
                                </div>

                                <div class="form-group" style="padding: 3px;">
                                    <label>Email Address</label>
                                    <input class="form-control" type="email" name="email" placeholder="Email Address" value="<?php echo $row["email"]; ?>" disabled>
                                </div>

                                    
                                <a href="profile.php?id=<?php echo $_SESSION["user_id"]; ?>" class="btn btn-primary">EDIT</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <a class="btn btn-primary btn-lg border rounded-0 d-block" href="../main.php" style="width: 100%;margin: 5px;background: rgb(87,77,76);">Back to Home Page</a>
            </form>

        </div>
    </div>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
    <script src="../assets/js/creative.js"></script>
</body>

</html>

<script>
    var check = function() {
        if (document.getElementById('password').value ==
            document.getElementById('confirm_password').value) {
            document.getElementById('message').style.color = 'green';
            document.getElementById('message').innerHTML = '  (matching)';
        } else {
            document.getElementById('message').style.color = 'red';
            document.getElementById('message').innerHTML = '  (not matching)';
        }
    }

    function myFunction1() 
    {
        var x = document.getElementById("password");
        if (x.type === "password") 
        {
        x.type = "text";
        } 
        else 
        {
        x.type = "password";
        }
    }
    function myFunction2() 
    {
        var x = document.getElementById("confirm_password");
        if (x.type === "password") 
        {
        x.type = "text";
        } 
        else 
        {
        x.type = "password";
        }
    }
</script>