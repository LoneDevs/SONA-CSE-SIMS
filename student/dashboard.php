<?php
require 'sessionmanager.php';
session_start();
if (!isset($_SESSION['admnno'])) {
    header("Location: login.php");
}
sessionTimer();

?>

<?
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <?php

    include '../inc/style.inc.php';

    ?>
    
    <style>
        .avatar {
            vertical-align: middle;
            width: 20vh;
            height: 20vh;
            border-radius: 50%;
            border:2px solid black;
        }
    </style>

</head>

<body>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>
    <center>
            <br>
            <a href="upload.php"><img src="profile/<?php echo $_SESSION['image'] ?>" alt="" class="avatar"></a>
            <br>
            <h2>Name : <?php echo $_SESSION['name'] ?> </h2>
            <h2>Admission No : <?php echo $_SESSION['admnno'] ?> </h2>
    </center>
    <br>
    <section class="container-lg container-md container-sm ">
        <div class="cont">
            <a href="/student/personal" style="text-decoration: none;">
                <button type="button" class="btn btn-outline-info btn-lg btn-block">Personal</button> </a> <br>
            <a href="/student/family" style="text-decoration: none;">
                <button type="button" class="btn btn-outline-info btn-lg btn-block">Family</button> </a> <br>
            <a href="/student/academic" style="text-decoration: none;">
                <button type="button" class="btn btn-outline-info btn-lg btn-block">Academic</button> </a> <br>
            <a href="/student/extra-curricular" style="text-decoration: none;">
                <button type="button" class="btn btn-outline-info btn-lg btn-block">Extra-Curricular</button> </a><br>
            <a href="/student/co-curricular" style="text-decoration: none;">
                <button type="button" class="btn btn-outline-info btn-lg btn-block">Co-Curricular</button>
            </a> <br><br>
            <div style="text-align: center;">
                <a href="dashboard.php?logout=true" style="text-decoration: none;">
                    <button type="submit" class="btn btn-danger" name="logout">Logout</button>
                </a>
                &nbsp;&nbsp;&nbsp;
                <a href="resetpassword.php" style="text-decoration: none;">
                    <button type="submit" class="btn btn-warning" name="logout">Reset Password</button>
                </a>
            </div>
            <?php
            include '../inc/js.inc.php';
            ?>
        </div>
    </section>
</body>

</html>