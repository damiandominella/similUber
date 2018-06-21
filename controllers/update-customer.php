<?php

include_once('../db/db_connection.php');

$user_id = (int)$_GET['id'];

if (!$user_id) {
    header('Location: ../pages/homepage.php?errors[update]=true');
    die;
}

$first_name = trim($_POST['first_name']);
$last_name = trim($_POST['last_name']);
$email = trim($_POST['email']);
$password = md5(trim($_POST['password']));
$date = trim($_POST['date']);
$payment = $_POST['payment'] != '' ? trim($_POST['payment']) : null;

$sql = "UPDATE utente u SET 
        u.nome = '".$first_name."', 
        u.cognome = '".$last_name."', 
        u.email = '".$email."', 
        u.password = '".$password."', 
        u.data_nascita = '".$date."', 
        u.metodo_pagamento = '".$payment."' 
        WHERE u.id = ".(int)$user_id;

$result = mysqli_query($db_connection, $sql);
mysqli_close($db_connection);

if (!$result) {
    header('Location: ../pages/homepage.php?errors[update]=true');
    die;
} else {
    header('Location: ../pages/homepage.php?confirmations[update]=true');
    die;
}

?>