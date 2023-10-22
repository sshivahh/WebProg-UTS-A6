<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IF330-A6</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
        }
        .container {
            width: 100%;
            min-height: 100%;
            background-color: #012e41;
            display: flex;
            flex-direction: column;
        }
        .top {
            top: 0;
            position: absolute;
            width: 100%;
            height: 100px;
            background-color: #fff;
            border-radius: 0 0 15px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .text_kiri {
            margin: 0 0 0 53px;
            font-size: 35px;
        }
        .text_kiri .if330 {
            color: #28499F;
            font-family:monospace;
            font-size: 35px;
            font-weight: bold;
        }
        .text_kiri .a6 {
            color: #000;
            font-family: monospace;
            font-size: 35px;
            font-weight: bold;
        }
        .text_kiri a {
            color: none;
            text-decoration: none;
        }
        .text_kiri a:hover {
            text-decoration: underline;
            color: #000;
        }
        .search-bar {
            width: 500px;
            margin-right: -25px;
            height: 50px;
            border-radius: 10px;
            text-align: center;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 18px;
            background: linear-gradient(90deg, rgba(40, 73, 159, 0.18) 0%, rgba(40, 73, 159, 0.18) 100%);
            box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.25);
            border: none;
        }
        .small-box {
            width: 55px;
            height: 53px;
            margin-right: 1050px;
            border-radius: 10px;
            box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.25);
            background: linear-gradient(90deg, rgba(40, 73, 159, 0.18) 0%, rgba(40, 73, 159, 0.18) 100%);
            cursor: pointer;
            transition: transform 0.2s;
        }
        .small-box img {
            margin-left: 9px;
        }
        .text_kanan {
            position: absolute;
            top: 0px;
            right: 20px;
            font-size: 24px;
            color: #000;
            text-align: center;
            margin-right: 20px;
            margin-top: -5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="top">
            <div class="text_kiri">
                <a href="homepage.php">
                    <span class="if330">IF330</span>
                    <span class="a6">-A6</span>
                </a>
            </div>
            <input class="search-bar" type="text" placeholder="Search Menu or Categories..." />
            <div class="small-box" onclick="handleSmallBoxClick()">
                <img src="asset_makanan/Search.png" alt="Cari">
            </div>
            <div class="text_kanan">
                <p>Order#123</p>
                <p style="margin-top: -20px; font-size: 20px;">Opened 21:00</p>
            </div>
        </div>
    </div>

    <script>
        function handleSmallBoxClick() {
            var smallBox = document.querySelector(".small-box");
            smallBox.style.transform = "scale(0.9)"; //ngubah ukuran search
            setTimeout(function () {
                smallBox.style.transform = "scale(1)"; // Mengembalikan ukuran search ke semula
            }, 100); // durasi animasi
        }
    </script>
</body>
</html>
