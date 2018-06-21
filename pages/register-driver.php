<?php
session_start();

if (isset($_SESSION['email'])) {
    header('Location: homepage.php');
    die;
}

$errors = isset($_GET['errors']) ? $_GET['errors'] : array();
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
    <h4 class="text-center">Registrati come conducente</h4>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-md-push-3 col-lg-6 col-lg-push-3">
            <div class="form-wrapper">

                <?php if ($errors && array_key_exists('email_or_license_already_exists', $errors) && $errors['email_or_license_already_exists']) { ?>
                    <p class="alert alert-danger">L'email o il numero di patente inseriti sono già stata utilizzati</p>
                <?php } ?>

                <?php if ($errors && array_key_exists('registration', $errors) && $errors['registration']) { ?>
                    <p class="alert alert-danger">C'è stato un errore durante la registrazione, riprovare più tardi</p>
                <?php } ?>

                <form action="../controllers/register-driver.php" method="post">
                    <div class="form-group">
                        <label for="first_name">Nome *</label>
                        <input name="first_name" type="text" class="form-control" id="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Cognome *</label>
                        <input name="last_name" type="text" class="form-control" id="last_name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input name="email" type="email" class="form-control" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input name="password" type="password" class="form-control" id="password" required>
                    </div>
                    <div class="form-group">
                        <label for="date">Data di nascita *</label>
                        <input name="date" type="date" class="form-control" id="date" required>
                    </div>
                    <div class="form-group">
                        <label for="license">Numero di patente *</label>
                        <input name="license" type="number" class="form-control" id="license" required>
                    </div>
                    <button type="submit" class="btn btn-block btn-success">Registrati</button>
                </form>
                <a href="login.php">Hai un'account? Vai al login</a>
            </div>
        </div>
    </div>

</div>
</body>

</html>