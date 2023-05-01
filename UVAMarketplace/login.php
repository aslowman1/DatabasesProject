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
      background-image: url('tundy.jpeg'); 
			background-repeat: no-repeat;
			background-size: cover;
			height: 100vh;
			margin: 0;
			padding: 0;
			font-family: Arial, sans-serif;
			font-size: 16px;
			display: flex;
			justify-content: center;
			align-items: center;
    }
    .container {
      background-color: #DA8E41;
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

    h3{
      font-family: Tahoma, Geneva, sans-serif;
      font-size: 15px;
      letter-spacing: 2px;
      word-spacing: 2px;
      color: #000000;
      font-weight: 700;
      text-decoration: none;
      font-style: normal;
      font-variant: normal;
      text-transform: none;  
      font-weight: bold;
    }
    .button{
      align-items: center;
      appearance: none;
      background-color: #FCFCFD;
      border-radius: 4px;
      border-width: 0;
      box-shadow: rgba(45, 35, 66, 0.4) 0 2px 4px,rgba(45, 35, 66, 0.3) 0 7px 13px -3px,#D6D6E7 0 -3px 0 inset;
      box-sizing: border-box;
      color: #36395A;
      cursor: pointer;
      display: inline-flex;
      font-family: "JetBrains Mono",monospace;
      height: 48px;
      justify-content: center;
      line-height: 1;
      list-style: none;
      overflow: hidden;
      padding-left: 16px;
      padding-right: 16px;
      position: relative;
      text-align: left;
      text-decoration: none;
      transition: box-shadow .15s,transform .15s;
      user-select: none;
      -webkit-user-select: none;
      touch-action: manipulation;
      white-space: nowrap;
      will-change: box-shadow,transform;
      font-size: 18px;
      margin-bottom: 30px;
    }

    .button:focus {
      box-shadow: #D6D6E7 0 0 0 1.5px inset, rgba(45, 35, 66, 0.4) 0 2px 4px, rgba(45, 35, 66, 0.3) 0 7px 13px -3px, #D6D6E7 0 -3px 0 inset;
    }

    .button:hover {
      box-shadow: rgba(45, 35, 66, 0.4) 0 4px 8px, rgba(45, 35, 66, 0.3) 0 7px 13px -3px, #D6D6E7 0 -3px 0 inset;
      transform: translateY(-2px);
    }

    .button:active {
      box-shadow: #D6D6E7 0 3px 7px inset;
      transform: translateY(2px);
    }
  </style>
</head>
<body>  
  <div class="container">  
    <h1 style="font-family: Lucida Console, Courier New, monospace; font-size:45px;  font-weight: bold;">UVA Marketplace</h1>
    <hr>
    <h2 style=" font-family: Tahoma, Geneva, sans-serif; font-size: 25px; letter-spacing: 2px; word-spacing: 2px;
      color: #000000; font-weight: 700;"> Log In </h2>
    <form action="login.php" method="post"> 
      <h3>
        <label for="username" style="font-family: Arial, Helvetica, sans-serif;">Username:</label>    
        <input type="text" id="username" name="username" required /> 
        <label for="pwd" style="font-family: Arial, Helvetica, sans-serif;" >Password:</label>
        <input type="password" id="pwd" name="pwd" required /> 
        <div class="button">
            <input type="submit" name="loginBtn" value="Sign in" class="btn" /> 
            <?php if ($attemptedLogin) { echo("Invallid username or password.\n"); } ?>
      <h3>
    </form>
  </div>
  <p>Don't have an account? <b><a href="signup.php" target="_blank">Sign up here!</a></b></p>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
</body>
</html>
