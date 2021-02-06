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

    include("contact/contactpro.php");
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
        <h1 style="color: rgb(255,255,255);text-align: center;">Contact Us</h1>
        <form style="padding: auto;padding-right: auto;padding-left: auto;padding-top: 30px;width: auto;margin: auto;" action="contactus.php" method="POST">
            
            <input class="form-control" type="text" style="text-shadow: 0px 0px var(--danger);width: auto;margin: auto;margin-bottom: 30px;border-style: none;max-width: 700px;min-width: 40%;padding: auto;padding-right: auto;padding-left: auto;margin-left: auto;" name="name" placeholder="Your Name" required>
            
            <input class="form-control" type="text" style="margin: auto;margin-bottom: 30px;width: auto;margin-right: auto;margin-left: auto;padding: auto;padding-right: auto;padding-left: auto;min-width: 40%;" name="email" placeholder="Your Email Address" inputmode="email" required>
            
            <input class="form-control" type="text" style="margin-bottom: 30px;width: auto;margin-right: auto;margin-left: auto;padding-bottom: 90px;min-width: 40%;" placeholder="Your Message" name="question" required>
            
            <input class="btn btn-primary border rounded d-block" type="submit" value="SEND!" style="margin-left: auto;margin-right: auto;width: 230px;" onclick="return alert('Your Message is Received!');">
        
        </form>
    </section>


</body>

</html>
<?php 
    include_once("footer.php");
?>