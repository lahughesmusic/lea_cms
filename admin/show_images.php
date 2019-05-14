<?php require_once '../includes/db.php'?><!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Show Images</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/blog-post.css" rel="stylesheet">
</head>
<body>
    
    <?php 
        $safe_query = $ezdb->safe_query("SELECT post_id FROM posts WHERE image_path != ' '");
        $post_ids = $ezdb->get_col($safe_query);
        foreach ($post_ids as $id) {
    ?>
                               
                        <img src="/cms/php/post-image.php?id=<?php echo $id;?>" alt="">                    
            
                  
            
        <?php } ?>
        
    
        
        
</body>
</html>