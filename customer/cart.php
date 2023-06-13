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
        <?php 
            require './component/header.php'
        ?>

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
                        echo '<div class="book">';
                        echo '<img src="data:image/jpg;base64, ' .base64_encode($book["img"]). '" >';
                        echo '
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

        <?php 
            require './component/footer.php'
        ?>
    </div>
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