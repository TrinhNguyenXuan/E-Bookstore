<?php 
    require_once './DB/db.php';
    session_start();
    $id = $_GET['id'];
    $query = "SELECT * FROM book WHERE id = $id;";
    $result = $conn->query($query);
    $row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/8b076892ac.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="./CSS/global.css">
    <link rel="stylesheet" href="./CSS/detail.css">
    <title>Document</title>
</head>
<body>
    <div class="wrapper">
        <div class="bg-slide">
            <div class="wrap-slide">
                <div class="left-slide">
                    <i class="fa-solid fa-arrow-left fa-2xl"></i>
                </div>
                <div class="img-slide">
                    <?php 
                        $query = "SELECT * FROM product_img WHERE bookId = $id";
                        $result2 = $conn->query($query);
                        while($prod_img = mysqli_fetch_assoc($result2)){
                            echo '<img class="slide" src="data:image/jpg;base64, ' .base64_encode($prod_img["img"]). '" alt="">';
                        }
                    ?>
                </div>
                <div class="right-slide">
                    <i class="fa-solid fa-arrow-right fa-2xl"></i>
                </div>
            </div>
            <i class="cancel-slide fa-solid fa-xmark"></i>
        </div>
        <div class="alert">
            <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span> 
            Thêm vào giỏ hàng thành công.
        </div>
        <?php require './component/header.php' ?>
        <div class="main">
            <div class="picture">
                <?php
                    echo '<img id="main-pic" >';
                ?>

                <div class="list-prod-img">
                    <?php 
                        $query = "SELECT * FROM product_img WHERE bookId = $id";
                        $result2 = $conn->query($query);
                        $i = 1;
                        while($prod_img = mysqli_fetch_assoc($result2)){
                            if($i<=3){
                                echo '<img id="prod-img' .$i. '" onclick="selectPhoto(' .$i. ')" class="prod-img" src="data:image/jpg;base64, ' .base64_encode($prod_img["img"]). '" >';
                                $i++;
                            }
                            else
                            {
                                // echo '<img class="prod-img-plus" src="data:image/jpg;base64, ' .base64_encode($prod_img["img"]). '" >';
                                echo '<div class="prod-img-plus"><p>Xem thêm</p></div>';
                                break;
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="info">
                <div class="main-info">
                    <?php 
                        echo '<h1>' .$row["title"]. '</h1>';
                        echo '<p>' .$row["price"]. '$</p>';    
                        $query = "SELECT AVG(rating) as avgRate FROM evaluation WHERE bookId=$id;";
                        $result3 = $conn->query($query);
                        $avgRating = mysqli_fetch_assoc($result3)['avgRate'];

                        $avgRating = round($avgRating,2);
                        echo '<p class="avg-star">' .$avgRating. '<i class="fa-solid fa-star fa-sm"></i></p>';                 
                    ?>
                </div>
                <div class="warranty">
                    <div class="warrant">
                        <i class="fa-regular fa-thumbs-up"></i> <span>Hàng chính hãng 100%</span>
                    </div>
                    <div class="warrant">
                        <i class="fa-solid fa-shield"></i> <span>Bảo hành 1 đổi 1 trong 30 ngày</span>
                    </div>
                    <div class="warrant">
                        <i class="fa-solid fa-truck-fast"></i> <span>Miễn phí chi phí giao hàng</span>
                    </div>
                </div>
                <div class="btn">
                    <?php 
                        echo '<button class="buy-btn" onclick="buyNow(' .$id. ')"> Buy </button>';
                        echo '<button class="add-btn" onclick="addBook(' .$id. ')"> Add </button>'
                    ?>                  
                </div>
            </div>

            <div class="tab-data">
                <div class="tab-list">
                    <button class="tab tab-selected" id="tab1" onclick="handleTab(1)">Mô tả sản phẩm</button>
                    <button class="tab tab-non-selected" id="tab2" onclick="handleTab(2)">Đánh giá</button>
                </div>
                <div class="description">
                    <h1>Mô tả sản phẩm</h1>
                    <?php 
                        echo $row['description'];
                    ?>
                </div>
                <div class="evaluations">
                    <h1>Đánh giá</h1>
                    <div class="write-comment" <?php if(empty($_SESSION['user'])) echo 'style="display: none;"';?>>
                        <form action="" id="evaluate-form">
                            <p>Đánh giá tại đây</p>
                            <div class="stars">
                                <?php 
                                    for($i=1 ; $i<=5; $i++){
                                        echo '<input class="star" id="star-' .$i. '" type="radio" name="star" style="display: none;" value="'.$i.'"/>
                                        <label class="star" for="star-' .$i. '" onclick="rating('.$i.')"><i id="rated-star'.$i.'" class="fa-solid fa-star fa-xl"></i></label>';
                                    }
                                ?>
                            </div>
                            <textarea name="comment" id="" cols="30" rows="10" ></textarea>
                            <button type="submit" class="cmt-btn">Gửi</button>
                        </form>
                    </div>
                    <?php 
                        $query = "SELECT * FROM evaluation WHERE bookId = $id";
                        $result = $conn->query($query);
                        while($row = mysqli_fetch_assoc($result)){
                            $query = "SELECT * FROM customer WHERE id = " .$row["cusId"];
                            $user_result = $conn->query($query);
                            $user = mysqli_fetch_assoc($user_result);
    
                            
    
                            echo '<div class="user-comment">
                                <p>' .$user["name"]. '</p>';
                            echo '<div class="evaluate">';
                                echo '<div class="user-rating">';
                                for($i=1; $i<=5; $i++){
                                    if($i<=$row["rating"]) echo '<i class="fa-solid fa-star fa-xs checked"></i>';
                                    else echo '<i class="fa-solid fa-star fa-xs"></i>';
                                }
                                echo '</div>';
    
                                echo '<div class="comment">';
                                echo $row["comment"];
                                echo '</div>';
                            echo '</div>';
    
    
                            echo '</div>';
                        }
                    ?>
                </div>

            </div>

        </div>
        <?php require './component/footer.php' ?>
    </div>

    <script src="./JS/filter.js"></script>
    <script src="./JS/detail_buy_add.js"></script>
    <script src="./JS/detail_rating.js"></script>
    <script>
        $("#evaluate-form").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: 'http://localhost/customer/ajax/evaluate.php?bookId=<?php echo $id ?>',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    if(response.success){
                        // alert(response.element)
                        updateComment(response);
                    }
                },
                error: function(e){
                    console.log(e.message)
                    throw e;
                }
            })
        })
    </script>
    <script src="./JS/detail_photo.js"></script>
    <script>
        var tabShow = 1;
        function handleTab(value)
        {
            if(tabShow==value) return;

            tabShow=value;
            let tab_select = "#tab"+value
            $('.tab-selected').removeClass('tab-selected').addClass('tab-non-selected')
            $(tab_select).removeClass('tab-non-selected').addClass('tab-selected')

            $('.description, .evaluations').css('display','none')

            switch(value){
                case 1: {
                    $('.description').css('display', 'block')
                    break;
                }
                case 2: {
                    $('.evaluations').css('display', 'block')
                    break;
                }
            }
        }

    </script>
</body>
</html>