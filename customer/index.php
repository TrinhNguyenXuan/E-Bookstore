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
        <?php 
            require './component/header.php'
        ?>
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
                    echo '<div class="book" onclick="navigate('.$row['id']. ')">
                        <img src="data:image/jpg;base64, ' .base64_encode($row["img"]). '" >
                        <p class="title">' .$row["title"]. '</p>
                        <p class="price">' .$row["price"]. '$</p>
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

        <?php 
            require './component/footer.php'
        ?>
    </div>
    <script src="./JS/filter.js"></script>
    <script>
        function navigate(id){
            window.location.href = "detail.php?id=" + id
        }
    </script>
</body>
</html>

<?php 
    mysqli_close($conn)
?>