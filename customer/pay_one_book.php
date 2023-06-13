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
                    $total = 0;
                    if(isset($_GET['bookId']))
                    {
                        $query = 'SELECT * FROM book WHERE id=' .$_GET['bookId'];
                        $books = $conn->query($query);
                        $book = mysqli_fetch_assoc($books);
                        echo '<div class="book">';
                        echo '<img src="data:image/jpg;base64, ' .base64_encode($book["img"]). '" >';                        
                        echo '<p class="title">' .$book["title"]. '</p>
                            <p class="price">' .$book["price"]. '$</p>
                            <p class="quantity" id="book' .$_GET['bookId']. '">Số lượng: <span id="quantity">1</span></p>
                            <div class="add-sub">
                                <button onclick="add('.$book["price"].')">+</button>
                                <button onclick="sub('.$book["price"].')">-</button>
                            </div>
                            <button class="del-btn" onclick="delBook(' .$_GET['bookId']. ')">Xóa</button>
                        </div>';
                        $total = $book["price"];
                    }

                ?>
            </div>
            <div class="cash">
                <h1>Tổng cộng: <span id="total"><?php echo $total ?></span>$</h1>
                <button class="cash-btn" onclick="payment(
                    <?php 
                        if(isset($_SESSION['user'])) echo 1;
                        else echo 0;
                    ?>
                )">Thanh toán</button>
            </div>
        </div>

        <?php 
            require './component/footer.php'
        ?>
    </div>
    <!-- <script src="./JS/data.js" type="module"></script>
    <script src="./JS/pay_one_book.js" type="module"></script> -->
    <script>
        var num=1;

        function payment(login){
            if(login==0)
            {
                alert('Vui lòng đăng nhập để mua hàng')
                window.location.href = './login.php'
            }
            else{
                var total = $('#total').text()
                if(total == '0')
                {
                    alert('Giỏ hàng trống')
                    return
                }
                var confirm = window.confirm("Hãy xác nhận thanh toán")
                if(confirm){
                    window.location.replace('./pay_success.php')
                }

            }
        }

        function delBook(){
            window.location.href = "http://localhost/customer/pay_one_book.php"
        }

        function add(price){
            num +=1
            $('#quantity').text(num)
            var total = price*num
            $('#total').text(total)
        }

        function sub(price){
            if(num==1) return
            num -=1
            $('#quantity').text(num)
            var total = price*num
            $('#total').text(total)
        }
    </script>
</body>
</html>

<?php 
    mysqli_close($conn)
?>