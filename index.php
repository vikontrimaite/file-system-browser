<?php 
  session_start();
  if(isset($_GET['action']) and $_GET['action'] == 'logout'){
    session_start();
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    unset($_SESSION['logged_in']);
    $_SESSION['logout_msg'] = "Successfully logged out";
    header('Location: http://localhost/p/newFSB');
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
</head>
    <body>
      <?php
          $msg = '';
          if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
            if ($_POST['username'] == 'Mindaugas' && $_POST['password'] == '1234'){
              $_SESSION['logged_in'] = true;
              $_SESSION['timeout'] = time();
              $_SESSION['username'] = 'Mindaugas';

              echo 'You have entered valid user name and password';
            } else {
              $msg = 'Wrong username or password';
            }
          }

          if(isset($_SESSION['logout_msg'])){
            print($_SESSION['logout_msg']);
            unset($_SESSION['logout_msg']);
          }
      ?>
      <?php 
        if($_SESSION['logged_in'] == true){
            print('<h1>You can only see this if you are logged in!</h1>');

            include('main.php');
        }
      ?>
      <form action="" method="post">
        <h4><?php echo $msg; ?></h4>
        <input type="text" name="username" placeholder="username = Mindaugas" required autofocus></br>
        <input type="password" name="password" placeholder="password = 1234" required>
        <button class = "btn btn-lg btn-primary btn-block" type="submit" name="login">Login</button>
      </form>
      <br>
      Click here to <a href = "index.php?action=logout"> logout.
    </body>
</html>