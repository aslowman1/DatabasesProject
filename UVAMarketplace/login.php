<?php
require("connect-db.php");
require('Account-db.php');
require('User-db.php');

$attemptedLogin = FALSE; //Bool for if a user tried to sign up

if (!isset($_SESSION)) {
  session_start();
}

if (isset($_SESSION['computingID'])) {
  header("Location: home.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (!empty($_POST['loginBtn'])) {
    $attemptedLogin = TRUE;
    if (isValidLogin($_POST['username'], $_POST['pwd'])) {
      $_SESSION['username'] = $_POST['username'];
      if(isUser($_POST['username'])) {
        setSessionVars($_SESSION['username']);
        header("Location: home.php");
      }
      else {
        header("Location: createProfile.php");
      }
      exit();
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">   
  <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- required to handle IE -->
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <title>Login</title> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <link rel="stylesheet" href="activity-styles.css" /> 
  <style>
     body {
      background-image: url("tundy.jpeg");
      background-size: cover;
    }
    .container {
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      margin: 50px auto;
      max-width: 500px;
      margin-top: 50px;
      border-top: 1px solid #ccc;
      text-align: center;
    }
    h1 {
      margin-top: 0;
    }
    form {
      margin-top: 20px;
      display: inline-block;
      text-align: left;
    }
    label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
    }
    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    input[type="submit"] {
      background-color: #007bff;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      text-align: center;
    }
  </style>
</head>
<body>  
  <div class="container">  
    <h1 style="font-family: Lucida Console, Courier New, monospace; font-size:45px;">UVA Marketplace</h1>
    <hr>
    <h2 style="font-family: Arial, Helvetica, sans-serif; font-size: 30px"> Log In </h2>
    <form action="login.php" method="post"> 
      <label for="username" style="font-family: Arial, Helvetica, sans-serif;">Username:</label>    
      <input type="text" id="username" name="username" required /> 
      <label for="pwd" style="font-family: Arial, Helvetica, sans-serif;" >Password:</label>
      <input type="password" id="pwd" name="pwd" required /> 
      <input type="submit" name="loginBtn" value="Sign in" class="btn" style="background-color: #00008B; float: center;"/> 
      <?php if ($attemptedLogin) { echo("Invallid username or password.\n"); } ?>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
</body>
</html>
