<?php session_start();
if(!isset($_SESSION['username'])){
   header("Location: /cms/login.php");
}
?>
<?php include "includes/admin_header.php"; ?>
<?php 
if (isset($_GET['delete'])) {
    delete_categories();
} else {
    include "includes/update_categories.php";
}
?>
<div id="wrapper">
    
    <?php include "includes/admin_navigation.php"; ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="col-lg-12">
                <h1 class="page-header">                   
                    <small>Author</small>
                </h1>
                <div class="col-xs-6">                   
                    <div class="form-group">
                      <?php if (isset($_GET['edit'])) { ?>
                        <form action="categories.php" method="post" >
                            <div class="form-group">
                                <label for="cat_title">Edit Category</label>
                                <input type="hidden" name="cat_id" value="<?php echo $cat_id; ?>">
                                <input value="<?php if(isset($cat_id)){echo $cat_title;} ?>" type="text" class="form-control" name="cat_title">
                                <br>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="Update" name="submit">
                                </div>
                            </div>
                        </form>
                        <?php } else { ?>
                        <form action="categories.php" method="post">
                            <label for="cat_title">Category Name</label>
                            <input type="text" class="form-control" name="cat_title">

                            <br>
                            <input type="submit" class="btn btn-primary" value="Add Category" name="submit">
                        </form>
                        <?php } ?>
                        <br>
                        <?php   // UPDATE AND INCLUDE QUERY 
                        if (isset($_GET['edit'])) {
                            if ((int)$_GET['edit'] != $_GET['edit']) {
                                die('Invalid value');
                        }else{
                            $cat_id = (int)$_GET['cat_id'];
                    }
                }
                        ?>                      
                    </div>
                </div>
                <div class="col-xs-6">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Category</th>
                            </tr>

                        </thead>
                        <tbody>
                            <!-- //FIND ALL CATEGORIES -->
                            <?php  findAllCategories(); ?>                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>        
    </div>    
</div>

<?php include "includes/admin_footer.php"  ?>