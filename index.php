<?php 
  session_start();
  if(isset($_GET['action']) and $_GET['action'] == 'logout'){
    session_start();
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    unset($_SESSION['logged_in']);
    $_SESSION['logout_msg'] = "Successfully logged out";
    header('Location: http://localhost/p/fs-browser');
    exit;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File System Browser</title>
    <link rel="stylesheet" href="style.css">
</head>
    <body>
      <?php
          $msg = '';
          if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
            if ($_POST['username'] == 'vi' && $_POST['password'] == '12'){
              $_SESSION['logged_in'] = true;
              $_SESSION['timeout'] = time();
              $_SESSION['username'] = 'vi';

              echo '<p style="color: grey; font-style: italic; font-size: 10px;">You have entered valid user name and password!</p>';
            } else {
              $msg = 'Wrong username or password!';
            }
          }

          if(isset($_SESSION['logout_msg'])){
            print($_SESSION['logout_msg']);
            unset($_SESSION['logout_msg']);
          }
      ?>
      <?php 
        if($_SESSION['logged_in'] == true){
            include('main.php');
        }
      ?>
      <div style="background-color: pink;">
        <form action="" method="post">
            <h4><?php echo $msg; ?></h4>
            <label for="username">Username: </label>
            <input type="text" name="username" placeholder="username = vi" required autofocus></br>

            <label for="password">Password: </label>
            <input type="password" name="password" placeholder="password = 12" required>
            <button class = "btn btn-lg btn-primary btn-block" type="submit" name="login">Login</button>
      </form>
      </div>
      <br>
      Click here to <a href = "index.php?action=logout"> logout.
    </body>
</html>