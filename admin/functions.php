<?php

function insert_categories() {   
    global $ezdb;
    if (isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];
        if ($cat_title == "" || empty($cat_title)) {
            echo "this field is empty";
        }else{
            $safe_query = $ezdb->safe_query("INSERT INTO categories (cat_title) VALUES (?)", $cat_title);                        
            $update_query = $ezdb->query($safe_query);
        }
    }
}

function findAllCategories() {
    global $ezdb;
    $safe_query = $ezdb->safe_query('SELECT * FROM categories');
    $rows = $ezdb->get_results($safe_query, ARRAY_A);


    foreach ($rows as $row) {
        $cat_id = $row['cat_id']; //pulling row "cat_title" catergory title, from database
        $cat_title = $row['cat_title'];
        echo "<tr>";
        echo "<td>{$cat_id}</td>";  
        echo "<td>{$cat_title}</td>";  
        echo "<td><a href='categories.php?delete={$cat_id}'>DELETE</a></td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>EDIT</a></td>";  
        echo "</tr>";        
    }
}



function delete_categories(){
    global $ezdb;
    if(isset($_GET['delete'])){
        $the_cat_id = (int)$_GET['delete'];        
        $safe_query = $ezdb->safe_query("DELETE FROM categories WHERE cat_id=?", $the_cat_id);        
        $result = $ezdb->query($safe_query);
    }
}

?>