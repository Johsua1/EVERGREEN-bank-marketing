<?php
$host = "localhost";
$user = "root"; // default for XAMPP
$pass = ""; // leave blank unless you set a password
$db = "evergreen_bank";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

