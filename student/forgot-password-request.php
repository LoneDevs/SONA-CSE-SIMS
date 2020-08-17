<!DOCTYPE html>
<html lang="en">

<head>
    <title>Forgot Password ?</title>
    <?php

    include '../inc/style.inc.php';

    ?>
</head>

<body>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Forgot Password ?</li>
        </ol>
    </nav>
    <center>
        <?php
        session_start();
        // if  user in session
        if (isset($_SESSION["admnno"])) {
            header("Location: dashboard.php");
        }
        ?>

        <?php
        $title = "Forgot Password Request";
        include '../inc/header.inc.php';
        require 'forgot-password-process.php';
        include '../cleaninput.php';
        require 'csrf.php';

        if (empty($_SESSION['key']))
            $_SESSION['key'] = getKey();

        $csrf = getToken($_SESSION['key']);


        // request posted
        if (isset($_POST['forgot-request'])) {
            if (!hash_equals($csrf, $_POST['csrf'])) {
                csrfError();
                die();
            }
            /*$message = forgotPasswordRequest(cleanInput($_POST['email']));
            if (strcmp($message, "success") == 0) { // if request is success
                echo '<div class="alert alert-success" role="alert">Email sent successfully !</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
            }*/
        }

        ?>
    </center>
    <h1>Feature disabled temporarily !</h1>
<!--    <section class="container-fluid">
        <section class="row justify-content-center">
            <section class="col-12 col-sm-6 col-md-3 ">
                <div class="title">
                    <h1>Sona CSE SIMS </h1>
                </div>

                <form method="post" class="form-container">
                    <input type="hidden" name='csrf' value="<?php //echo $csrf ?>">
                    <div class="form-group">
                        <label for="email">Enter your email to send a password reset link : </label>
                        <input type="email" class="form-control" name="email" id="" aria-describedby="emailHelpId" placeholder="example@sonatech.ac.in" required>
                    </div>

                    <button type="submit" class="btn btn-primary" name="forgot-request">Send Reset link</button>
                </form>
            </section>
        </section>
    </section> --->
</body>


</html>