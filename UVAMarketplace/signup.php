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
  <title>Signup</title> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <link rel="stylesheet" href="activity-styles.css" /> 
</head>
<body>  
  <div>  
    <h1>Signup</h1>
    <form action="signup.php" method="post">     
      Username: <input type="text" name="username" required /> <br/>
      Password: <input type="password" name="pwd" required /> <br/>
      <input type="submit" name ="signupBtn" value="Submit" class="btn" /> <br/>
      <?php if ($attemptedSignup && !$userAvail) { echo("Username already taken.\n"); } ?>
    </form>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
</body>
</html>