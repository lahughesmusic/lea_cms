<?php
if(isset($_GET['edit'])){

    $cat_id = (int)$_GET['edit']; 

    $safe_query = $ezdb->safe_query("SELECT * FROM categories WHERE cat_id = ?", (int)$cat_id );
    //$select_categories_id = safe_query($safe_query);

    $row = $ezdb->get_row($safe_query, ARRAY_A);
    $cat_id = $row['cat_id']; //pulling row "cat_title" catergory title, from database
    $cat_title = $row['cat_title'];
    //die('Title: ' . $cat_title);
}

if (isset($_POST['submit'])) {
    //echo "POST:";
    //print_r($_POST);
    //die();
    $the_cat_title = $_POST['cat_title'];
    if (isset($_POST['cat_id'])) {
        $cat_id = (int)$_POST['cat_id'];
        $safe_query = $ezdb->safe_query('UPDATE categories SET cat_title=? WHERE cat_id=?', $the_cat_title, $cat_id);
    } else {
        $safe_query = $ezdb->safe_query('INSERT INTO categories (cat_title) VALUES (?)', $the_cat_title);
    }
    $update_query = $ezdb->query($safe_query);
}