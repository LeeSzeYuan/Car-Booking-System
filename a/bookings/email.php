<?php

    use PHPMailer\PHPMailer\PHPMailer;

    function result($email, $username, $status) {
        require_once "PHPMailer/PHPMailer.php";
        require_once "PHPMailer/SMTP.php";
        require_once "PHPMailer/Exception.php";

        $mail = new PHPMailer();

        //SMTP Settings
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "zirconte@gmail.com";
        $mail->Password = 'zircon&Tech!';
        $mail->Port = 587; //587 / 465
        $mail->SMTPSecure = "tls"; //tls / ssl

        //Email Settings
        $mail->isHTML(true);
        $mail->setFrom("zirconte@gmail.com");
        $mail->addAddress($email);

        if ($status == 2){
            $mail->Subject = "Reservation Approved";
            $mail->Body = "Your Reservation is being Approved by our company!";
        }else if ($status == 3){
            $mail->Subject = "Reservation Rejected";
            $mail->Body = "We are very sorry. Your reservation is being rejected";
        }

        if ($mail->send()) {
            $status = "success";
            $response = "Email is sent!";
        } else {
            $status = "failed";
            $response = "Something is wrong: <br><br>" . $mail->ErrorInfo;
        }
        


    }
?> 