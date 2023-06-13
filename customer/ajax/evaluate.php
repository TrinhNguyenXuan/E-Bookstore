<?php 
   include_once '../DB/db.php';
   session_start();

   if(empty($_POST['star'])) exit();

   $rating = $_POST['star'];
   $comment = $_POST['comment'];
   $bookId = $_GET['bookId'];
   $cusId = $_SESSION['user'];


   $query = "INSERT INTO evaluation(rating, comment, cusId, bookId) VALUES 
   ($rating, '$comment', $cusId, $bookId)";
   $conn->query($query);
   echo 'Success!'

?>
