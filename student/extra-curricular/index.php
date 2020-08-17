<?php
require '../../cleaninput.php';
require 'process.php';
require 'sessionmanager.php';


session_start();
if (!isset($_SESSION['admnno'])) {
    header("Location: ../login.php");
}
sessionTimer();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Extra Curricular</title>
    <?php

    include '../../inc/style.inc.php';

    ?>
</head>

<body>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Extra-Curricular</li>
        </ol>
    </nav>


    <?php
    // fetch Talents and Achievements info from db
    $talents = fetchStudentTalents($_SESSION['admnno']);
    $achievements = fetchStudentAchievements($_SESSION['admnno']);

    if (strcmp($talents, '&nbsp') === 0 && strcmp($achievements, '&nbsp') === 0) { // if Talent info not filled goto edit.php
        header("Location: edit.php");
    } else {

        echo '
        <br>
        <section class="container-lg container-md container-sm ">
                <div class="cont">
                <h1>Talents</h1>
                <div style="text-align: right;">
                    <h3><a href="edit.php"> <i class="fas fa-edit"></i> </a></h3>
                </div>
                    <div class="accordion" id="Talents">
                        ' . $talents . '
                    </div>
                </div>
            </section>
            ';
    }

    if (strcmp($achievements, '&nbsp') !== 0) {

        echo '
        <br>
        <section class="container-lg container-md container-sm ">
                <div class="cont">
                <h1>Achievements : </h1>
                <div style="text-align: right;">
                    <h3><a href="edit.php"> <i class="fas fa-edit"></i> </a></h3>
                </div>
                    <div class="accordion" id="Achievements">
                        ' . $achievements . '
                    </div>
                </div>
            </section>
            ';
    }


    ?>

    <?php
    include '../../inc/js.inc.php';
    ?>

    <script>
        $('.collapse').collapse();
    </script>
</body>

</html>