<?php

include_once('../db/db_connection.php');

$first_name = trim($_POST['first_name']);
$last_name = trim($_POST['last_name']);
$email = trim($_POST['email']);
$password = md5(trim($_POST['password']));
$date = trim($_POST['date']);
$payment = $_POST['payment'] != '' ? trim($_POST['payment']) : null;

// Check if email already exists
$check_mail_sql = "SELECT * FROM utente u WHERE u.email = '" . $email . "'";
$check_mail_result = mysqli_query($db_connection, $check_mail_sql);

if (mysqli_num_rows($check_mail_result) > 0) {
    header('Location: ../pages/register-customer.php?errors[email_already_exists]=true');
    mysqli_close($db_connection);
    die;
} else {
    $sql = "INSERT INTO utente(nome, cognome, email, password, data_nascita, metodo_pagamento) 
			VALUES('" . $first_name . "', '" . $last_name . "', '" . $email . "', '" . $password . "', '" . $date . "', '" . $payment . "');";

    $result = mysqli_query($db_connection, $sql);
    mysqli_close($db_connection);

    if (!$result) {
        header('Location: ../pages/register-customer.php?errors[registration]=true');
        die;
    } else {
        header('Location: ../pages/login.php?confirmations[registration]=true');
        die;
    }
}

?>