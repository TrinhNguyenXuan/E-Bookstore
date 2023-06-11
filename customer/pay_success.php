<?php 
    require_once './DB/db.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/8b076892ac.js" crossorigin="anonymous"></script>
    <title>Document</title>
    <link rel="stylesheet" href="./CSS/global.css">
    <link rel="stylesheet" href="./CSS/payment.css">
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div class="wrap-head-el">
                <a href="./index.php">
                    <img src="./assets/logo.svg" alt="logo" id="logo-shop" width="200" height="100">
                </a>
                <div class="tools">
                    <input type="text" id="searching" onkeyup="filterBook()">
                    <?php 
                        if(!empty($_SESSION['user'])){
                            echo '<a href="./cart.php"><i class="fa-solid fa-cart-shopping fa-xl" id="logo-cart"></i></a>';
                            echo '<a href="./logout.php"><i class="fa-solid fa-right-from-bracket fa-xl"></i></a>';
                        }
                        else{
                            echo '<a href="./login.php">Login</a>';
                        }                     
                    ?>                  
                </div>
            </div>
        </div>

        <div class="main">
            <h1>Thanh toán thành công</h1>
        </div>

        <div class="footer">
            <h3>@Copyright by NguyenXuanTrinh (deptrai) 2023</h3>
        </div>
    </div>
</body>
</html>

<?php 
    mysqli_close($conn)
?>