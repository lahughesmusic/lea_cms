<?php include_once "includes/db.php" ?><!DOCTYPE html>
<html lang="en">
<head>
     <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Forgot Password</title>   
</head>   
<body style="background-color: darkgray;">
    <div id="page-wrapper" style="width: 40%; margin-left: 30%;">
<!--    <div style="width: 400px;" class="form-control">-->
        <?php
        
        $token = '';
        $email = '';
        if (isset($_GET['token'])&& preg_match("/[A-Za-z0-9]+/", trim($_GET['token'])) == TRUE) {
            $token = preg_replace('/[^a-zA-Z0-9]/', '', trim($_GET['token']));
            $safe_query = $ezdb->safe_query('SELECT email, username FROM users WHERE password=?', $token);
            $get_row = $ezdb->get_row($safe_query);
            $email = $get_row->email;
            $username = $get_row->username;
            
            
            
          
        }
        ?>
        <form action="new_password.php?token=<?php echo $token; ?>" method="post">
            <h1>CHANGE PASSWORD</h1>
            <h2>USERNAME: <?php echo $username; ?> </h2>
            <h2>EMAIL: <?php echo $email; ?> </h2>                      
            <input class=" form-control" type="hidden" name="gen_password" value="<?php echo $token; ?>">
            <input class=" form-control" type="hidden" name="email" value="<?php echo $email; ?>">
               <label>NEW PASSWORD: </label>
            <input class=" form-control" type="password" name="new_password1" placeholder="New Password">
               <label>CONFIRM PASSWORD: </label>
            <input class=" form-control" type="password" name="new_password2" placeholder="Verify Password">
            <br>
            <input class="btn btn-primary" type="submit" value="submit" name="submit">
            <?php if (isset($_GET['error']) && $_GET['error']=='password_error') { ?>
                <div class="alert alert-warning" role="alert">
                Passwords Don't Match, Try Again.
                </div>
            <?php } ?>
        </form>
    </div>
</body>
</html>
<?php
if (isset($_POST['submit'])){ 
    
    $email = strtolower($_POST['email']);
    $gen_password = $_POST['gen_password'];
    $password1 = $_POST['new_password1'];
    $password2 = $_POST['new_password2'];
    
    
    $password_query = $ezdb->safe_query("SELECT LOWER(username) AS username, password FROM users WHERE email=?", $email);    
    $get_row = $ezdb->get_row($password_query); 
//    print_r($password_query);
    $password_temp = $get_row->password;
    $username = $get_row->username;
    $password = sha1(HASH_PREFIX.$username.'.'.$password1);
    
    
    if ($password1 !== $password2) {
        header("Location: new_password.php?token={$token}&error=password_error");
    } elseif ($gen_password !== $password_temp) {
        echo 'generated password: ' . $gen_password;
        echo 'temp password: ' . $password_temp;
        print_r($password_query);
//        header("Location: new_password.php?token={$token}&error=invalid_token");
    } else {
        $update_password = $ezdb->safe_query("UPDATE users SET password=? WHERE email=?", $password, $email);   
        $update = $ezdb->get_results($update_password);
        header("Location: login.php?message=password_reset");                                      
    }
}
    