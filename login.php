<?php 
    require_once("loginpro.php");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home - CBS</title>
    <link rel="stylesheet" href="c/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic">
    <link rel="stylesheet" href="c/assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
</head>

<body id="page-top" style="background: #f0f0f0;">
    

    <section style="background: #f0f0f0;">

        <div class="col-auto align-self-center mx-auto">
                <a class="btn btn-primary active border rounded-0 d-block" role="button" style="width: 40px;min-height: 100%;margin-right: auto;margin-left: 80%;" href="c/main.php"><i class="fa fa-remove"></i></a>
        </div>
        
        <h1 style="color: rgb(240,95,64);text-align: center;width: 100%;min-height: 100%;">Login</h1>
        <span style="color: rgb(240,95,64);text-align: center;width: 100%;min-height: 100%;"><?php echo $message; ?></span>

        <form style="padding: auto;padding-right: auto;padding-left: auto;padding-top: 30px;width: auto;margin: auto;" method="POST" actoon="loginpro.php">
            <input class="form-control" type="text" style="text-shadow: 0px 0px var(--danger);width: auto;margin: auto;margin-bottom: 30px;border-style: none;max-width: 700px;min-width: 300px;padding: auto;padding-right: auto;padding-left: auto;margin-left: auto;" name="username" placeholder="user IC" value="<?php if(isset($_COOKIE["username"])) {echo $_COOKIE["username"];}?>">
            
            <div class="form-group">
                <input class="form-control" type="password" style="margin: auto;margin-bottom: 30px;width: auto;margin-right: auto;margin-left: auto;padding: auto;padding-right: auto;padding-left: auto;min-width: 300px;" name="password" placeholder="Password" id="password" value="<?php if(isset($_COOKIE["password"])) {echo $_COOKIE["password"];}?>">
            </div>

            <div class="form-check text-center" style="margin-right: 10%;margin-left: auto;margin-top: -30px;margin-bottom: 20px;">
                <input class="form-check-input" type="checkbox" id="formCheck-1" onclick="myFunction()">
                <label class="form-check-label" for="formCheck-1" style="font-size: 12px;">Show Password</label>
            </div>

            <div class="form-check text-center" style="margin-right: auto;margin-left: auto;margin-top: 0;margin-bottom: 20px;">
                <input type="checkbox" checked="checked" name="remember" id="remember"<?php if(isset($_COOKIE["username"])) { ?> checked <?php }?>/>
                <label class="form-check-label" for="formCheck-1">Remember Me</label>
            </div>


            <input value="LOGIN!" class="btn btn-primary border rounded d-block" type="submit" style="margin-left: auto;margin-right: auto;width: 300px;margin-bottom: 10px;">
            <a class="text-center d-block" href="c/account/registration.php" style="margin-bottom: 20px;color: rgb(118,180,225);font-family: 'Open Sans', sans-serif;">Don't Have An Account?</a>


            
            <button class="btn btn-primary bg-secondary border rounded d-block" type="button" style="margin-left: auto;margin-right: auto;width: 300px;background: rgb(92,78,75);">FORGET PASSWORD?</button>
        </form>

    </section>
    <script>
        function myFunction() 
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
    </script>

    <script src="c/assets/js/jquery.min.js"></script>
    <script src="c/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
    <script src="c/assets/js/creative.js"></script>
</body>

</html>