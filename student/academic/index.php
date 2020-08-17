<?php
session_start();

require 'process.php';
require 'sessionmanager.php';


if (!isset($_SESSION['admnno'])) {
    header("Location: ../login.php");
}
sessionTimer();

$gpa = fetchStudentGPA($_SESSION['admnno']);//gpa details


$academic = fetchStudentAcademicInfo($_SESSION['admnno']);

if ($academic['filled'] === false) {
    header("Location: edit.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Academic Info</title>
    <?php

    include '../../inc/style.inc.php';

    ?>

</head>

<body>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Academic</li>
        </ol>
    </nav>

    <br>

    <section class="container-lg container-md container-sm ">
        <div class="cont">
            <div style="text-align: right;">
                <h3><a href="edit.php"> <i class="fas fa-edit"></i> </a></h3>
            </div>
            <h1> <b> Academic Info : </b> </h1> <br>
            <h5> <b> Admission : </b> <?php echo $academic['admission'] ?> </h5>
            <h5><b>Tenth School Name :</b> <?php echo $academic['tenth_school_name'] ?></h5>
            <h5><b>Tenth School Place : </b><?php echo $academic['tenth_school_place'] ?></h5>
            <h5><b>Tenth Board :</b> <?php echo $academic['tenth_board'] ?></h5>
            <h5><b>Tenth Medium :</b> <?php echo $academic['tenth_medium'] ?></h5>
            <h5><b>Tenth Year of completion :</b> <?php echo $academic['tenth_completion_year'] ?></h5>
            <h5><b>Tenth Marks :</b> <?php echo $academic['tenth_marks'] ?>%</h5>
            <hr>
            <?php
            if (strcmp($academic['lateral_entry'], "No") === 0) {

            ?>
                <h5><b>HSC instituition name : </b><?php echo $academic['hsc_instituition_name'] ?></h5>
                <h5><b>HSC instituition place : </b><?php echo $academic['hsc_instituition_place'] ?></h5>
                <h5><b>HSC Board :</b> <?php echo $academic['hsc_board'] ?></h5>
                <h5><b>HSC Medium : </b><?php echo $academic['hsc_medium'] ?></h5>
                <h5><b>HSC Group : </b><?php echo $academic['hsc_group'] ?></h5>
                <h5><b>HSC year of completion :</b> <?php echo $academic['hsc_completion_year'] ?></h5>
                <h5><b>HSC Marks : </b><?php echo $academic['hsc_marks'] ?>%</h5>

            <?php
            } else {
            ?>
                <h5><b>Diploma instituition name : </b><?php echo $academic['diploma_instituition_name'] ?></h5>
                <h5><b>Diploma instituition place : </b><?php echo $academic['diploma_instituition_place'] ?></h5>
                <h5><b>Diploma degree : </b><?php echo $academic['diploma_degree'] ?></h5>
                <h5><b>Diploma department : </b><?php echo $academic['diploma_department'] ?></h5>
                <h5><b>Diploma year of completion : </b><?php echo $academic['diploma_completion_year'] ?></h5>
                <h5><b>Diploma percentage : </b><?php echo $academic['diploma_percentage'] ?>%</h5>

            <?php
            }
            ?>
            <hr>
            <h5><b>GPASemster 1 : </b><?php echo $gpa['semester1'] ?></h5>
            <h5><b>GPASemster 2 : </b><?php echo $gpa['semester2'] ?></h5>
            <h5><b>GPASemster 3 : </b><?php echo $gpa['semester3'] ?></h5>
            <h5><b>GPASemster 4 : </b><?php echo $gpa['semester4'] ?></h5>
            <h5><b>GPASemster 5 : </b><?php echo $gpa['semester5'] ?></h5>
            <h5><b>GPASemster 6 : </b><?php echo $gpa['semester6'] ?></h5>
            <h5><b>GPASemster 7 : </b><?php echo $gpa['semester7'] ?></h5>
            <h5><b>GPASemster 8 : </b><?php echo $gpa['semester8'] ?></h5>
        </div>
    </section>
    <br>
</body>

</html>