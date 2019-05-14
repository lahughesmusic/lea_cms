<?php
session_start();
if(!isset($_SESSION['username'])){
   header("Location: /cms/login.php");
}
?>
<?php require_once "../includes/db.php"; ?>
<?php // include_once "includes/uploads.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Post Submit</title>
    <script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
    <link rel="stylesheet" href="upload_photo/assets/css/styles.css" />

</head>

<body>
    <div>
<?php include "includes/admin_navigation.php"; ?>
    </div>
     <br>
    <br>
     <div>
<?php include "includes/admin_header.php";?> 
    </div>
    <h1>UPLOADED</h1>
    <div id="page-wrapper" style="width: 40%; margin-left: 30%;">
        <div class="container-fluid">
            <div class="col-lg-12">                
                <h1 class="page-header">
                POST SUBMIT
                </h1>                                                
                <div class="col-xs-6">                
                </div>
            </div>
        </div>                          
    <div> 
        <form action="post_submit.php" method="post">                                    
            <label for="post_title">CATEGORY: </label>           
            <select name="cat_id">
            <?php 
                
            
            
            
                $safe_query = $ezdb->safe_query("SELECT cat_title, cat_id FROM categories");
                $rows = $ezdb->get_results($safe_query);
                foreach ($rows as $row) {                  
                ?>         
                <option value="<?php echo $row->cat_id; ?>"><?php echo $row->cat_title; ?></option>
                <?php }  ?>
                </select>              
                <br>
                <br>            
                <label for="post_category" >CREATE CATEGORY<i> (optional)</i></label>
                <input class="form-control" type="text" name="cat_title">
                <br>                                                                    
                <label for="post_title">TITLE:</label>
                <input class="form-control" type="text" name="post_title">
                <br>           
                <label for="post_tags">TAGS: </label>
                <input class="form-control" type="text" name="post_tags">
                <br>                   
                <textarea name="post_content" placeholder="post your content"></textarea>
    <!--            editor-->
                    <script>
                        CKEDITOR.replace('post_content');
                    </script>
                <label for="post_author">NAME: </label>
                <input class="form-control" style="width: 200px;" type="text" name="post_author">
                <br>                        		
<!--                UPLOAD IMAGE-->
                <label>UPLOAD IMAGE (optional): </label>
                <div style="width: 100%;"  id="dropbox">
			<span class="message">Drop images here to upload. <br /><i>(they will only be visible to you)</i></span>
		</div>                
    </div>
    </div>    
<!--why is netbeans wanting me to use filter_input_array instead of $_POST?-->
<?php 
    global $ezdb;
    if (isset($_POST['submit'])){        
        $post_title = $_POST['post_title'];    
        $post_tags = $_POST['post_tags'];
        $post_author = $_POST['post_author'];
        $post_date = date('d/m/y');
        $post_content = $_POST['post_content'];  
        $cat_title = $_POST['cat_title'];              
        
        $safe_query = $ezdb->safe_query("EXECUTE INSERT INTO posts (post_title, post_author, post_tags, post_content, post_date, cat_title) "
        . "VALUES (?, ?, ?, ?, NOW(), ?)", $post_title, $post_author, $post_tags, $post_content, $cat_title);
        
                
        //echo $safe_query;
        //$update_query = $ezdb->query($safe_query);   
        
//        header("Location: ../index.php");                 
    if (isset($_POST['cat_title'])) {       
        $cat_title = $_POST['cat_title'];        
        if ($cat_title == "" || empty($cat_title)) {
            
        }else{
            $safe_query = $ezdb->safe_query("INSERT INTO categories (cat_title) VALUES (?)", $cat_title);                        
            $update_query = $ezdb->query($safe_query);
            }
        }
    }
    
     
?>

<!--UPLOAD IMAGE FOOTER-->
<!--        <footer>
	        <h2>HTML5 File Upload with jQuery and PHP</h2>
            <a class="tzine" href="https://tutorialzine.com/2011/09/html5-file-upload-jquery-php/">Read &amp; Download on</a>
        </footer>-->
        
        <!-- Including The jQuery Library -->
		<script src="https://code.jquery.com/jquery-1.6.3.min.js"></script>
		
		<!-- Including the HTML5 Uploader plugin -->
                <script src="upload_photo/assets/js/jquery.filedrop.js"></script>
		
		<!-- The main script file -->
                <script src="upload_photo/assets/js/script.js"></script>

<?php include "includes/admin_footer.php"; ?>
       

  
    
</body>
</html>