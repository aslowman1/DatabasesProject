<?php
require("connect-db.php");

require('Account-db.php');

$userAvail = TRUE; //Bool for whether username is available
$attemptedSignup = FALSE; //Bool for if a user tried to sign up

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['username'])) {
    header("Location: home.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (!empty($_POST['signupBtn'])) {
    $attemptedSignup = TRUE;
    $userAvail = !hasAccount($_POST['username']);

    if ($userAvail) {
       createAccount($_POST['username'], $_POST['pwd']);
       $_SESSION['username'] = $_POST['username'];
       header("Location: createProfile.php");
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
      background-position: center;
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
    

    h1{
      font-family: "Lucida Console", Courier New, monospace;
      font-size: 45px;
      text-align: center;
      font-weight: bold;
    }

    h2{
      font-family: Tahoma, Geneva, sans-serif;
      font-size: 25px;
      letter-spacing: 2px;
      word-spacing: 2px;
      color: #000000;
      font-weight: 700;
      text-decoration: none;
      font-style: normal;
      font-variant: normal;
      text-transform: none;
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
      background-color: #002F6C;
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
    <h1>UVA Marketplace</h1>
    <hr>
    <h2>Signup</h2>
    <form action="signup.php" method="post">   
      <h3>  
      Username: <input type="text" name="username" required /> <br/>
      Password: <input type="password" name="pwd" required /> <br/>
      <input type="submit" name ="signupBtn" value="Submit" class="btn" /> <br/>
      <?php if ($attemptedSignup && !$userAvail) { echo("Username already taken.\n"); } ?>
      </h3>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
</body>
</html>