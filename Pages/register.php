<?php
// $hostname = "localhost";
// $user = "root";
// $password = "";
// $db_name = "database_uts_lec";

// $koneksi = mysqli_connect($hostname, $user, $password, $db_name) or die(mysqli_error($koneksi));

// if (isset($_POST['submit'])) {
//     $name = $_POST['name'];
//     $email = $_POST ['email'];
//     $password = $_POST ['password'];

//     $cek_user = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email'");
//     $cek_login = mysqli_num_rows($cek_user);
    
//     if ($cek_login > 0) {
//         echo "<script>
//             alert('Email telah terdaftar');
//             window.location = 'register.php';
//         </script>";
//     } else {
//         mysqli_query($koneksi, "INSERT INTO users VALUES('', '$name', '$email', '$password')");
//         echo "<script>
//             alert('Data berhasil didaftarkan');
//             window.location = 'login.php';
//         </script>";
//     }
// }

$hostname = "localhost";
$user = "root";
$pass = "";
$db_name = "database_webprog_lec";

$koneksi = mysqli_connect($hostname, $user, $pass, $db_name) or die(mysqli_error($koneksi));

function generateRandomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    
    return $randomString;
}

$randomString = generateRandomString();

// $ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_POSTFIELDS, [
//     'secret' => '6LcuUr4oAAAAAPA-GlqMIzklwWK1V2dfN6Dxntoa',
//     'response' => $_POST['g-recaptcha-response'],
// ]);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// $response = curl_exec($ch);
// $result = json_decode($response);
// return $result->success;

if (isset($_POST['submit'])) {
    //menghindari sql injection
    $name = mysqli_real_escape_string($koneksi, $_POST['name']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = $_POST['password'];

    $captchaString = $_GET['captcha'];
    $captchaInput = $_POST['captcha-input'];

    

    if ($captchaInput == $captchaString) {
        // Periksa apakah email sudah terdaftar
        $cek_user = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email'");
        $cek_login = mysqli_num_rows($cek_user);

        if ($cek_login > 0) {
            echo "<script>
                alert('Email telah terdaftar');
                window.location = 'register.php';
            </script>";
        } else {
            // encrypt password
            $en_pass = password_hash($password, PASSWORD_BCRYPT);
            // simpan data ke dalam tabel "users"
            $query = "INSERT INTO users (fullname, email, password) VALUES ('$name', '$email', '$en_pass')";
            if (mysqli_query($koneksi, $query)) {
                echo "<script>
                    alert('Data berhasil didaftarkan');
                    window.location = 'login.php';
                </script>";
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
            }
        }
    } else {
        echo "<script>
            alert('CAPTCHA verification failed');
            window.location = 'register.php';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="./../Styles/register.css">
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
            <div class="form-container">
                <h4>Register</h4>
                <p style="color: #8692A6; font-size: 16px; font-family: Arial, Helvetica, sans-serif;">
                    For the purpose of industry regulation, your <br />
                    details are required.</p>
                    <form action="register.php?captcha=<?= $randomString;?>" method="post" enctype="multipart/form-data">
                    <label class="label">Full Name</label>
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Enter your name" required>
                    </div>
                    <label class="label">Email Address</label>
                    <div class="form-group">
                        <input type="text" name="email" placeholder="Enter email address" required>
                    </div>
                    <label class="label">Create Password</label>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Enter password" required>
                    </div>
                    <label class="label" for="">Captcha</label>
                    <div class="form-group">
                        <p class="captcha"><?= $randomString;?></p>
                        <input type="text" name="captcha-input" placeholder="Enter captcha" required>
                    </div>
                    <br />
                    <div class="button-container">
                        <button type="submit" name="submit" value="signup">Register Account</button>
                    </div>
                </form>
                <p style="color: #8692A6; font-size: 13px; font-family: Arial, Helvetica, sans-serif;">
                    Already have account? <a href="login.php">Log In</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
