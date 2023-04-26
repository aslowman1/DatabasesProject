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
	<title>Profile Registration Page</title>
	<style>
		body {
			background-image: url('tundy.jpeg'); 
			background-repeat: no-repeat;
			background-size: cover;
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
			margin: 0;
			padding: 0;
			font-family: Arial, sans-serif;
			font-size: 16px;
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
	<form>
		<h1>Profile Registration</h1>
		<label for="computingID">Computing ID:</label>
		<input type="text" id="computingID" name="computingID" required>
		<label for="name">Name:</label>
		<input type="text" id="name" name="name" required>
		<label for="username">Username:</label>
		<input type="text" id="username" name="username" required>
		<label for="year">Current Year in School:</label>
		<select id="year" name="year">
			<option value="1">1st Year</option>
			<option value="2">2nd Year</option>
			<option value="3">3rd Year</option>
			<option value="4">4th Year</option>
		</select>
		<label for="profilePic">Profile Picture:</label>
		<input type="file" id="profilePic" name="profilePic" accept="image/*" required>
		<button type="submit">Submit</button>
	</form>
</body>
</html>
