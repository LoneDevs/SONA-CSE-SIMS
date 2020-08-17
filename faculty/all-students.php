<?php
require 'sessionmanager.php';
require 'process.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Students</title>
    <?php

    include '../inc/style.inc.php';

    ?>
</head>

<body>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">All Students</li>
        </ol>
    </nav>
    <br>
    <section class="container-lg container-md container-sm ">
        <div class="cont">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Admission Number</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        session_start();
                        if (isset($_SESSION['faculty'])) {
                            sessionTimer();

                            $students = fetchAllStudents();
                            if (strcmp($students, "failed") === 1) {
                                echo "<h1> Query Failed </h1>";
                                die();
                            } else {
                                echo $students;
                            }
                        } else {
                            echo "<h1>Access Denied !</h1>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <br>
</body>

</html>