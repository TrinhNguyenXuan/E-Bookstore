<?php
    require_once './DB/db.php';
    session_start();
    if(!isset($_SESSION['user'])) header('Location: ./login')
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/8b076892ac.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <title>Document</title>
    <link rel="stylesheet" href="./CSS/global.css">
    <link rel="stylesheet" href="./CSS/cart.css">
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
            <div class="list-book">
                <?php 
                    $query = 'SELECT * FROM cart WHERE cusId='. $_SESSION['user'];
                    $carts = $conn->query($query);
                    $total =0;
                    while($cart = mysqli_fetch_assoc($carts))
                    {
                        $query = 'SELECT * FROM book WHERE id=' .$cart['bookId'];
                        $books = $conn->query($query);
                        $book = mysqli_fetch_assoc($books);
                        echo '<div class="book">
                            <img src="' .$book["img"]. '" >
                            <p class="title">' .$book["title"]. '</p>
                            <p class="price">' .$book["price"]. '$</p>
                            <p class="quantity" id="book' .$cart['bookId']. '">Số lượng: ' .$cart['quantity']. '</p>
                            <div class="add-sub">
                                <button onclick="add('.$cart['bookId'].')">+</button>
                                <button onclick="sub('.$cart['bookId'].')">-</button>
                            </div>
                            <button class="del-btn" onclick="delBook(' .$cart['bookId']. ')">Xóa</button>
                        </div>';

                        $total += $book['price']*$cart['quantity'];
                    }
                ?>
            </div>
            <div class="cash">
                <h1>Tổng cộng: <?php echo '<span id="total">' .$total. '</span>' ?>$</h1>
                <button class="cash-btn" onclick="payment()">Thanh toán</button>
            </div>
        </div>

        <div class="footer">
            <h3>@Copyright by NguyenXuanTrinh (deptrai) 2023</h3>
        </div>
    </div>
    <!-- <script src="./JS/data.js" type="module"></script> -->
    <!-- <script src="./JS/cart.js"></script> -->
    <script>
            function payment(){
                var total = $('#total').text();
                if(total == '0') alert('Giỏ hàng trống.')
                else{
                    if(confirm('Xác nhận thanh toán')){
                        $.ajax({
                            url: 'http://localhost/customer/ajax/payment.php',
                            method: 'POST',
                            success: function(response){
                                window.location.href = "./pay_success.php"
                            },
                            error: function(e){
                                console.log(e.message)
                                throw e
                            }
                        })
                    }
                }
            }
    
            function add(id){
                $.ajax({
                    url: 'http://localhost/customer/ajax/changeNumBook.php?method=add',
                    method: 'POST',
                    dataType: "json",
                    data: {
                        bookId: id
                    },
                    success: function(response){
                        var cssSelector = '#book'+id
                        $(cssSelector).text('Số lượng: '+response.quantity)
                        
                        var total = $('#total').text();
                        newTotal = parseInt(total) + parseInt(response.price)
                        $('#total').text(newTotal)
                    },
                    error: function(e){
                        console.log(e.message)
                        throw e
                    }
                })
            }

            function sub(id){
                $.ajax({
                    url: 'http://localhost/customer/ajax/changeNumBook.php?method=sub',
                    method: 'POST',
                    dataType: "json",
                    data: {
                        bookId: id
                    },
                    success: function(response){
                        var cssSelector = '#book'+id
                        $(cssSelector).text('Số lượng: '+response.quantity)
                        
                        var total = $('#total').text();
                        if(!response.negative) newTotal = parseInt(total) - parseInt(response.price)
                        $('#total').text(newTotal)
                    },
                    error: function(e){
                        console.log(e.message)
                        throw e
                    }
                })
            }
            
            function delBook(id){
                $.ajax({
                    url: 'http://localhost/customer/ajax/delBook.php',
                    method: 'POST',
                    data: {
                        bookId: id
                    },
                    success: function(response){
                        window.location.reload()
                    },
                    error: function(e){
                        console.log(e.message)
                        throw e
                    }
                })
            }
    </script>
</body>
</html>

<?php 
    mysqli_close($conn)
?>