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
        $user_id = $_GET["id"];
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


    include_once("passwordpro.php");
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
    <h1 class="display-3 text-center text-primary" style="margin-top: 50px;width: auto;font-size: 50px;margin-bottom: 30px;">Reset Password</h1>
    <div style="height: auto;margin-right: auto;margin-left: auto;">
        <div class="container">

            <form style="margin-bottom: 3px;margin-right: auto;margin-left: auto;width: 90%;" action="password.php?id=<?php echo $user_id; ?>" enctype="multipart/form-data" method="POST">

                <div class="form-row" style="height: 100%;margin-right: auto;margin-left: auto;margin-bottom: 40px;padding-bottom: 40px;">
                    <div class="col" style="padding-left: 10px;">
                        <div class="card">
                            <div class="card-body">

                                <div class="form-group" style="padding: 5px;">
                                    <label>Current Password: </label>
                                    <input class="form-control <?php echo (!empty($currErr)) ? 'is-invalid' : ''; ?>" type="password" name="current" placeholder="Current Password" id="current">
                                    <span class="help-block"><?php echo $currErr;?></span><br>
                                    <input type="checkbox" onclick="myFunction()">&nbspShow Password
                                </div>

                                <br><hr><br>

                                <div class="form-group" style="padding: 5px;">
                                    <label>New Password:</label>
                                    <input class="form-control <?php echo (!empty($passErr)) ? 'is-invalid' : ''; ?>" type="password" name="password"  id="password" placeholder="Password">

                                    <span class="help-block"><?php echo $passErr;?></span><br>
                                    <input type="checkbox" onclick="myFunction1()">&nbspShow Password
                                </div>

                                <div class="form-group" style="padding: 5px;">
                                    <label>Confirm Password:<span id='message'></span></label>
                                    <input class="form-control" type="password" id="confirm_password" name="confirm_password" placeholder="Confrim Password" onkeyup='check();'>
                                    <input type="checkbox" onclick="myFunction2()">&nbspShow Password
                                </div>
                                    
                                <input class="btn btn-primary text-left float-right" type="reset" value="Clear">
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="id" value="<?php echo $user_id;?>">
                
                <input class="btn btn-primary btn-lg border rounded-0 d-block"  type="Submit"  onclick="return confirm('Do you want to save the changes?');" value="Submit" style="width: 100%;margin: 5px;">
                <a class="btn btn-primary btn-lg border rounded-0 d-block" href="../main.php" style="width: 100%;margin: 5px;background: rgb(87,77,76);">Cancel</a>
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

    function myFunction() 
    {
        var x = document.getElementById("current");
        if (x.type === "password") 
        {
        x.type = "text";
        } 
        else 
        {
        x.type = "password";
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