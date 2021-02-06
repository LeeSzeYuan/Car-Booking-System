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

        if ($status == 1){
            $mail->Subject = "Account Changes";
            $mail->Body = "Your account has information that is being edited by our company!";
        }else if ($status == 2){
            $mail->Subject = "Account Deleted";
            $mail->Body = "We are very sorry. Your user account is being deleted";
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