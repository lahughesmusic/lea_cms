<!-- Blog Sidebar Widgets Column -->
<?php include "db.php"?>
<div class="col-md-4">



    <?php 
    // global $ezdb;
    // if(isset($_POST['submit'])){
    //  $search = $_POST['search']; 
    //     echo $search;

    // $safe_query = $ezdb->safe_query('SELECT * FROM posts WHERE post_tags  LIKE ?', "%$search%");
    // $posts = $ezdb->get_results($safe_query);

    // // if(!$safe_search_query){
    // //     die("QUERY FAILED" . mysqli_error($connection));
    // // }

    // // $count = get_result($safe_search_query);
    // if ($posts) {
    //     $safe_query_count = count($posts);
    // } else {
    //     $safe_query_count = 0;
    // }
    
    // $err_str = '';
    // if($safe_query_count == 0){
    //     //echo "<br><h1>NO RESULT</h1>";
    //     $err_str = 'no result';
    // }
    // }
    ?>


    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post">
            <div class="input-group">
                <?php if (isset($err_str) && $err_str != '') { ?>
                <h1 style="text-transform:capitalize;"><?php echo $err_str; ?></h1>
                <?php } ?>
                <input name="search" type="text" class="form-control">

                <span class="input-group-btn">
                    <button class="btn btn-default" name="submit" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
        <!-- search form ->>
    <!/.input-group -->
    </div>

    <?php


     ?>




    <!-- Blog Categories Well -->
    <div class="well">


        <?php
        global $ezdb;
                $safe_query = $ezdb->safe_query("SELECT * FROM categories");
                $select_categories_sidebar = $ezdb->get_results($safe_query, ARRAY_A);

               
        ?>



        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
                    $row = ($select_categories_sidebar);
                 foreach($row as $rows){
                    $cat_title = $rows['cat_title']; //pulling row "cat_title" catergory title, from database
                    echo "<li> <a href='#'>{$cat_title}</a></li>";  
                     }
                     ?>

                    </li>
                </ul>
            </div>






            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php include "includes/widgets.php"; ?>