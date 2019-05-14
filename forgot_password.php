<?php include "includes/db.php" ?><!DOCTYPE html>
<html lang="en">
<head>
       
     <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Forgot Password</title>   
</head>   
<body style="background-color: darkgray;">
    <div id="page-wrapper" style="width: 40%; margin-left: 30%;">
<!--    <div style="width: 400px;" class="form-control">-->
        <form action="forgot_password.php" method="post">
            <h1>FORGOT PASSWORD</h1>
<!--            <label>USERNAME: </label>
            <input class="form-control" type="text" name="username">-->
            <label>EMAIL: </label>
            <input class=" form-control" type="text" name="email">
            <br>
            <input class="btn btn-primary" type="submit" value="submit" name="submit">
            <br>
            <br>
            <?php if (isset($_GET['new_password']) && $_GET['new_password']=='check_email') { ?>
                  <div class="alert alert-success" role="alert">
                 Check E-mail for the link to reset your password.
                 </div>
            <?php }?>
        </form>
    </div>

        <?php           

               if (isset($_POST['submit'])) {                                                         
                $safe_query = $ezdb->safe_query("SELECT LOWER(email) as email FROM users");
                $users = $ezdb->get_results($safe_query);
                $email = strtolower($_POST['email']);
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    foreach ($users as $user) {
                        if ($user->email === $email) {                            
                            $subject = "Temporary Password";
                            $isPasswordUnique = false;
                            while (!$isPasswordUnique) {
                                $gen_password = generatePassword(10);
                                $validate_gen_password = $ezdb->safe_query("SELECT count(*) AS total FROM users WHERE password=? LIMIT 1", $gen_password);
                                $validate_results = $ezdb->get_var($validate_gen_password);
                                if ($validate_results == 0) {
                                    $isPasswordUnique = true;                             
                                }
                            }
                            
                            $update_query = $ezdb->safe_query("UPDATE users SET password=? WHERE email=?", $gen_password, $email);
                            $query = $ezdb->get_results($update_query);
                            
                                                        
                            $message = "Click here to reset password: https://www.hostmywiki.com/cms/new_password.php?token=" . urlencode($gen_password);                                                       
                            mail($email, $subject, $message);
                            file_put_contents('recover_password.txt', $message);
                            header("Location: forgot_password.php?new_password=check_email");  
                            break;                           
                        }
                        
                        


                    }
                } else {
                    // email doesn't validate
                }
               }
        ?>           

    
</body>
</html>
<?php
function generatePassword($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = mb_strlen($chars);
    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }
    return $result;
}                            
