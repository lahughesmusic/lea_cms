<?php session_start();
if(!isset($_SESSION['username'])){
   header("Location:../login.php");
}
?>

<?php include "../includes/db.php" ?>
<?php include "includes/function.php" ?>
<?php include "includes/admin_navigation.php" ?>
<!DOCTYPE html>
<title>Comments</title>
    
<body>
    <div>  
        <?php include "includes/admin_header.php" ?>
    </div>

    <?php
    /*
        $safe_query = $ezdb->safe_query("SELECT post_id, post_title FROM posts");
        $post_rows = $ezdb->get_results($safe_query);
        foreach ($post_rows as $row) {
            $posts[$row->post_id] = $row->post_title;
        }
        unset($post_rows);
     */
        //$safe_query = $ezdb->safe_query("SELECT post_id, comment_author, comment, DATE_FORMAT(comment_date, ?) AS formatted_date, DATE_FORMAT(comment_date, ?) AS formatted_time FROM comments ORDER BY comment_date DESC", '%c/%e/%Y %H:%i %p', '%H:%i %p');
        $safe_query = $ezdb->safe_query("SELECT comments.post_id, post_title, comment_author, comment, DATE_FORMAT(comment_date, ?) AS formatted_date, DATE_FORMAT(comment_date, ?) AS formatted_time FROM comments LEFT JOIN posts ON posts.post_id=comments.post_id ORDER BY comment_date DESC", '%c/%e/%Y %H:%i %p', '%H:%i %p');        
        
        $comments = $ezdb->get_results($safe_query);
        
        //$safe_query = 
              
            
        //    $find_comment_query = $ezdb->safe_query("SELECT post_title, comment_author, comment, DATE_FORMAT(comment_date, ?) AS formatted_date, DATE_FORMAT(comment_date, ?) AS formatted_time FROM comments ORDER BY comment_date DESC", '%c/%e/%Y %H:%i %p', '%H:%i %p');
                                                                                           
            //$rows = $ezdb->get_results($find_comment_query);                

            if (is_array($comments)) {                
            foreach ($comments as $comment) {                              
//                updateCommentPostTitle ();
                

                list($this_date, $this_time) = explode(" ", $comment->formatted_date);


            ?>


                <div style="margin-right: 10%; margin-left: 20%; border-ra-dius: .5; border-left: .5px solid gray; background-color: white;" class="media">
                    <div class="media-body">
                        
                        <h4 style="margin-left: 10px; color: darkred; font-family: monospace;" class="media-heading"><?php echo $comment->post_title; ?>
                        <h4 style="margin-left: 10px; font-family: monospace;" class="media-heading"><?php echo $comment->comment_author; ?>
                            <small style="font-family: monospace;"><em><?php echo $this_date ?></em> <?php echo $this_time ?> </small>
                        </h4>
                        <p style="margin-left: 10px; font-family: monospace;"><?php echo $comment->comment; ?> </p>                       
                    </div>
                </div>                
<?php } } ?>
               

    
?>

</body>

