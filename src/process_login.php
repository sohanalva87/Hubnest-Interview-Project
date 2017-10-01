<?php
include_once 'psl-config.php';
include_once 'functions.php';
session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['user'], $_POST['p'])) {
    $username = $_POST['user'];
    $password = $_POST['p']; // The hashed password.
    if (login($username, $password) == true) {
		// Login success

		header('Location: ../landing_page.php');
		exit;
    }
	else {
        // Login failed
		header('Location: ../index.php?error=1');
		exit;
    }
} else {
    // The correct POST variables were not sent to this page.
    echo 'Invalid Request';
}
?>
