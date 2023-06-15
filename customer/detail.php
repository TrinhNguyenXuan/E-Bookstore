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
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
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
                            if(response == 'new-book'){
                                var num_item = parseInt($('#item-cart').text())
                                num_item+=1;
                                $('#item-cart').text(num_item);
                            }
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

        function selectPhoto(value){
            var id = "#prod-img"+value;
            $(id).css('border','3px solid grey')

            if(value==1){
                $("#prod-img2, #prod-img3").css('border','none')
            }
            else if(value==2){
                $("#prod-img1, #prod-img3").css('border','none')
            }
            else{
                $("#prod-img1, #prod-img2").css('border','none')
            }

            let src = $(id).attr('src')
            $('#main-pic').attr('src',src)
        }

        
        let slideIndex = 0;
        $('.prod-img-plus').click(function(){
            $('.bg-slide').css('display', 'flex')
            $('body').css('overflow', 'hidden')
            $('.slide:eq(0)').css('display', 'block')
            $('.left-slide>i').css('color', 'black')
            $('.right-slide').addClass('enable-hover')

        })

        $('.right-slide:first').click(function(){
            showSlide(1)
        })
        $('.left-slide:first').click(function(){
            showSlide(-1)
        })

        function showSlide(value){
            let curSlide = '.slide:eq(' + slideIndex + ')'
            let temp = slideIndex+1
            let nextSlide = '.slide:eq(' + temp + ')'
            temp = slideIndex-1
            let prevSlide = '.slide:eq(' + temp + ')'
            temp = slideIndex+1+value
            let rightEnable = '.slide:eq(' + temp + ')'
            console.log(rightEnable)

            if(value == 1 && $(nextSlide).length){
                $(curSlide).css('display', 'none')
                $(nextSlide).css('display', 'block')
                slideIndex++;
            }
            else if(value == -1 && $(prevSlide).length && slideIndex>0){
                $(curSlide).css('display', 'none')
                $(prevSlide).css('display', 'block')
                slideIndex--;
            }

            if(slideIndex>0 && !$('.left-slide.enable-hover').length){
                $('.left-slide').addClass('enable-hover')
                $('.left-slide>i').css('color', 'white')
            }
            if(slideIndex==0 && $('.left-slide.enable-hover').length){
                $('.left-slide').removeClass('enable-hover')
                $('.left-slide>i').css('color', 'black')
            }

            if($(rightEnable).length && !$('.right-slide.enable-hover').length)
            {
                $('.right-slide').addClass('enable-hover')
                $('.right-slide>i').css('color', 'white')
            }
            if(!$(rightEnable).length && $('.right-slide.enable-hover').length)
            {
                $('.right-slide').removeClass('enable-hover')
                $('.right-slide>i').css('color', 'black')
            }

        }

        $('.cancel-slide:first').click(function(){
            $('.bg-slide').css('display', 'none')
            $('body').css('overflow', 'scroll')
            let curSlide = '.slide:eq(' + slideIndex + ')'
            $(curSlide).css('display', 'none')
            $('.left-slide>i').css('color', 'black')
            $('.right-slide>i').css('color', 'white')
            if($('.right-slide.enable-hover').length){
                $('.right-slide.enable-hover').removeClass('enable-hover')
            }
            if($('.left-slide.enable-hover').length){
                $('.left-slide.enable-hover').removeClass('enable-hover')
            }
            slideIndex = 0;
        })

        selectPhoto(1);

    </script>
</body>
</html>