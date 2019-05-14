<?php include "../includes/db.php" ?>
<?php

session_start();
if(!isset($_SESSION['username'])){
   header("Location:Login.php");
}
?><!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Blog Post - Start Bootstrap Template</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/blog-post.css" rel="stylesheet">

</head>

<body>
<?php
    $safe_query = $ezdb->safe_query("SELECT post_title, post_author, post_date FROM posts ORDER BY post_id DESC LIMIT 25");
    $rows = $ezdb->get_results($safe_query);
        
    foreach ($rows as $row){
?>
    <div class="container">
           <div class="row">                        
            <div class="col-md-8">
                 <h1 style='margin-top: 10%'><?php echo $row->post_title; ?></h1>
                   <p class="lead">
                       by <a href="#"><?php echo $row->post_author; ?></a>
                   </p>
                   <hr>                 
                   <p><span class="glyphicon glyphicon-time"></span><?php echo $row->post_date; ?></p>
                   <hr>                 
                   <img class="img-responsive" src="http://placehold.it/900x300" alt="">
                   <hr>                                              
            </div>
           </div>
    </div>
    <?php } ?>
</body>
</html>
        
       