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
        <div class="alert">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
            Thêm vào giỏ hàng thành công.
        </div>
        <?php require './component/header.php' ?>
        <div class="main">
            <div class="picture">
                <?php
                    echo '<img src="data:image/jpg;base64, ' .base64_encode($row["img"]). '" >';
                ?>
            </div>
            <div class="info">
                <div class="main-info">
                    <?php 
                        echo '<h1>' .$row["title"]. '</h1>';
                        echo '<p>' .$row["price"]. '$</p>';                    
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
            <div class="description">
                <h1>Mô tả sản phẩm</h1>
                <?php 
                    echo $row['description'];
                ?>
            </div>

            <div class="evaluations">
                <h1>Bình luận</h1>
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
        <?php require './component/footer.php' ?>
    </div>

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
            noti.style.position = "fixed"
            setTimeout(()=>{
                noti.style.display = "none"
            },3000)
        }

        function rating(value){
            for(let i=1; i<=5; i++){
                var star = '#rated-star'+i
                if(i<=value){
                    if(!$(star).hasClass('checked')) {
                        $(star).addClass('checked')
                    }
                }
                else
                {
                    if($(star).hasClass('checked')) {
                        $(star).removeClass('checked')
                    }                    
                }
            }
        }

        $("#evaluate-form").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: 'http://localhost/customer/ajax/evaluate.php?bookId=<?php echo $id ?>',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response){
                    if(response == "Success!"){
                        location.reload();
                    }
                },
                error: function(e){
                    console.log(e.message)
                    throw e;
                }
            })
        })
    </script>
</body>
</html>