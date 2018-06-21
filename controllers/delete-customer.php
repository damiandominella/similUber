<?php

include_once('../db/db_connection.php');

$user_id = (int)$_GET['id'];

if (!$user_id) {
    header('Location: ../pages/homepage.php?errors[update]=true');
    die;
}

// Delete user and associated entities (reservations, cars...)
$sql_accedere = "DELETE FROM accedere WHERE id_cliente = " . (int)$user_id;
$sql_avere = "DELETE FROM avere WHERE id_conducente = " . (int)$user_id;
$sql_effettuare = "DELETE FROM effettuare WHERE id_cliente = " . (int)$user_id;
$sql_prenotazione = "DELETE FROM prenotazione WHERE id_cliente = " . (int)$user_id;
$sql_utente = "DELETE FROM utente WHERE id = " . (int)$user_id;

$result = true;

$result &= (bool)mysqli_query($db_connection, $sql_accedere);
$result &= (bool)mysqli_query($db_connection, $sql_avere);
$result &= (bool)mysqli_query($db_connection, $sql_effettuare);
$result &= (bool)mysqli_query($db_connection, $sql_prenotazione);
$result &= (bool)mysqli_query($db_connection, $sql_utente);

mysqli_close($db_connection);

if (!$result) {
    header('Location: ../pages/homepage.php?errors[delete]=true');
    die;
} else {
    header('Location: ../pages/logout.php');
    die;
}

?>