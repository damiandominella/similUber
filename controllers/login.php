<?php
session_start();

include_once('../db/db_connection.php');

$email = trim($_POST['email']);
$password = md5(trim($_POST['password']));

$sql = "SELECT password FROM utente u WHERE u.email = '" . $email . "' AND u.password = '" . $password . "'";

$result = mysqli_query($db_connection, $sql);
$rows = mysqli_num_rows($result);
mysqli_close($db_connection);

// If user exists, redirect to homepage, else, reload page with errors
if ($rows > 0) {
    $_SESSION['email'] = $email;
    header('Location: ../pages/homepage.php');
    die;
} else {
    header('Location: ../pages/login.php?errors[bad_credentials]=true');
    die;
}

?>

