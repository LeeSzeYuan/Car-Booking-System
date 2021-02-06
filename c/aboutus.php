<?php 
	require_once("../dbconfig.php");
	if(!session_id())//if session_id is not found
	{
		session_start();
	}
	
	if(isset($_SESSION['id']) != session_id() )
	{
		include_once("navbar2.php");
    }else{
        include_once("navbar.php");
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>CBS</title>
</head>

<body id="page-top">
    <section style="background: url(&quot;assets/img/header.jpg&quot;);">
        <h1 class="display-4 text-center d-block" style="color: rgb(0,0,0);">Have a question? Have a testimonial?</h1>
    </section>
    <section style="background: #0e0d0d;">
        <h1 style="color: rgb(255,255,255);text-align: center;">About Us</h1><br>
        <p style="color: rgb(255,255,255);text-align: center;">
            We are a group of people who love car. And want to bring this joy and share it with others!
        </p>
        <p style="color: rgb(255,255,255);text-align: center;">
            We aim to bring you the best rental car services you ever had before! 
        </p>
    </section>


</body>

</html>
<?php 
    include_once("footer.php");
?>