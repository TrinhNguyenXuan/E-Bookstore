<?php 
    require_once './DB/db.php';
    session_start();
    $query = 'SELECT * FROM book;';
    $result = $conn->query($query);
    $arr = mysqli_fetch_all($result);
    $products = count($arr);
    $product_per_page = 8;
    $number_of_page = ceil($products/$product_per_page);
    if(isset($_GET['page'])){
        $curPage = $_GET['page'];
    }
    else{
        $curPage = 1;
    }

    $offset = ($curPage-1)*$product_per_page;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/8b076892ac.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="./CSS/global.css">
    <link rel="stylesheet" href="./CSS/home.css">
    <title>Document</title>
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
        <div class="alert">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
            Thêm vào giỏ hàng thành công.
        </div>

        <div class="main">
            <?php 
                $query = 'SELECT * FROM book LIMIT ' .$product_per_page. ' OFFSET ' .$offset;
                $result = $conn->query($query);
                while($row = mysqli_fetch_assoc($result))
                {
                    echo '<div class="book">
                        <img src="' .$row["img"]. '" >
                        <p class="title">' .$row["title"]. '</p>
                        <p class="price">' .$row["price"]. '$</p>
                        <div class="btn">
                            <button class="buy-btn" onclick="buyNow(' .$row["id"]. ')"> Buy </button>
                            <button class="add-btn" onclick="addBook(' .$row["id"]. ')"> Add </button>
                        </div>
                    </div>';
                }
            ?>
        </div>
        <div class="pagination">
            <?php 
                if($curPage>1)
                {
                    $prevPage = $curPage -1;
                    echo '<a class="page" href = "./index.php?page=' . $prevPage . '"> < </a>';
                }

                for($page = 1; $page<= $number_of_page; $page++) {  
                    echo '<a class="page" href = "./index.php?page=' . $page . '">' . $page . ' </a>';  
                }

                if($curPage<$number_of_page)
                {
                    $postPage = $curPage+1;
                    echo '<a class="page" href = "./index.php?page=' . $postPage . '"> > </a>';
                }
            ?>
        </div>

        <div class="footer">
            <h3>@Copyright by NguyenXuanTrinh (deptrai) 2023</h3>
        </div>
    </div>
    <!-- <script src="./JS/data.js" type="module"></script> -->
    <!-- <script src="./JS/books.js"></script> -->
    <script src="./JS/filter.js"></script>
    <script>
        function buyNow(value){
            window.location.href = "./pay_one_book.php?bookId=" +value
        }

        function addBook(value){
            $.ajax(
                {
                    url: 'http://localhost/customer/ajax/addBook.php',
                    method: 'POST',
                    data: {
                        bookId: value
                    },
                    success: function(response){
                        if(response == "no login")
                        {
                            alert('Vui lòng đăng nhập để mua hàng')
                            window.location.href = './login.php'
                        }
                        else{
                            notify()
                        }
                    },
                    error: function (e){
                        console.log(e.message);
                        throw e
                    }
                }
            )
        }

        function notify(){
            var noti = document.getElementsByClassName("alert")[0]
            noti.style.display = "block"
            setTimeout(()=>{
                noti.style.display = "none"
            },3000)
        }
    </script>
</body>
</html>

<?php 
    mysqli_close($conn)
?>