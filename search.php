<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>
<?php require_once "includes/db.php"; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">


            <?php
//  if(isset($_POST['submit'])){
//     $search = $_POST['search']; 
//        echo $search;

//    $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%' ";
//    $search_query = mysqli_query($connection, $query);

//    if(!$search_query){
//        die("QUERY FAILED" . mysqli_error($connection));
//    }
//    $count = mysqli_num_rows($search_query);
//    if($count == 0){
//        echo "<br><h1>NO RESULT</h1>";
//    }else{
//        while($row = mysqli_fetch_assoc($search_query)){
//             $post_title = $row['post_title'];
//             $post_author = $row['post_author'];
//             $post_date = $row['post_date'];
//             $post_image= $row['post_image'];
//             $post_content = $row['post_content'];
//        }
     
//    } 

global $ezdb;
if(isset($_POST['submit'])){
 $search = $_POST['search']; 
    echo $search;

$safe_query = $ezdb->safe_query('SELECT * FROM posts WHERE post_tags LIKE ? OR post_content LIKE ?', "%$search%", "%$search%");
//$safe_query = $ezdb->safe_query('SELECT post_title, cat_title, post_content FROM posts LEFT JOIN categories ON categories.cat_id=posts.cat_id  WHERE post_tags LIKE ? OR post_content LIKE ?', "%$search%", "%$search%");
$posts = $ezdb->get_results($safe_query, ARRAY_A);

// if(!$safe_search_query){
//     die("QUERY FAILED" . mysqli_error($connection));
// }

// $count = get_result($safe_search_query);
if ($posts) {
    $safe_query_count = count($posts);
    
} else {
    $safe_query_count = 0;
}

$err_str = '';
if($safe_query_count == 0){
    //echo "<br><h1>NO RESULT</h1>";
    $err_str = 'no result';
}else{
    foreach ($posts as $row){
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $post_image= $row['post_image'];
                $post_content = $row['post_content'];
    }


?>

            <h2>
                <a href="#"><?php echo $post_title ?> </a>
            </h2>
            <p class="lead">
                by <a href="index.php"><?php echo $post_author ?></a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?> </p>
            <p> <?php echo $post_content ?> </p>
            <hr>
            <img class="img-responsive" src="images/<?php 
echo $post_image; ?>" alt="">
            <hr>

            <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

            <hr>
            <?php  }} ?>








            <!-- <h1 class="page-header">
                Page Heading
                <small>Secondary Text</small>
            </h1> -->





        </div>

        <?php include "includes/sidebar.php"; ?>
    </div>

</div>


<hr>



</div>
<!-- /.container -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>
<?php "includes/footer.php" ?>