<?php
require_once '../includes/db.php';
$user_info_stored = false; 
if (isset($_POST['submit'])) {

    if (preg_match("/[A-Za-z0-9]+/", trim($_POST['username'])) == TRUE){
        $username = preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['username']));
        $username = substr($username, 0, 255);
        $username = strtolower($username); //make username case consistant
    }    
    $unsafe_password = $_POST['password'];
//            echo $username;
//            echo $unsafe_password;            
//            $salt = 

    //validate username has not been used
    $validate_query = $ezdb->safe_query("SELECT count(*) AS total FROM users WHERE username=?", $username);
//            echo $validate_query;
    $validate_result = (int)$ezdb->get_var($validate_query);            
    if($validate_result > 0){
        header("Location: ../register.php?error=username");
        exit;
    }else{
        //check for ip user within last hour
        $user_ip = $_SERVER['REMOTE_ADDR'];
        $safe_query = $ezdb->safe_query('SELECT count(*) AS total FROM users WHERE user_ip=? AND user_date >= DATE_SUB(NOW(),INTERVAL 1 HOUR) LIMIT 1', $user_ip);
        $hasRegisteredPastHour = boolval($ezdb->get_var($safe_query));

        if ($hasRegisteredPastHour) {
            header("Location: ../register.php?error=frequency");
            exit;
        } else {
            $email = $_POST['email'];
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $password = sha1(HASH_PREFIX.$username.'.'.$unsafe_password); 
                $safe_query = $ezdb->safe_query("INSERT INTO users (username, password, email, user_ip, user_date) VALUES (?, ?, ?, ?, NOW())", $username, $password, $email, $user_ip);
                $result = $ezdb->get_results($safe_query);
                //$safe_query = $ezdb->safe_query('UPDATE users SET password=?, email=?, name=? WHERE user_id=?', $password, $username);
                //$safe_query = $ezdb->safe_query('DELETE FROM users WHERE user_id=? LIMIT 1', $user_id);
                $user_info_stored = true;
            } else {
                header("Location: ../register.php?error=email");
                exit;
            }


        }
    } 

}

if ($user_info_stored) {
    header("Location: ../login.php?message=success");                              
} else {
    header('Location: ../register.php?error=unknown');
}