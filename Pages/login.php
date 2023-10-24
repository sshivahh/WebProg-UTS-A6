<?php
session_start();

$hostname = "localhost";
$user = "root";
$pass = "";
$db_name = "database_webprog_lec";

$koneksi = mysqli_connect($hostname, $user, $pass, $db_name) or die(mysqli_error($koneksi));



if (isset($_POST['submit'])) {
    $captchaString = $_GET['captcha'];
    $captchaInput = $_POST['captcha-input'];
    
    $email= mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $temp = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email'");
    $data = mysqli_fetch_assoc($temp);

    $cek_user = password_verify($password, $data['password']);

    if(mysqli_num_rows($temp) > 0 && $cek_user && $captchaString == $captchaInput) {
        //determine whether to assign as user or admin
        if($email == "admin@gmail.com"){
            $_SESSION['admin']['name'] = "Admin";
        }
        else{
            $_SESSION['user']['name'] = $data['fullname'];
            $_SESSION['user']['id'] = $data['id'];
        }
        header("Location: home.php");
    } else {
        echo "<script>
            alert('Email, password, atau captcha salah'); 
            window.location = 'login.php';
        </script>";
    }
}

function generateRandomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    
    return $randomString;
}

$randomString = generateRandomString();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./../Styles/register.css">
</head>
    <style>

        /*responsif*/
        /* @media screen and (max-width: 768px) {
            .container {
                flex-direction: column;
                text-align: center;
            }
            .content-left h3 {
                position: static;
                margin: 20px 0;
            }
            .left-text {
                margin: 20px 0;
                margin-left: 0;
            }
            .form-container {
                padding: 20px;
            }
        } */

        /*mobile nya*/
        /* @media screen and (max-width: 480px) {
            .content-left h3 {
                font-size: 1.5rem;
            }

            .left-text {
                font-size: 0.9rem;
            }

            .form-group input {
                padding: 5px;
                height: 1.8rem;
            }

            button {
                padding: 8px 16px;
            }
        } */

    </style>
</head>
<body>
    <div class="container">
        <div class="content-left">
            <h3>IF330-A6</h3>
            <div class="left-text">
                Our illustrious establishment, dating back to the <br />
                glamorous era of the 1990s, has been a beacon <br />
                of culinary excellence and refinement. With an <br />
                enduring legacy of sophistication and innovation, <br />
                we have consistently captivated the palates of <br />
                discerning connoisseurs. Nestled in the heart of <br />
                our enchanting city, our restaurant stands as a <br />
                testament to timeless elegance and epicurean <br />
                mastery. <br />
                Richard Paskah
            </div>
            <img src="./../Src/Backgrounds/resto.png">
        </div>
        <div class="content-right">
            <a href="register.php" class="back-button">&larr; Register</a>
            <div class="form-container">
                <h4>Log In</h4>
                <p style="color: #8692A6; font-size: 16px; font-family: Arial, Helvetica, sans-serif;">
                    To begin this journey, let's go login first.</p>
                    <form action="login.php?captcha=<?= $randomString;?>" method="post" enctype="multipart/form-data">
                    <?php
                    if (!empty($err)) {
                        echo "<p style='color: red;'>$err</p>";
                    }
                    ?>
                    <label class="label">Email Address</label>
                    <div class="form-group">
                        <input type="text" name="email" placeholder="Enter email address" required>
                    </div>
                    <label class="label">Password</label>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Enter Password" required>
                    </div>
                    <label class="label" for="">Captcha</label>
                    <div class="form-group">
                        <p class="captcha"><?= $randomString;?></p>
                        <input type="text" name="captcha-input" placeholder="Enter captcha" required>
                    </div>  
                    <div class="button-container">
                        <button type="submit" name="submit" value="signin">Continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
