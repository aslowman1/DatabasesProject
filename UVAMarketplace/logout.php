<?php
require("connect-db.php");

require('Account-db.php');

session_start();
session_destroy();

header("Location: login.php");
exit();
?>