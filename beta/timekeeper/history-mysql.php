<?php
// Should be moved to vault
$host = "35.183.44.111";
$user = "ReadWrite";
$password = "Sg$214497135";
$db = "history";

// Create connection
$conn = new mysqli($host, $user, $password, $db) or die('Error connecting to server: <br>'. mysqli_connect_error());
?>
