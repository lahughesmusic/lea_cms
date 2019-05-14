<?php ob_start(); ?>
<?php session_start(); ?>
<?php include "includes/db.php";

/*
$cols = query('SELECT COLUMNS FROM table');
foreach ($cols as $col) {
    $name_parts = explode('_', $col);
    author_str
    id_int
    rate_float
    ['author', 'str']
    authorStr
            
}
*/
$gotPost = false;
if (isset($_GET['post_id'])){
    $post_id = (int)$_GET['post_id'];
    $safe_query = $ezdb->safe_query("SELECT post_content, post_title FROM posts WHERE post_id=?", $post_id);
    $row = $ezdb->get_row($safe_query);
    if ($row) {
        $gotPost = true;
    }
}       
    if (!$gotPost){
            echo "No Result";
    } else {
        

?>

<!DOCTYPE html>
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
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">                                    
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">About</a>
                    </li>
                    <li>
                        <a href="#">Services</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                </ul>
            </div>            
        </div>        
    </nav>

    <!-- Page Content -->
    <div class="container">
        <div class="row">                        
         <div class="col-md-8">
<!--         order the post in descending order by date-->
            <?php
                global $ezdb;

                $safe_query = $ezdb->safe_query("SELECT post_id, post_title, post_author, post_date, post_content, post_image FROM posts WHERE post_id=?", $post_id);
                $row = $ezdb->get_row($safe_query);
                $post_title = $row->post_title;
                $post_author = $row->post_author;
                $post_content = $row->post_content;
                $post_image = $row->post_image;
                $post_date = $row->post_date; 
           ?>
        </div>           

                <!-- Title -->
                
                <h1 class="lead"><?php echo $row->post_title; ?></h1>
                <p class="lead">
                    by <a href="#"><?php echo $row->post_author; ?></a>
                </p>
                <hr>                 
                <p><span class="glyphicon glyphicon-time"></span><?php echo $row->post_date; ?></p>
                <hr>                 
                <img class="img-responsive" src="http://placehold.it/900x300" alt="">
                <hr>
                <p class="lead"><?php echo $row->post_content; ?></p>          
                <hr>

                <div class="well">
                    <h4>Leave a Comment:</h4>
                    

                <?php 
                global $ezdb;

                if (isset($_POST['submit'])) {
                    $comment = $_POST['comment'];
                    $comment_author = $_POST['comment_author'];
                    $remote_ip = $_SERVER['REMOTE_ADDR'];
                    
                   
                   
                    $safe_query = $ezdb->safe_query("INSERT INTO comments (post_title, comment, comment_author, post_id, comment_date, user_ip) VALUES (?, ?, ?, ?, NOW(), ?)", $post_title, $comment, $comment_author, $post_id, $remote_ip);                                                
                                                                   
                    $resultComment = $ezdb->query($safe_query);
                }

                if (isset($_SESSION['logged_in'])) {
                ?>
                    
<!--                    COMMENT                    -->
                <form action="post.php?post_id=<?php echo $post_id; ?>" method="post" role="form">
                    <label>Name: </label>
                    <input type="text" name="comment_author">
                    <div class="form-group">
                        <textarea class="form-control" name="comment" rows="3"></textarea>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </form>
                <?php } else { ?>
                <a href="login.php">Click here to login</a>
                <?php }?>
                </div>
                <hr>                 
<!--                 Comment -->
<?php 
global $ezdb;
        
                $post_id = (int)$_GET['post_id'];
                $find_comment_query = $ezdb->safe_query("SELECT comment_author, comment, DATE_FORMAT(comment_date, ?) AS formatted_date, DATE_FORMAT(comment_date, ?) AS formatted_time FROM comments WHERE post_id=? ORDER BY comment_date DESC", '%c/%e/%Y %H:%i %p', '%H:%i %p', $post_id);
                $rows = $ezdb->get_results($find_comment_query);

                if (is_array($rows)) {                
                foreach ($rows as $row) {
                    list($this_date, $this_time) = explode(" ", $row->formatted_date);
                    echo $this_date;
                ?>

                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $row->comment_author; ?>
                            <small><em><?php echo $this_time; ?></em> <?php echo $this_date; ?> </small>
                        </h4>
                        <p><?php echo $row->comment; ?> </p>                       
                    </div>
                </div>                
<?php } } ?>
            </div>
    </div>

<!--             Blog Sidebar Widgets Column 
            <div class="col-md-4">

                 Blog Search Well 
                <div class="well">
                    <h4>Blog Search</h4>
                    <div class="input-group">
                        <input type="text" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                     /.input-group 
                </div>-->

<!--                 Blog Categories Well 
                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                     /.row 
                </div>

                 Side Widget Well 
                <div class="well">
                    <h4>Side Widget Well</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
                </div>

            </div>

        </div>
         /.row 

        <hr>

         Footer 
-->        <footer>
            <div class="row">
                <div class="col-lg-12">                  
                </div>
            </div>          
        </footer>            
    <script src="js/jquery.js"></script>   
    <script src="js/bootstrap.min.js"></script>

</body>

</html>

<?php }