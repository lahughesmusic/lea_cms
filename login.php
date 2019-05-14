<?php ob_start(); ?>
<?php session_start(); ?>
<?php include "includes/db.php" ?>
<!DOCYTPE html>
<head>
       
     <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<!--      <link href="css/sb-admin.css" rel="stylesheet">-->

    <!-- Custom Fonts -->
<!--    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">-->
    <title>Login Page</title>   
    
</head>   
<body style="background-color: darkgray;">
    <?php include "includes/header.php" ?>  
    <?php if (isset($_GET['message']) && $_GET['message']=='success') { ?>
        <div class="alert alert-primary" style="width: 40%; margin-left: 30%" role="alert">
            Congratulations you are registered!
        </div>
    <?php } ?>
     <div id="page-wrapper" style="width: 40%; margin-left: 30%;">
<!--    <div style="width: 400px;" class="form-control">-->
        <form action="login.php" method="post">
            <h1>LOGIN</h1>
            <label>USERNAME: </label>
            <input class="form-control" type="text" name="username">
            <label>PASSWORD: </label>
            <input class=" form-control" type="password" name="password">
            <br>
            <input class="btn btn-primary" type="submit" value="submit" name="submit">
            
            <br><a href="register.php"<h4>New User</h4></a>
            <br><a href="forgot_password.php"<h4>Forgot Password</h4></a>
        </form>

        <?php           

        if (isset($_POST['submit'])) {
            //$username = $_POST['username'];
            $unsafe_password = strtolower($_POST['password']);
            
            if (preg_match("/[A-Za-z0-9]+/", trim($_POST['username'])) == TRUE){
                $username = preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['username']));
                $username = substr($username, 0, 255);
                $username = strtolower($username);
            }
            
            //$password = sha1($_POST['username'].$_POST['password']);
            

            //$username = substr(preg_replace('/[^a-zA-Z0-9]/', '', $username), 0 ,255);
            //$password = substr(preg_replace('/[^a-zA-Z0-9]/', '', $_POST['password']), 0 ,255);
                        
            //echo $username;
            //echo $password;
            
            //$safe_query = $ezdb->safe_query("SELECT count(*) AS total FROM users WHERE username=? AND password=?", $username, $password);
            //$result = $ezdb->get_var($safe_query);
            
            $safe_query = $ezdb->safe_query("SELECT username, LOWER(password) AS password_hash FROM users");
            $users = $ezdb->get_results($safe_query);
            $logged_in = false;
            foreach ($users as $user) {
                ///if ($user->username === $username) {
                //    echo "{$user->username} matches {$username}<br />";
                //    echo "Salt: {$user->salt}<br />";
                //    echo "Hash: " . sha1($user->salt . ".{$unsafe_password}") . "<br />";
                //    
                //    sha1($_POST['username'].$_POST['password'])
                //}
//                echo 'sha1 :' . sha1($username.'.'.$unsafe_password) . "<br>";
//                echo 'password_hash :' . $user->password_hash . "<br>";
                
                if (($user->username === $username) && sha1(HASH_PREFIX.$username.'.'.$unsafe_password) === $user->password_hash) {
                    $logged_in = true;
                  
                    break;
                    
                }
            }
            
            if ($logged_in) {
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $username;
                header("Location:admin/index.php");
            }else{           
                echo "username or password not found";
            }
           
            }
          
          ?>
        
        
         
    </div>
</body>

