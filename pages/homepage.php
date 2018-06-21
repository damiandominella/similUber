<?php
session_start();
include_once('../db/db_connection.php');

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    die;
}

$errors = isset($_GET['errors']) ? $_GET['errors'] : array();
$confirmations = isset($_GET['confirmations']) ? $_GET['confirmations'] : array();

// Get user by session email
$user_sql = "SELECT * FROM utente u WHERE u.email = '" . $_SESSION['email'] . "'";

$user_result = mysqli_query($db_connection, $user_sql);

if (!$user_result) {
    header('Location: logout.php');
    die;
} else {
    $user = $user_result->fetch_object();
}

if ($user->numero_patente != null) {
    $is_customer = false;
} else {
    $is_customer = true;
}

// Get user reservations
if ($is_customer) {
    $reservations_sql = "SELECT * FROM prenotazione p WHERE p.id_cliente = " . (int)$user->id;
} else {
    $reservations_sql = "SELECT * FROM prenotazione p WHERE p.id_conducente = " . (int)$user->id;
}

$reservations_result = mysqli_query($db_connection, $reservations_sql);

// Get driver cars
if (!$is_customer) {
    $cars_sql = "SELECT * FROM mezzo m LEFT JOIN avere a ON a.id_mezzo = m.id WHERE a.id_conducente = " . (int)$user->id;
    $cars_result = mysqli_query($db_connection, $cars_sql);
}


?>


<html>
<head>
    <title>Uber</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
<div class="container">
    <h1 class="text-center">UBER</h1>
    <h3 class="text-center"><?php echo $user->nome . ' ' . $user->cognome; ?></h3>
    <h5 class="text-center"><?php echo $is_customer ? 'Cliente' : 'Conducente' ?></h5>
    <h5 class="text-center">Punteggio medio: <?php echo $user->feedback ? $user->feedback : 0 ?> / 5</h5>
    <br/>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php if ($errors && array_key_exists('delete', $errors) && $errors['delete']) { ?>
                <p class="alert alert-danger">C'è stato un errore durante l'eliminazione dei dati, riprovare più
                    tardi</p>
            <?php } ?>
            <?php if ($errors && array_key_exists('generic', $errors) && $errors['generic']) { ?>
                <p class="alert alert-danger">C'è stato un errore, riprovare più
                    tardi</p>
            <?php } ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-wrapper">
                <h4 class="form-title">Dati personali:</h4>
                <?php if ($errors && array_key_exists('update', $errors) && $errors['update']) { ?>
                    <p class="alert alert-danger">C'è stato un errore durante l'aggiornamento, riprovare più tardi</p>
                <?php } ?>


                <?php if ($confirmations && array_key_exists('update', $confirmations) && $confirmations['update']) { ?>
                    <p class="alert alert-success">Dati aggiornati con successo!</p>
                <?php } ?>

                <form action="../controllers/update-customer.php?id=<?php echo $user->id; ?>" method="post">
                    <div class="form-group">
                        <label for="first_name">Nome *</label>
                        <input name="first_name" type="text" class="form-control" id="first_name" required
                               value="<?php echo $user->nome; ?>">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Cognome *</label>
                        <input name="last_name" type="text" class="form-control" id="last_name" required
                               value="<?php echo $user->cognome; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input name="email" type="email" class="form-control" id="email" required
                               value="<?php echo $user->email; ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input name="password" type="password" class="form-control" id="password" required>
                    </div>
                    <div class="form-group">
                        <label for="date">Data di nascita *</label>
                        <input name="date" type="date" class="form-control" id="date" required
                               value="<?php echo $user->data_nascita; ?>">
                    </div>
                    <div class="form-group">
                        <label for="payment">Metodo di pagamento</label>
                        <input name="payment" type="text" class="form-control" id="payment"
                               value="<?php echo isset($user->metodo_pagamento) ? $user->metodo_pagamento : ''; ?>">
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Aggiorna dati personali</button>
                </form>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <?php if (mysqli_num_rows($reservations_result) > 0) { ?>
                <div class="form-wrapper">
                    <h4 class="form-title">Prenotazioni effettuate:</h4>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Referenza</th>
                            <th>Accettata</th>
                            <th>Data/ora</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while ($reservation = $reservations_result->fetch_assoc()) { ?>
                            <tr>
                                <td>#<?php echo $reservation['referenza']; ?></td>
                                <td><?php echo $reservation['accettata'] ? 'Si' : 'No'; ?></td>
                                <td><?php echo $reservation['data_ora']; ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>

                    </table>
                </div>
            <?php } ?>
            <br/><br/>
            <?php if (!$is_customer && mysqli_num_rows($cars_result) > 0) { ?>
                <div class="form-wrapper">
                    <div class="form-title">Mezzi in possesso:</div>
                    <?php if ($errors && array_key_exists('delete_car', $errors) && $errors['delete_car']) { ?>
                        <p class="alert alert-danger">C'è stato un errore durante l'eliminazione, riprovare più tardi</p>
                    <?php } ?>

                    <?php if ($confirmations && array_key_exists('delete_car', $confirmations) && $confirmations['delete_car']) { ?>
                        <p class="alert alert-success">Eliminato con successo!</p>
                    <?php } ?>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Marca</th>
                            <th>Modello</th>
                            <th>Targa</th>
                            <th>Posti</th>
                            <th>Bagagli</th>
                            <th>Animali</th>
                            <th>Elimina</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while ($car = $cars_result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $car['marca']; ?></td>
                                <td><?php echo $car['modello']; ?></td>
                                <td><?php echo $car['targa']; ?></td>
                                <td><?php echo $car['num_posti'] ? $car['num_posti'] : 0; ?></td>
                                <td><?php echo $car['num_bagagli'] ? $car['num_bagagli'] : 0; ?></td>
                                <td><?php echo $car['animali'] ? 'Si' : 'No'; ?></td>
                                <td><a href="../controllers/delete-car.php?id_user=<?php echo $user->id; ?>&id_car=<?php echo $car['id_mezzo'];?>" class="btn btn-sm btn-danger">Elimina</a></td>
                            </tr>
                        <?php } ?>
                        </tbody>

                    </table>
                    <a href="add_car.php?id_user=<?php echo $user->id; ?>" class="btn btn-success">Aggiungi</a>
                </div>
            <?php } ?>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <a class="btn btn-warning" href="logout.php">Logout</a>
            <a href="../controllers/delete-customer.php?id=<?php echo $user->id; ?>" class="btn btn-danger">Elimina
                account</a>
        </div>
    </div>

</div>
</body>

</html>
