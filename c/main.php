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
    <title>Home - CBS</title>
</head>

<body id="page-top">

    <header class="masthead text-center text-white d-flex" style="background-image:url('assets/img/header.jpg');">
        <div class="container my-auto">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <h1 class="text-uppercase"><strong>Your TRUSTABLE, FAVOURITE CAR BOOKING WEBSITE</strong></h1>
                    <hr>
                </div>
            </div>
            <div class="col-lg-8 mx-auto">
                <p class="text-faded mb-5">We may not have the car you are looking for, but we have the service you need</p><a class="btn btn-primary btn-xl" role="button" href="account/registration.php">Sign UP now!</a>
            </div>
        </div>
    </header>

    <section id="about" class="bg-primary">
        <div class="container">
            <div class="row">
                <div class="col offset-lg-8 mx-auto text-center">
                    <h2 class="text-white section-heading">We've got what you need!</h2>
                    <hr class="light my-4">
                    <p class="text-faded mb-4">Worry about bad car? Worry about car Insurance? Worry about bad car rental agent? Worry about troublesome booking process? Dont Worry! We got your back!</p><a class="btn btn-light btn-xl js-scroll-trigger" role="button" href="carlist.php">CLICK HERE</a>
                </div>
            </div>
        </div>
    </section>

    <section id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">At Your Service</h2>
                    <hr class="my-4">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-3 text-center">
                    <div class="mx-auto service-box mt-5"><i class="fa fa-diamond fa-4x text-primary mb-3 sr-icons" data-aos="zoom-in" data-aos-duration="200" data-aos-once="true"></i>
                        <h3 class="mb-3">Good Car</h3>
                        <p class="text-muted mb-0">We service our car constantly</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 text-center">
                    <div class="mx-auto service-box mt-5"><i class="fa fa-paper-plane fa-4x text-primary mb-3 sr-icons" data-aos="zoom-in" data-aos-duration="200" data-aos-delay="200" data-aos-once="true"></i>
                        <h3 class="mb-3">Fast Approval</h3>
                        <p class="text-muted mb-0">Your Booking will be confirmed within 10 mins!</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 text-center">
                    <div class="mx-auto service-box mt-5"><i class="fa fa-newspaper-o fa-4x text-primary mb-3 sr-icons" data-aos="zoom-in" data-aos-duration="200" data-aos-delay="400" data-aos-once="true"></i>
                        <h3 class="mb-3">Up to Date</h3>
                        <p class="text-muted mb-0">We will keep you inform our latest deals!</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 text-center">
                    <div class="mx-auto service-box mt-5"><i class="fa fa-heart fa-4x text-primary mb-3 sr-icons" data-aos="fade" data-aos-duration="200" data-aos-delay="600" data-aos-once="true"></i>
                        <h3 class="mb-3">Professional</h3>
                        <p class="text-muted mb-0">Our staffs are trained professionally</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="portfolio" class="p-0">
        <div class="container-fluid p-0">
            <div class="row no-gutters popup-gallery">
                <div class="col-sm-6 col-lg-4"><a class="portfolio-box" href="assets/img/1.jpg"><img class="img-fluid" src="assets/img/1.jpg"></a></div>
                <div class="col-sm-6 col-lg-4"><a class="portfolio-box" href="assets/img/2.jpg"><img class="img-fluid" src="assets/img/2.jpg"></a></div>
                <div class="col-sm-6 col-lg-4"><a class="portfolio-box" href="assets/img/3.jpg"><img class="img-fluid" src="assets/img/3.jpg"></a></div>
                <div class="col-sm-6 col-lg-4"><a class="portfolio-box" href="assets/img/4.jpg"><img class="img-fluid" src="assets/img/4.jpg"></a></div>
                <div class="col-sm-6 col-lg-4"><a class="portfolio-box" href="assets/img/5.jpg"><img class="img-fluid" src="assets/img/5.jpg"></a></div>
                <div class="col-sm-6 col-lg-4"><a class="portfolio-box" href="assets/img/6.jpg"><img class="img-fluid" src="assets/img/6.jpg"></a></div>
            </div>
        </div>
    </section>

</body>

</html>

<?php 
    include_once("footer.php");

?>