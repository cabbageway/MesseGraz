<?php
session_start();
if(isset($_GET["logout"])){
    $_SESSION['login'] = false;
}
$_SERVER['login'] = false;

$error = false;
$username = 'MCG';
$password = 'Messe2023#';
if (isset($_POST['username']) && isset($_POST['password'])) {
    try {
        if ($_POST['username'] == $username && $_POST['password'] == $password) {
            $_SESSION['login'] = true;
            echo "<script>this.location.href='admin.php';</script>";
        } else {
            $error = true;
        }
    } catch (Exception $e) {
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Login</title>
    <link rel="icon" href="assets/img/messeRel.jpeg">
</head>

<body>
    <section class="vh-100" style="background-color: #e0ebe2;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <form action="adminLogin.php" method="POST">
                                <h3 class="mb-5">Anmelden</h3>
                                <div class="form-outline mb-4">
                                    <input type="text" placeholder="Benutzername" name="username" id="typeEmailX-2" class="form-control form-control-lg" />
                                </div>
                                <div class="form-outline mb-4">
                                    <input type="password" name="password" placeholder="Passwort" id="typePasswordX-2" class="form-control form-control-lg" />
                                </div>
                                <?php if ($error == true) {
                                    echo '<p id="error" style = "color: red"> Benutzername oder Passwort falsch!</p>';
                                } ?>
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>