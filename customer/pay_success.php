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
        <?php 
            require './component/header.php'
        ?>

        <div class="main">
            <h1>Thanh toán thành công</h1>
        </div>

        <?php
            require './component/footer.php'
        ?>
    </div>
</body>
</html>

<?php 
    mysqli_close($conn)
?>