<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Student - Login</title>
    <?php

    include '../inc/style.inc.php';

    ?>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand title" href="login.php"><h1>SONA CSE <span class="badge badge-secondary">SIMS</span></h1></a>
</nav>
    <center>
    <?php
    require '../cleaninput.php'; //clean form inputs
    require 'authenticate.php'; //session timer
    require 'csrf.php';
    if (isset($_GET['expired'])) {
        echo '<div class="alert alert-danger" role="alert"> Session Expired ! </div>';
        //echo '<script>alert("Session Expired !");</script>';
    }

    session_start();
    // if  user in session
    if (empty($_SESSION['key']))
        $_SESSION['key'] = getKey();

    $csrf = getToken($_SESSION['key']);

    if (isset($_SESSION["admnno"])) {
        header("Location: dashboard.php");
    }
    if (isset($_POST['login'])) {
        if (hash_equals($csrf, $_POST['csrf'])) {

            $email = cleanInput($_POST['email']);
            $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
            $result = authenticateStudent($email, $password);
            if (strcmp($result['message'], 'success') == 0) {
                $_SESSION['admnno'] = $result['admnno'];
                $_SESSION['image'] = $result['image'];
                $_SESSION['name'] = $result['name'];
                $_SESSION['session_time'] = time() + 1800; // session time 30mins(1800 sec)
                header("Location: dashboard.php");
            } else {
                echo '<div class="alert alert-danger" role="alert"> ' . $result['message'] . ' ! </div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert"> Invalid CSRF Token </div>';
        }
    }

    ?></center>
    <section class="container-fluid">
        <section class="row justify-content-center">
            <section class="col-12 col-sm-6 col-md-3 ">
                <form class="form-container" action="" method="post" id="loginForm">
                    <h3>Student login</h3>
                    <input type="hidden" name='csrf' value="<?php echo $csrf ?>">
                    <div class="form-group">
                        <label for="email">Email address </label>
                        <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelpId" placeholder="student@sonatech.ac.in">
                    </div>
                    <div class="form-group">
                        <label for="password">Password </label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="password">
                        <small id="emailHelpId" class="form-text text-muted">Forgot Password ? <a href="forgot-password-request.php">Reset</a> </small>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary">
                        Login
                    </button>
                </form>
            </section>
        </section>
    </section>

    <?php
    include '../inc/js.inc.php';
    ?>

    <script>
        $("#loginForm").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    rangelength: [8, 64]
                }
            },
            messages: {
                email: {
                    required: "Email cannot be left empty !",
                    email: "Invalid Email address !"
                },
                password: {
                    required: "Password cannot be left empty !",
                    rangelength: "Your password must be between 8 and 64 characters in length !"
                }
            }

        });
    </script>
    <script>

    </script>
</body>

</html>