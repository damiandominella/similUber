<?php

include_once('../db/db_connection.php');

$car_id = (int)$_GET['id_car'];
$user_id = (int)$_GET['id_user'];


if (!$car_id || !$user_id) {
    header('Location: ../pages/homepage.php?errors[generic]=true');
    die;
}

// Delete only the association (maybe another user will take the car)
$sql = "DELETE FROM avere WHERE id_conducente = " . (int)$user_id . " AND id_mezzo = " . (int)$car_id;

$result = mysqli_query($db_connection, $sql);
mysqli_close($db_connection);

if (!$result) {
    header('Location: ../pages/homepage.php?errors[delete_car]=true');
    die;
} else {
    header('Location: ../pages/homepage.php?confirmations[delete_car]=true');
    die;
}

?>
