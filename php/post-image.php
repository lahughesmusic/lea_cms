<?php
require_once "../includes/db.php";

$post_id = (int)$_GET['id'];
$safe_query = $ezdb->safe_query('SELECT image_path FROM posts WHERE post_id=?', $post_id);
$file_path = $ezdb->get_var($safe_query);

if ($file_path) {
    // get the file's mime type to send the correct content type header
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $file_path);

    // send the headers
    //header("Content-Disposition: attachment; filename={$post_id};");
    header("Content-Type: $mime_type");
    header('Content-Length: ' . filesize($file_path));

    // stream the file
    $fp = fopen($file_path, 'rb');
    fpassthru($fp);
    exit;
}