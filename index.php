<?php 
    session_start();
    // logout logic
    if(isset($_GET['action']) and $_GET['action'] == 'logout'){
        session_start();
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        unset($_SESSION['logged_in']);
        print('Logged out!');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File system browser</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>


      <div>
      <h2>Enter Username and Password</h2> 
      <div>
         <?php
            $msg = '';
            if (isset($_POST['login']) 
                && !empty($_POST['username']) 
                && !empty($_POST['password'])
            ) {	
               if ($_POST['username'] == 'vi' && 
                  $_POST['password'] == '12'
                ) {
                  $_SESSION['logged_in'] = true;
                  $_SESSION['timeout'] = time();
                  $_SESSION['username'] = 'vi';
                  echo 'You have entered valid use name and password';
               } else {
                  $msg = 'Wrong username or password';
               }
            }
         ?>
      </div>
      <div>
        <?php 
            if($_SESSION['logged_in'] == true){
              
                    print('You can only see this if you are logged in!');
                
               
               include('session.php');
            }
        ?>
        <div style="background-color: violet">
        <form action="./index.php" method="post">
            <h4><?php echo $msg; ?></h4>
            <label for="username">Username:</label>
            <input type="text" name="username" placeholder="vi" required autofocus></br>
            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="12" required>
            <button class = "btn btn-lg btn-primary btn-block" type="submit" name="login">Login</button>
        </form>
        </div>
       
        Click here to <a href = "index.php?action=logout"> logout.
      </div> 
      </div>

</body>
</html>