<?php 
   include_once '../DB/db.php';
   session_start();

   $data = array();
   $data['success'] = true;

   if(empty($_POST['star'])) {
      $data['success'] = false;
      echo json_encode($data);
      exit();
   };

   $rating = $_POST['star'];
   $comment = $_POST['comment'];
   $bookId = $_GET['bookId'];
   $cusId = $_SESSION['user'];


   $query = "INSERT INTO evaluation(rating, comment, cusId, bookId) VALUES 
   ($rating, '$comment', $cusId, $bookId)";
   $conn->query($query);


   $query = "SELECT * FROM customer WHERE id = $cusId";
   $result = $conn->query($query);
   $user = mysqli_fetch_assoc($result);
   
   $stars = '';
   for($i=1; $i<=5; $i++){
      if($i<=$rating) {
         $stars .= '<i class="fa-solid fa-star fa-xs checked"></i>';
      }
      else $stars .= '<i class="fa-solid fa-star fa-xs"></i>';
      
   }

   $data['element'] = 
   '<div class="user-comment">
      <p>' .$user['name']. '</p>'.
      '<div class="evaluate">'.
      '<div class="user-rating">'
   ;
   $data['element'] .= $stars;
   $data['element'] .= 
   '</div>' . 
   '<div class="comment">' . 
   $comment . 
   '</div>' . 
   '</div>' . 
   '</div>';
   
   $query = "SELECT AVG(rating) as avgRate FROM evaluation WHERE bookId = $bookId;";
   $result = $conn->query($query);
   $avgRating = mysqli_fetch_assoc($result)['avgRate'];
   $data['avgRating'] = round($avgRating,2);
   

   echo json_encode($data);
