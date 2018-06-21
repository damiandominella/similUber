<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    die;
}

$user_id = (int)$_GET['id_user'];

if (!$user_id) {
    header('Location: ../pages/homepage.php?errors[generic]=true');
    die;
}

$errors = isset($_GET['errors']) ? $_GET['errors'] : array();
$confirmations = isset($_GET['confirmations']) ? $_GET['confirmations'] : array();
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
    <h5 class="text-center">Aggiungi un mezzo</h5>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-md-push-3 col-lg-6 col-lg-push-3">
            <div class="form-wrapper">

                <?php if ($errors && array_key_exists('creation', $errors) && $errors['creation']) { ?>
                    <p class="alert alert-danger">C'è stato un errore durante la creazione, riprovare più tardi</p>
                <?php } ?>

                <?php if ($confirmations && array_key_exists('creation', $confirmations) && $confirmations['creation']) { ?>
                    <p class="alert alert-success">Creato con successo!</p>
                <?php } ?>

                <form action="../controllers/add-car.php?id_user=<?php echo $user_id;?>" method="post">
                    <div class="form-group">
                        <label for="brand">Marca *</label>
                        <input name="brand" type="text" class="form-control" id="brand" required>
                    </div>
                    <div class="form-group">
                        <label for="model">Modello *</label>
                        <input name="model" type="text" class="form-control" id="model" required>
                    </div>
                    <div class="form-group">
                        <label for="plate">Targa *</label>
                        <input name="plate" type="text" class="form-control" id="plate" required>
                    </div>
                    <div class="form-group">
                        <label for="seats">Posti disponibili</label>
                        <input name="seats" type="number" class="form-control" id="seats">
                    </div>
                    <div class="form-group">
                        <label for="luggage">Bagagli disponibili</label>
                        <input name="luggage" type="number" class="form-control" id="luggage">
                    </div>
                    <div class="form-group">
                        <label for="animals">Animali permessi?</label>
                        <input name="animals" type="checkbox" class="form-control" id="animals">
                    </div>
                    <button type="submit" class="btn btn-block btn-success">Crea</button>
                </form>
                <a href="homepage.php">Torna alla homepage</a>
            </div>
        </div>
    </div>

</div>
</body>

</html>