<?php

include_once('../db/db_connection.php');

$user_id = (int)$_GET['id_user'];

if (!$user_id) {
    header('Location: ../pages/homepage.php?errors[generic]=true');
    die;
}

$brand = trim($_POST['brand']);
$model = trim($_POST['model']);
$plate = trim($_POST['plate']);
$seats = isset($_POST['seats']) ? (int)$_POST['seats'] : null;
$luggage = isset($_POST['luggage']) ? (int)$_POST['luggage'] : null;
$animals = isset($_POST['animals']) ? 1 : 0;

$sql = "INSERT INTO mezzo(marca, modello, targa, num_posti, num_bagagli, animali) 
			VALUES('" . $brand . "', '" . $model . "', '" . $plate . "', '" . $seats . "', '" . $luggage . "', '" . $animals . "');";

$result = mysqli_query($db_connection, $sql);

if (!$result) {
    mysqli_close($db_connection);
    header('Location: ../pages/add-car.php?errors[creation]=true');
    die;
} else {
    // Associate with user
    $last_id = mysqli_insert_id($db_connection);
    $associate_sql = "INSERT INTO avere(id_conducente, id_mezzo) 
			VALUES('" . $user_id . "', '" . $last_id . "');";

    $associate_result = mysqli_query($db_connection, $associate_sql);

    if ($associate_result) {
        mysqli_close($db_connection);
        header('Location: ../pages/login.php?confirmations[creation]=true');
        die;
    }
}

?>
