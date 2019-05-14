<?php include "includes/db.php" ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>read more</title>
</head>

<body>
    <?php
    global $ezdb;

$post_id = (int)$_GET['post_id'];
$safe_query = $ezdb->safe_query("SELECT post_content, post_title FROM posts WHERE post_id=?", $post_id);
$row = $ezdb->get_row($safe_query);

if(!$row){
    echo "No Result";
}else{

    

?>
    <h1><?php echo $row->post_title?></h1>
    <p><?php echo $row->post_content?>></p>

    <?php } ?>
</body>

</html>