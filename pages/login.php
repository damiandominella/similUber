<?php
session_start();

if (isset($_SESSION['email'])) {
    header('Location: homepage.php');
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

    <div class="row">
        <div class="col-sm-12">
            <div class="form-wrapper">

                <?php if ($errors && array_key_exists('bad_credentials', $errors) && $errors['bad_credentials']) { ?>
                    <p class="alert alert-danger">Credenziali errate</p>
                <?php } ?>

                <?php if ($confirmations && array_key_exists('registration', $confirmations) && $confirmations['registration']) { ?>
                    <p class="alert alert-success">Registrazione effettuata! Accedi con i tuoi dati</p>
                <?php } ?>

                <form action="../controllers/login.php" method="post">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input name="email" type="email" class="form-control" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input name="password" type="password" class="form-control" id="password" required>
                    </div>
                    <button type="submit" class="btn btn-block btn-success">Login</button>
                </form>
                <a href="register-customer.php">Non hai un'account? Registrati</a>
                <br/>
                <a href="register-driver.php">Sei un conducente? Registrati come conducente</a>
            </div>
        </div>
    </div>

</div>
</body>

</html>