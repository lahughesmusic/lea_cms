<!DOCYTPE html>
<html lang="en">
<head>
     <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Registration Page</title>   
</head>   
<body style="background-color: darkgray;">
    <?php
    require_once "includes/db.php";
    include "includes/header.php" ?>  
     <div id="page-wrapper" style="width: 40%; margin-left: 30%;">
         <?php if (isset($_GET['error']) && $_GET['error']=='frequency') { ?>
            <div class="alert alert-warning" role="alert">
            You are registering too much. Try again in an hour 
            </div>
         <?php } elseif (isset($_GET['error']) && $_GET['error']=='unknown') { ?>
            <div class="alert alert-warning" role="alert">
            An unknown problem occurred. Please let us know if this continues 
            </div>
         <?php } ?>
         <form action="php/process-register.php" method="post">
            <h1>REGISTER</h1>
            <label>USERNAME: </label>
            <input class="form-control" type="text" name="username">
            <?php if (isset($_GET['error']) && $_GET['error']=='username'){ ?>
            <br><div class="alert alert-warning" role="alert">
                Username already in use
            </div>
            <?php } ?>
            <label>PASSWORD: </label>
            <input class=" form-control" type="password" name="password">            
            <div class="form-group">
                <label for="email">EMAIL ADDRESS: </label>
                <input type="email" class="form-control" id="email" name="email">                
            </div>
            <?php if (isset($_GET['error']) && $_GET['error']=='email'){ ?>
            <br><div class="alert alert-warning" role="alert">
                E-mail does not look right
            </div>
            <?php } ?>
            <input class="btn btn-primary" type="submit" value="submit" name="submit">                        
        </form>
</body>
</html>