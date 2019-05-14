<?php
function base64ToImage($base64_string, $output_file) {
  $file = fopen($output_file, "wb");

  $data = explode(',', $base64_string);

  fwrite($file, base64_decode($data[1]));
  fclose($file);

  return $output_file;
}

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.css'>
    <script>
  window.console = window.console || function(t) {};
    </script>
    <script>
      if (document.location.search.match(/type=embed/gi)) {
        window.parent.postMessage("resize", "*");
      }
    </script>
    <title>Post Submit</title>
    <!--<script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>-->
</head>

<body translate="no">
    <style>
      
.page {
	margin: 1em auto;
	max-width: 768px;
	display: flex;
	align-items: flex-start;
	flex-wrap: wrap;
	height: 100%;
}

.box {
	padding: 0.5em;
	width: 100%;
	margin:0.5em;
}

.box-2 {
	padding: 0.5em;
	width: calc(100%/2 - 1em);
}

.options label,
.options input{
	width:4em;
	padding:0.5em 1em;
}
.btn{
	background:white;
	color:black;
	border:1px solid black;
	padding: 0.5em 1em;
	text-decoration:none;
	margin:0.8em 0.3em;
	display:inline-block;
	cursor:pointer;
}

.hide {
	display: none;
}

img {
	max-width: 100%;
}

    </style>
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
        <form action="post_submit.php" method="post" enctype="multipart/form-data" name="imagePost" id="imagePost">                                    
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
                <textarea name="image_data" placeholder="image data" id="imagedata"></textarea>
                <br>                   
                <textarea name="post_content" placeholder="post your content"></textarea>
    <!--            editor-->
                    <!--<script>
                        CKEDITOR.replace('post_content');
                    </script>-->
                <label for="post_author">NAME: </label>
                <input class="form-control" style="width: 200px;" type="text" name="post_author">
                <br>                
<!--                    Select image to upload:
                    <input type="file" name="image" id="fileToUpload">                
                <input type="submit" name="submit" class="btn btn-primary" value="SUBMIT">  -->
<!--                UPLOAD AND CROP IMAGE-->
                <main class="page">
                    <h2>Upload ,Crop and save.</h2>

                    <div class="box">
                    <input type="file" id="file-input">
                    </div>

                    <div class="box-2">
                    <div class="result"></div>
                    </div>

                    <div class="box-2 img-result hide">

                    <img class="cropped" src="" alt="">
                    </div>

                    <div class="box">
                    <div class="options hide">
                    <label> Width</label>
                    <input type="number" class="img-w" value="300" min="100" max="1200" />
                    </div>

                    <button class="btn save hide">Save</button>

                    <a href="" class="btn download hide">Download</a>
                    </div>
                    </main>
        </form>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.min.js'></script>
<script id="rendered-js">
      // vars
let result = document.querySelector('.result'),
img_result = document.querySelector('.img-result'),
img_w = document.querySelector('.img-w'),
img_h = document.querySelector('.img-h'),
options = document.querySelector('.options'),
save = document.querySelector('.save'),
cropped = document.querySelector('.cropped'),
dwn = document.querySelector('.download'),
upload = document.querySelector('#file-input'),
cropper = '';

// on change show image with crop options
upload.addEventListener('change', e => {
  if (e.target.files.length) {
    // start file reader
    const reader = new FileReader();
    reader.onload = e => {
      if (e.target.result) {
        // create new image
        let img = document.createElement('img');
        img.id = 'image';
        img.src = e.target.result;
        // clean result before
        result.innerHTML = '';
        // append new image
        result.appendChild(img);
        // show save btn and options
        save.classList.remove('hide');
        options.classList.remove('hide');
        // init cropper
        cropper = new Cropper(img);
      }
    };
    reader.readAsDataURL(e.target.files[0]);
  }
});

// save on click
save.addEventListener('click', e => {
  e.preventDefault();
  // get result to data uri
  let imgSrc = cropper.getCroppedCanvas({
    width: img_w.value // input value
  }).toDataURL();
  // remove hide class of img
  cropped.classList.remove('hide');
  img_result.classList.remove('hide');
  // show image cropped
  cropped.src = imgSrc;
  dwn.classList.remove('hide');
  dwn.download = 'imagename.png';
  dwn.setAttribute('href', imgSrc);
  $("#imagedata").val(imgSrc);
  $( "#imagePost" ).submit();
});
      //# sourceURL=pen.js
    </script>


            
<?php

    if(isset($_FILES['image'])){
       $errors= array();
       $file_name = $_FILES['image']['name'];
       $file_size =$_FILES['image']['size'];
       $file_tmp =$_FILES['image']['tmp_name']; // Important
       $file_type=$_FILES['image']['type'];
       $parts = explode('.', $file_name);
       $file_ext = array_pop($parts);

       $extensions= array("jpeg","jpg","png");

       if(in_array($file_ext,$extensions)=== false){
          $errors[]="extension not allowed, please choose a JPEG or PNG file.";
       }

       if($file_size > 22097152){
          $errors[]='File size must be less than 22 MB';
       }

       if(empty($errors)==true){
          move_uploaded_file($file_tmp,'/home/hostmywiki/public_html/cms/uploads/'.$file_name); // Important
          echo "Success";
       }else{
          print_r($errors);
       }

        $base64_string = $_POST['image_data'];
        $output_file = '/home/hostmywiki/public_html/cms/uploads/'.$file_name;

        
        
}

?>
                


      
      
      

            
            
      
    </div>
    </div>    
<!--why is netbeans wanting me to use filter_input_array instead of $_POST?-->
<?php 
    global $ezdb;
    if (isset($_POST['cat_id'])){        
        $post_title = $_POST['post_title'];    
        $post_tags = $_POST['post_tags'];
        $post_author = $_POST['post_author'];
        $post_date = date('d/m/y');
        $post_content = $_POST['post_content'];  
        $cat_title = $_POST['cat_title'];              
        $output_file = '/home/hostmywiki/public_html/cms/uploads/'.time().'.png';
      
        $safe_query = $ezdb->safe_query("EXECUTE INSERT INTO posts (post_title, post_author, post_tags, post_content, post_date, cat_title, image_path) "
        . "VALUES (?, ?, ?, ?, NOW(), ?, ?)", $post_title, $post_author, $post_tags, $post_content, $cat_title, $output_file);
        
                
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
        
        // Process the image data here
        $image_path = base64ToImage($_POST['image_data'], $output_file);
    }
    
     
?>

<?php include "includes/admin_footer.php"; ?>
       

  
    
</body>
</html>