<?php
require("connect-db.php");
require('Account-db.php');
require('User-db.php');

if (!isset($_SESSION)) {
    session_start();
}

if (!$_SESSION['username']) {
    header("Location: signup.php");
    exit();
} 


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['createProfileBtn'])) {
        $computingID = $_POST['computingID'];
        $name = $_POST['name'];
        $year = $_POST['year'];
        $profilePic = $_FILES['profilePic'];
        $username = $_SESSION['username'];
        createProfile($computingID, $name, $year, $profilePic, $username);
        setSessionVars($username);
        header("Location: home.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">   
  <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- required to handle IE -->
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <title>Create Profile</title> 
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

		form {
			background-color: #fff;
			padding: 30px;
			border-radius: 10px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
			display: flex;
			flex-direction: column;
			align-items: center;
			text-align: center;
		}

		h1 {
			margin: 0 0 30px;
			font-size: 32px;
			font-weight: bold;
		}

		input,
		select {
			padding: 10px;
			margin-bottom: 20px;
			width: 100%;
			box-sizing: border-box;
			border: none;
			border-radius: 5px;
			box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
		}

		textarea {
			padding: 10px;
			margin-bottom: 20px;
			width: 100%;
			box-sizing: border-box;
			border: none;
			border-radius: 5px;
			box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
			resize: none;
			height: 100px;
		}

		button {
			padding: 10px 20px;
			background-color: #333;
			color: #fff;
			border: none;
			border-radius: 5px;
			box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
			cursor: pointer;
			font-size: 16px;
		}

		button:hover {
			background-color: #444;
		}
	</style>
</head>
<body>  
  <div>  
    <form action="createProfile.php" method="post" enctype="multipart/form-data">     
      <h1>Create Profile</h1>
      Computing ID: <input type="text" name="computingID" minlength="6" maxlength="7" required /> <br/>
      Name: <input type="text" name="name" required /> <br/>

      Year: 
      <select name="year" required>
  			<option value="">--Select Year--</option>
  			<option value="1">1</option>
  			<option value="2">2</option>
  			<option value="3">3</option>
  			<option value="4">4</option>
	  </select>

      Profile Picture: <input type="file" name="profilePic" accept="image/png, image/jpeg, image/jpg"> <br/>
      <input type="submit" name ="createProfileBtn" value="Submit" class="btn" /> <br/>
    </form>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
</body>
</html>
