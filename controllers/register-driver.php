<?php

include_once('../db/db_connection.php');

$first_name = trim($_POST['first_name']);
$last_name = trim($_POST['last_name']);
$email = trim($_POST['email']);
$password = md5(trim($_POST['password']));
$date = trim($_POST['date']);
$license = trim($_POST['license']);

// Check if email or license number already exists
$check_sql = "SELECT * FROM utente u WHERE u.email = '" . $email . "' OR u.numero_patente = '" . $license . "'";
$check_result = mysqli_query($db_connection, $check_sql);

if (mysqli_num_rows($check_result) > 0) {
    header('Location: ../pages/register-driver.php?errors[email_or_license_already_exists]=true');
    mysqli_close($db_connection);
    die;
} else {
    $sql = "INSERT INTO utente(nome, cognome, email, password, data_nascita, numero_patente) 
			VALUES('" . $first_name . "', '" . $last_name . "', '" . $email . "', '" . $password . "', '" . $date . "', '" . $license . "');";

    $result = mysqli_query($db_connection, $sql);
    mysqli_close($db_connection);

    if (!$result) {
        header('Location: ../pages/register-driver.php?errors[registration]=true');
        die;
    } else {
        header('Location: ../pages/login.php?confirmations[registration]=true');
        die;
    }
}

?>
