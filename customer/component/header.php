<?php
    if(isset($_SESSION["user"])) {
        $cusId = $_SESSION["user"];
        $query = "SELECT * FROM cart WHERE cusId=$cusId";
        $hresult = $conn->query($query);
        $hrow = mysqli_fetch_all($hresult);
        $num = count($hrow);
    };
?>

<div class="header">
            <div class="wrap-head-el">
                <a href="./index.php">
                    <img src="./assets/logo.svg" alt="logo" id="logo-shop" width="200" height="100">
                </a>
                <div class="tools">
                    <input type="text" id="searching" onkeyup="filterBook()">
                    <?php 
                        if(!empty($_SESSION['user'])){
                            echo '<a href="./cart.php"><i class="fa-solid fa-cart-shopping fa-xl" id="logo-cart"></i><span>' .$num. '</span></a>';
                            echo '<a href="./logout.php"><i class="fa-solid fa-right-from-bracket fa-xl"></i></a>';
                        }
                        else{
                            echo '<a href="./login.php">Login</a>';
                        }
                        
                        
                    ?>                  
                </div>
            </div>
        </div>