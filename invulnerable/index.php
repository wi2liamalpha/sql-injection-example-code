<?php

  $host = 'localhost';
  $db_name = 'sql';
  $charset = 'utf8';
  $username = 'root';
  $password = '';
  $connection = new PDO("mysql:host=$host;dbname=$db_name;charset=$charset",$username,$password);
  
  if( isset($_POST['InputEmail']) && isset($_POST['InputPassword']) ){

    $InputEmail = $_POST['InputEmail'];
    $InputPassword = $_POST['InputPassword'];

    if( empty($InputEmail) || empty($InputPassword) ){
      header("Location: index.php?message=3");
      exit;
    }

    if ( !filter_var($InputEmail, FILTER_VALIDATE_EMAIL) ){
      header("Location: index.php?message=4");
      exit;
    }

    $query = $connection -> prepare("SELECT * FROM users WHERE email=:email AND password=:password");
    $query -> execute(array(
      'email' => $InputEmail,
      'password' => $InputPassword
    ));

    $control = $query -> rowCount();
    if($control)
    {
      header("Location: index.php?message=1");
      exit;
    }else{
      header("Location: index.php?message=2");
      exit;
    }

  }
?>

<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Giriş Yap</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <script src="assets/js/bootstrap.min.js"></script>
</head>

<body class="p-3 mb-2 bg-light">

  <div class="container">
    <div class="container-wrapper ">

      <div class="row">

        <div class="col-4"></div>
        
        <div class="col-4  rounded-sm " style="margin-top: 150px;">

          <?php
          if( isset($_GET['message']) ){
            if($_GET['message'] == 1){
              echo '<div class="alert alert-success" role="alert">Login successful!</div>';
            }
            if($_GET['message'] == 2){
              echo '<div class="alert alert-danger" role="alert">Login failed!</div>';
            }
            if($_GET['message'] == 3){
              echo '<div class="alert alert-danger" role="alert">Email and password cannot be empty!</div>';
            }
            if($_GET['message'] == 4){
              echo '<div class="alert alert-danger" role="alert">Please enter a valid E-mail address.</div>';
            }
          }
          ?>

          <form action="index.php" method="post">
            <div class="form-group">
              <label for="InputEmail">E-mail address</label>
              <input type="email" class="form-control" name="InputEmail" id="InputEmail" aria-describedby="emailHelp" placeholder="E-mail address">
            </div>
            <div class="form-group">
              <label for="InputPassword">Word</label>
              <input type="password" class="form-control" name="InputPassword" id="InputPassword" placeholder="Word">
            </div>
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="Check">
              <label class="form-check-label" for="Check">Remember me</label>
            </div>

            <button type="submit" class="btn btn-primary">Login</button>

            <div class="dropdown-divider mt-3"></div>
            <a class="dropdown-item" href="#">Don't have an account? Register</a>
            <a class="dropdown-item" href="#">Forgot your password?</a>
          </form>
        

        </div>
      
        <div class="col-4"></div>

      </div>

    </div>
  </div>
</body>

</html>