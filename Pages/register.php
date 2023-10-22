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

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($koneksi, $_POST['name']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Periksa apakah email sudah terdaftar
    $cek_user = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email'");
    $cek_login = mysqli_num_rows($cek_user);

    if ($cek_login > 0) {
        echo "<script>
            alert('Email telah terdaftar');
            window.location = 'register.php';
        </script>";
    } else {
        // Simpan data ke dalam tabel "users"
        $query = "INSERT INTO users (fullname, email, password) VALUES ('$name', '$email', '$password')";
        if (mysqli_query($koneksi, $query)) {
            echo "<script>
                alert('Data berhasil didaftarkan');
                window.location = 'login.php';
            </script>";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
    <style>
        html, body {
            margin: 0;
            height: 100%;
        }
        .container {
            width: 100%;
            height: 100%;
            background-color: #012e41;
            display: flex;
        }
        .content-left {
            flex: 1;
        }
        .content-left img {
            height: 100%;
            width: 100%;
            border-top-right-radius: 40px;
            border-bottom-right-radius: 40px;
        }
        .content-left h3 {
            position: absolute;
            font-size: 50px;
            font-family: Arial, Helvetica, sans-serif;
            top: 5px;
            left: 40px;
            color: #fff;
            /* opsional */
            padding: 5px;
            border-radius: 5px;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .left-text {
            position: absolute;
            margin-top: 150px;
            margin-left: 75px;
            font-size: 25px;
            line-height: 1.5;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            color: #fff;
        }
        .content-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .back-button {
            position: absolute;
            color: #fff;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 10px; 
            top: 20px;
            left: 960px;
        }
        .form-container {
            text-align: justify;
            margin: 0 auto; /* untuk memusatkan formulir */
        }
        .form-group {
            margin: 25px 0;
        }
        .form-group input {
            width: 100%;
            padding: 15px; /*lebar box */
        }
        .label {
            color: #696F79;
            font-family: Arial, Helvetica, sans-serif;
        }
        .form-group input,
        .form-group label {
            height: 20px; /*lebar box pt.2*/
            border-radius: 5px;
        }
        /* button { */
            /* background-color: #1565D8; button color */
            /* color: #fff;
            padding: 12px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
        } */
        .button-container {
            text-align: center; 
        }

        button {
            background-color: #1565D8;
            color: #fff;
            padding: 18px; 
            border: none;
            cursor: pointer;
            border-radius: 5px;
            width: 107%; 
            display: block;
        }

        h4 {
            font-family: Arial, Helvetica, sans-serif;
            color: #fff;
            font-size: 35px;
        }

        a {
            text-decoration: none;
        }
        a:hover {
            color: white;
        }
        
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
                Richard Paskah✅
            </div>
            <img src="asset_register/restaurant.jpeg">
        </div>
        <div class="content-right">
            <a href="#" class="back-button">&larr; Back</a>
            <div class="form-container">
                <h4>Register Individual Account!</h4>
                <p style="color: #8692A6; font-size: 22px; font-family: Arial, Helvetica, sans-serif;">
                    For the purpose of industry regulation, your <br />
                    details are required.</p>
                    <form action="register.php" method="post" enctype="multipart/form-data">
                    <label class="label">Your fullname*</label>
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Enter your name" required>
                    </div>
                    <label class="label">Email Address*</label>
                    <div class="form-group">
                        <input type="text" name="email" placeholder="Enter email address" required>
                    </div>
                    <label class="label">Create Password*</label>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Enter Password" required>
                    </div>
                    <p style="color: #8692A6; font-size: 16px; font-family: Arial, Helvetica, sans-serif;">
                        already have account? click <a href="login.php">here</a>
                    </p>
                    <div class="button-container">
                        <button type="submit" name="submit" value="signup">Register Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
