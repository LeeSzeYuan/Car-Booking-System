<?php
    $message = "";
    //Start session
    session_start();

    //connect DB connection
    include ("dbconfig.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        
        if(!empty($_POST["remember"]))
        {
            setcookie("username",$_POST["username"], time()+(10*24*60*60));
            setcookie("password",$_POST["password"], time()+(10*24*60*60));
        }
        else
        {
            if (isset($_COOKIE["username"])) {
                setcookie("username","");
            }
            if (isset($_COOKIE["password"])) {
                setcookie("password","");
            }
        }
        // header("location: login.php");


    $username = $_POST['username'];
    $password = $_POST['password'];


    if (!empty($username) || !empty($password)) 
    {
            $result;
            $sql = "SELECT * FROM tb_user WHERE user_id = ? ;";

            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)){
                $sql_err = "SQL Error";
                echo $sql_err;
            }else{
                mysqli_stmt_bind_param($stmt, "s", $username);
    
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
            }

            if(mysqli_num_rows($result) == 1)
            {
                while ($row = mysqli_fetch_assoc($result)) 
                {
                    if (password_verify($password, $row['password'])||($password == $row['password'])) 
                    {
                        //Set session 
                        $_SESSION['id'] = session_id();// set session id
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['usertype'] = $row['usertype'];

                        if($row['usertype']=='A') //Admin
                        {
                            header("location: a/brand/read.php");
                        }else{
                            header("location: c/main.php");
                        }
                    }
                    else
                    {
                        echo "Username or Password is invalid";
                        $message = "Username or Password is invalid";
                    }    
                }
            }
            else
            {
                echo "No user found.";
                $message = "No user found.";
            } 
        }
        else
        {
            echo'User not found. Please enter correct IC number and password.';
            $message = "User not found. Please enter correct IC number and password.";
            // header("refresh: 5; location: login.php");
        }
    }
?>


