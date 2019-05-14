<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>

<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>
<?php require_once "includes/db.php"; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

<!--         order the post in descending order by date-->
            <?php
        

                $safe_query = $ezdb->safe_query("SELECT post_id, post_title, post_author, post_date, post_content, post_image FROM posts ORDER BY                post_date DESC");
                $rows = $ezdb->get_results($safe_query);
                foreach ($rows as $row) {
                        ?>   

            <h2>
                <a href="post.php?post_id=<?php echo $row->post_id; ?>"><?php echo $row->post_title; ?> </a>
            </h2>
            <p class="lead">
                by <a href="index.php"><?php echo $row->post_author; ?></a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> <?php echo $row->post_date; ?> </p>
            <p> <?php echo $row->post_content; ?> </p>
            <hr>
            <img class="img-responsive" src="images/bark.jpeg<?php 
            echo $row->post_image; ?>" alt="">
            <hr>

            <a class="btn btn-primary" href="post.php?post_id=<?php echo $row->post_id; ?>">Read More <span
                    class="glyphicon glyphicon-chevron-right"></span></a>

            <hr>
            <?php } ?>
        </div>

        <?php include "includes/sidebar.php"; ?>
    </div>

</div>
<!-- /.row -->

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